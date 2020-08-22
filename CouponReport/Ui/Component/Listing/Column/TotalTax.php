<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column;

/**
 * Class Percent
 * @package Venture7\CouponReport\Ui\Component\Listing\Column
 */
class TotalTax extends \Magento\Ui\Component\Listing\Columns\Column
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
                if($item['shipping_tax'] != '') {
                    $shippingTax = str_replace("$","",$item['shipping_tax']);
                } else {
                    $shippingTax = $item['shipping_tax'];
                }
                if ($item['item_tax_amount'] != '') {
                    $itemTax = str_replace("$","",$item['item_tax_amount']);
                } else {
                    $itemTax = $item['item_tax_amount'];
                }
                $totalTax = $shippingTax + $itemTax;
                if($totalTax == 0) {
                    $totalTax = '0.00';
                }
                if (strpos($totalTax, '-') !== false) {
                    $totalTax = str_replace("-","-$",$totalTax);
                } else {
                    $totalTax = "$".$totalTax;
                }
                $item['total_tax'] = $totalTax;
            }
        }
        return $dataSource;
    }
}
