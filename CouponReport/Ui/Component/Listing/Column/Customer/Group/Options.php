<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column\Customer\Group;

/**
 * Class Options
 * @package Venture7\CouponReport\Ui\Component\Listing\Column\Customer\Group
 */
class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var \Magento\Customer\Model\ResourceModel\Group\CollectionFactory
     */
    protected $modelGroupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $modelPaymentFactory
     */
    public function __construct(
        \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $modelGroupFactory
    ) {
        $this->modelGroupFactory = $modelGroupFactory;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $options = $this->modelGroupFactory->create()->toOptionArray();
            foreach ($options as $option) {
                $this->options[$option['label']] = [
                    'value' => $option['label'],
                    'label' => $option['label'],
                ];
            }
        }

        return $this->options;
    }
}
