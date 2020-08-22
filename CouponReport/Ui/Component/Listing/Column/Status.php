<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column;

/**
 * Class Integer
 * @package Venture7\CouponReport\Ui\Component\Listing\Column
 */
class Status extends \Magento\Ui\Component\Listing\Columns\Column
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
            $is_active = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
				if (isset($item[$is_active])) {
                   // $item[$discount_amount] = round($item[$discount_amount]);
						if($item['is_active']=='1')
						 $item[$is_active] ='Active';
						else
						$item[$is_active] ='Inactive';
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
