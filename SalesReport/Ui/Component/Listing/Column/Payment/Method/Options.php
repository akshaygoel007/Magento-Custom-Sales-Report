<?php
namespace Venture7\SalesReport\Ui\Component\Listing\Column\Payment\Method;

/**
 * Class Options
 * @package TNW\TriadHQ\Ui\Component\Listing\Column\Payment\Method
 */
class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var \TNW\TriadHQ\Model\Report
     */
    private $report;

    /**
     * Constructor.
     *
     * @param \TNW\TriadHQ\Model\Report $report
     */
    public function __construct(
        \Venture7\SalesReport\Model\Report $report
    ) {
        $this->report = $report;
    }

    /**
     * Get options.
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $paymentMethods = $this->report->getPaymentMethodsArray();
            foreach ($paymentMethods as $code => $name) {
                $this->options[$code] = [
                    'value' => $code,
                    'label' => $name,
                ];
            }
        }

        return $this->options;
    }
}
