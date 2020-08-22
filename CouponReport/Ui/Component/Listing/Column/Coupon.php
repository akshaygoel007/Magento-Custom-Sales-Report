<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column;

/**
 * Class Percent
 * @package Venture7\CouponReport\Ui\Component\Listing\Column
 */
class Coupon extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
   public function prepareDataSource(array $dataSource)
    {
        // if (isset($dataSource['data']['items'])) {
        //     foreach ($dataSource['data']['items'] as &$item) {
        //         // echo "<pre>";
        //         // print_r($item);
        //         $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        //         // if($item[$this->getData('name') == 'code']) {

        //         // }
        //     }
        //     // die;
        // }
        return $dataSource;
    }
}
