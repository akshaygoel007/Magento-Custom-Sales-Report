<?php
namespace Venture7\CouponReport\Model\Export;

/**
 * Class ConvertToCsv
 * @package Venture7\CouponReport\Model\Export
 */
use Magento\Ui\Model\Export\MetadataProvider;
class ConvertToCsv extends \Magento\Ui\Model\Export\ConvertToCsv
{
    /**
     * ConvertToCsv constructor.
     *
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param MetadataProvider $metadataProvider
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Ui\Component\MassAction\Filter $filter,
        MetadataProvider $metadataProvider
    ) {
        parent::__construct($filesystem, $filter, $metadataProvider);
    }
}
