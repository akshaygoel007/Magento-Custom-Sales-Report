<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column;

/**
 * Class Percent
 * @package Venture7\CouponReport\Ui\Component\Listing\Column
 */
class ShippingCity extends \Magento\Ui\Component\Listing\Columns\Column
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
            foreach ($dataSource['data']['items'] as &$item) {
                if(empty($item['shipping_city'])) {
                    $item[$this->getData('name')] = (string) $item['billing_region'];
                } else {
                    $item[$this->getData('name')] = (string) $item['shipping_city'];
                }
            }
        }

        return $dataSource;
    }
}
