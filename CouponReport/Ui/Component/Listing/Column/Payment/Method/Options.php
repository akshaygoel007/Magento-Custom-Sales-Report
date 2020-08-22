<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column\Payment\Method;

/**
 * Class Options
 * @package Venture7\CouponReport\Ui\Component\Listing\Column\Payment\Method
 */
class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var \Venture7\CouponReport\Model\Report
     */
    private $report;

    /**
     * Constructor.
     *
     * @param \Venture7\CouponReport\Model\Report $report
     */
    public function __construct(
        \Venture7\CouponReport\Model\Report $report
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
