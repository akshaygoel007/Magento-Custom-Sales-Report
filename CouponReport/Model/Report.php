<?php
namespace Venture7\CouponReport\Model;

/**
 * Class Report
 * @package Venture7\CouponReport\Model
 */
class Report
{
    /**
     * Get export file name.
     *
     * @param string $extension
     * @return string
     */
    public function getExportFileName($extension = '')
    {
        return date('Y-m-d_H-i-s') . '_coupon.' . $extension;
    }
}
