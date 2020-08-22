<?php
namespace Venture7\SalesReport\Controller\Adminhtml\Export;

/**
 * Class GridToCsv
 * @package TNW\TriadHQ\Ui\Component\Adminhtml\Export
 */
class GridToCsv extends \Magento\Ui\Controller\Adminhtml\Export\GridToCsv
{
    /**
     * @var \TNW\TriadHQ\Model\Report
     */
    private $report;

    /**
     * GridToCsv constructor.
     *
     * @param \TNW\TriadHQ\Model\Report $report
     * @param \Magento\Backend\App\Action\Context $context
     * @param \TNW\TriadHQ\Model\Export\ConvertToCsv $converter
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Ui\Component\MassAction\Filter|null $filter
     * @param \Psr\Log\LoggerInterface|null $logger
     */
    public function __construct(
        \Venture7\SalesReport\Model\Report $report,
        \Magento\Backend\App\Action\Context $context,
        \Venture7\SalesReport\Model\Export\ConvertToCsv $converter,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Ui\Component\MassAction\Filter $filter = null,
        \Psr\Log\LoggerInterface $logger = null
    ) {
        parent::__construct($context, $converter, $fileFactory, $filter, $logger);
        $this->report = $report;
    }

    /**
     * Export data provider to CSV.
     *
     * @return \Magento\Framework\App\ResponseInterface
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $exportFileName = $this->report->getExportFileName('csv');
        return $this->fileFactory->create($exportFileName, $this->converter->getCsvFile(), 'var');
    }
}
