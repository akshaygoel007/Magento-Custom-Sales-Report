<?php
namespace Venture7\SalesReport\Ui\Component\Listing\Column;

/**
 * Class Percent
 * @package TNW\TriadHQ\Ui\Component\Listing\Column
 */
class Percent extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
   public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $previousValue = null;
            foreach ($dataSource['data']['items'] as &$item) {
             	if($this->getData('name')=='total_tax')
					{
						$item['total_tax'] = (float)$item['item_tax_amount']+(float)$item['shipping_tax'];
					}
                $item[$this->getData('name')] = (float) $item[$this->getData('name')] . '%';
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $product = $objectManager->create('Magento\Catalog\Model\Product')->load($item['product_id']);
                $taxClassObj = $objectManager->create('Magento\Tax\Model\TaxClass\Source\Product');
                $taxClasColection = $taxClassObj->getAllOptions();
                foreach($taxClasColection as $taxClass) {
                    if(!$product->getTaxClassId()) {
                        $item['product_tax_class'] = 'None';
                    } else if(is_object($taxClass['value'])) {
                        if($product->getTaxClassId() == $taxClass['value']->getText()) {
                            if(is_object($taxClass['label'])) {
                                $item['product_tax_class'] = $taxClass['label']->getText();
                            } else {
                                $item['product_tax_class'] = $taxClass['label']; 
                            }
                        }
                    } else {
                        if($product->getTaxClassId() == $taxClass['value']) {
                            if(is_object($taxClass['label'])) {
                                $item['product_tax_class'] = $taxClass['label']->getText();
                            } else {
                                $item['product_tax_class'] = $taxClass['label']; 
                            }
                        }
                    }
                }
                if($previousValue) {
                    if($previousValue['order_number'] == $item['order_number']) {
                        $item['total_tax'] = '';
                    }
                }
                $orderDate = strtotime($item['order_date']);
                date_default_timezone_set("UTC");
                $item['order_date'] = date("Y-m-d H:i:s", $orderDate);
                $previousValue = $item;
            }
        }
        return $dataSource;
    }
}
