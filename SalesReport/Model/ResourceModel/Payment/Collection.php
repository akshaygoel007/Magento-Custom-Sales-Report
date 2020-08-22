<?php
namespace Venture7\SalesReport\Model\ResourceModel\Payment;

/**
 * Class Collection
 * @package TNW\TriadHQ\Model\ResourceModel\Payment
 */
class Collection extends \Magento\Sales\Model\ResourceModel\Order\Payment\Collection
{
    /**
     * Initialize collection select.
     *
     * @return $this|\Magento\Sales\Model\ResourceModel\Order\Payment\Collection|void
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()
            ->reset(\Magento\Framework\DB\Select::COLUMNS)
            ->columns(['method', 'additional_information'])
            ->group('method');

        return $this;
    }
}
