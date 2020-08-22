<?php
namespace Venture7\SalesReport\Model;

/**
 * Class Report
 * @package TNW\TriadHQ\Model
 */
class Report
{
    /**
     * @var \TNW\TriadHQ\Model\ResourceModel\Payment\CollectionFactory
     */
    protected $modelPaymentFactory;

    /**
     * Constructor.
     *
     * @param \TNW\TriadHQ\Model\ResourceModel\Payment\CollectionFactory $modelPaymentFactory
     */
    public function __construct(
        \Venture7\SalesReport\Model\ResourceModel\Payment\CollectionFactory $modelPaymentFactory
    ) {
        $this->modelPaymentFactory = $modelPaymentFactory;
    }

    /**
     * Get export file name.
     *
     * @param string $extension
     * @return string
     */
    public function getExportFileName($extension = '')
    {
        return date('Y-m-d_H-i-s') . '_product.' . $extension;
    }

    /**
     * Get an array of payment methods from order payments.
     *
     * @return array
     */
    public function getPaymentMethodsArray()
    {
        $paymentMethodsArray = [];
        $paymentMethods = $this->modelPaymentFactory->create();
        $paymentMethods = $paymentMethods->getData();
        foreach ($paymentMethods as $paymentMethod) {
            $additionalInformation = json_decode($paymentMethod['additional_information']);
            $code = $paymentMethod['method'];
            $name = !empty($additionalInformation->method_title)
                ? $additionalInformation->method_title
                : $code;
            $paymentMethodsArray[$code] = $name;
        }

        return $paymentMethodsArray;
    }
}
