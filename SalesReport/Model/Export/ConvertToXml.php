<?php
namespace Venture7\SalesReport\Model\Export;

/**
 * Class ConvertToXml
 * @package TNW\TriadHQ\Model\Export
 */
class ConvertToXml extends \Magento\Ui\Model\Export\ConvertToXml
{
    /**
     * ConvertToXml constructor.
     *
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param MetadataProvider $metadataProvider
     * @param \Magento\Framework\Convert\ExcelFactory $excelFactory
     * @param \Magento\Ui\Model\Export\SearchResultIteratorFactory $iteratorFactory
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Ui\Component\MassAction\Filter $filter,
        MetadataProvider $metadataProvider,
        \Magento\Framework\Convert\ExcelFactory $excelFactory,
        \Magento\Ui\Model\Export\SearchResultIteratorFactory $iteratorFactory
    ) {
        parent::__construct($filesystem, $filter, $metadataProvider, $excelFactory, $iteratorFactory);
    }
}
