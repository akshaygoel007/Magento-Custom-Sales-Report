<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column;

/**
 * Class Integer
 * @package Venture7\CouponReport\Ui\Component\Listing\Column
 */
class Integer extends \Magento\Ui\Component\Listing\Columns\Column
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
            $discount_amount = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
				if (isset($item[$discount_amount])) {
                    $item[$discount_amount] = round($item[$discount_amount]);
						if($item['simple_action']=='by_percent')
						 $item[$discount_amount] =$item[$discount_amount] .'%';
						else
						$item[$discount_amount] ='$'.$item[$discount_amount];
				}
            }
        }
        /*if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = (int) $item[$this->getData('name')];
            }
        }*/

        return $dataSource;
    }
}
