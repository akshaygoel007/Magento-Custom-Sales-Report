<?php
namespace Venture7\CouponReport\Controller\Adminhtml\Export;

/**
 * Class GridToCsv
 * @package Venture7\CouponReport\Ui\Component\Adminhtml\Export
 */
class GridToXls extends \Magento\Backend\App\Action
{
    /**
     * @var \Venture7\CouponReport\Model\Report
     */
    private $report;

    
    private $converter;

    
    private $fileFactory;

    
    private $filter;

    
    private $logger;

    

    /**
     * GridToCsv constructor.
     *
     * @param \Venture7\CouponReport\Model\Report $report
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Venture7\CouponReport\Model\Export\ConvertToXls $converter
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Ui\Component\MassAction\Filter|null $filter
     * @param \Psr\Log\LoggerInterface|null $logger
     */
    public function __construct(
        \Venture7\CouponReport\Model\Report $report,
        \Magento\Backend\App\Action\Context $context,
        \Venture7\CouponReport\Model\Export\ConvertToXls $converter,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Ui\Component\MassAction\Filter $filter = null,
        \Psr\Log\LoggerInterface $logger = null
    ) {
        parent::__construct($context);
        $this->report = $report;
        $this->converter = $converter;
        $this->fileFactory = $fileFactory;
        $this->filter = $filter;
        $this->logger = $logger;
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
        $exportFileName = $this->report->getExportFileName('xls');
        return $this->fileFactory->create($exportFileName, $this->converter->getXlsFile(), 'var');
        // return $this->fileFactory->create('export.xls', $this->converter->getXlsFile(), 'var');
    }
}
