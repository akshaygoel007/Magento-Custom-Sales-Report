<?php
namespace Venture7\SalesReport\Model\Export;

/**
 * Class MetadataProvider
 * @package TNW\TriadHQ\Model\Export
 */
class MetadataProvider extends \Magento\Ui\Model\Export\MetadataProvider
{
    /**
     * @var \TNW\TriadHQ\Model\Report
     */
    private $report;

    /**
     * MetadataProvider constructor.
     *
     * @param \TNW\TriadHQ\Model\Report $report
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     * @param \TNW\TriadHQ\Model\ResourceModel\Payment\CollectionFactory $modelPaymentFactory
     * @param string $dateFormat
     * @param array $data
     */
    public function __construct(
        \Venture7\SalesReport\Model\Report $report,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        \Venture7\SalesReport\Model\ResourceModel\Payment\CollectionFactory $modelPaymentFactory,
        $dateFormat = 'Y-m-d H:i:s',
        array $data = []
    ) {
        parent::__construct($filter, $localeDate, $localeResolver, $dateFormat, $data);
        $this->report = $report;
    }

    /**
     * Returns columns list.
     *
     * @param \Magento\Framework\View\Element\UiComponentInterface $component
     * @return \Magento\Framework\View\Element\UiComponentInterface[]
     * @throws \Exception
     */
    protected function getColumns(\Magento\Framework\View\Element\UiComponentInterface $component)
    {
        if (!isset($this->columns[$component->getName()])) {
            $columns = $this->getColumnsComponent($component);
            foreach ($columns->getChildComponents() as $column) {
                if ($column->getData('config/label')) {
                    $this->columns[$component->getName()][$column->getName()] = $column;
                }
            }
        }

        return $this->columns[$component->getName()];
    }

    /**
     * Returns row data.
     *
     * @param \Magento\Framework\Api\Search\DocumentInterface $document
     * @param array $fields
     * @param array $options
     * @return array
     */
    public function getRowData(\Magento\Framework\Api\Search\DocumentInterface $document, $fields, $options)
    {
        $row = [];
        $paymentMethods = $this->report->getPaymentMethodsArray();
        foreach ($fields as $column) {
            if (isset($options[$column])) {
                $key = $document->getCustomAttribute($column)->getValue();
                if (isset($options[$column][$key])) {
                    $row[] = $options[$column][$key];
                } else {
                    $row[] = '';
                }
            } else {
                $value = $document->getCustomAttribute($column)->getValue();
                if (($column == 'payment_method') && array_key_exists($value, $paymentMethods)) {
                    $row[] = $paymentMethods[$value];
                } else if($column == 'total_tax') {
                    $row[] = $document->getCustomAttribute('shipping_tax')->getValue() + $document->getCustomAttribute('item_tax_amount')->getValue();
                } else if($column == 'shipping_city') {
                    if(!$value) {
                        $row[] = $document->getCustomAttribute('billing_city')->getValue();
                    } else {
                        $row[] = $value;
                    }
                } else if($column == 'shipping_region') {
                    if(!$value) {
                        $row[] = $document->getCustomAttribute('billing_region')->getValue();
                    } else {
                        $row[] = $value;
                    }
                } else if($column == 'product_tax_class') {
                    $row[] = $this->getProductTaxClass($document->getCustomAttribute('product_id')->getValue());
                } else if($column == 'tax_percent') {
                    $row[] = $document->getCustomAttribute('tax_percent')->getValue().'%';
                } else {
                    $row[] = $value;
                }
            }
        }

        return $row;
    }

    public function getProductTaxClass($producId) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->create('Magento\Catalog\Model\Product')->load($producId);
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
        return $item['product_tax_class'];
    }
}
