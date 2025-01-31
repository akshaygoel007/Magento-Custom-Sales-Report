<?php
namespace Venture7\CouponReport\Model\ResourceModel\Coupon\Grid;

/**
 * Class Collection
 * @package Venture7\CouponReport\Model\ResourceModel\Coupon
 */
class Collection
    extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
    implements \Magento\Framework\Api\Search\SearchResultInterface
{
    /**
     * @var \Magento\Framework\Api\Search\AggregationInterface
     */
    protected $aggregations;

    /**
     * Collection constructor.
     *
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param $resourceModel
     * @param string $model
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     * @return void
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        $resourceModel = \Magento\SalesRule\Model\ResourceModel\Rule::class,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->_init($model, $resourceModel);
        $this->setMainTable('salesrule');
    }

    /**
     * Define resource model.
     *
     * @return void
     */
    protected function _construct()
    {
        // $this->_init('Magento\SalesRule\Model\Rule', 'Magento\SalesRule\Model\ResourceModel\Report\Rule');
       $this->_init(\Magento\SalesRule\Model\Rule::class, \Magento\SalesRule\Model\ResourceModel\Rule::class);
        $this->_map['fields']['rule_id'] = 'main_table.rule_id';
    }

    /**
     * Initialize collection select.
     *
     * @return $this|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|void
     * @throws \Zend_Db_Select_Exception
     */
    protected function _initSelect()
    {
        // parent::_initSelect();

        // $this->getConnection()->select()
        //     ->from(['sales_coupon'=> $this->getTable('salesrule')])
        //     ->reset(\Magento\Framework\DB\Select::COLUMNS)
        //     ->columns([
        //         'rule_id' => $this->getConnection()->getConcatSql(
        //             [
        //                 'coupon.rule_id',
        //                 '(0)',
        //                 'sales_coupon.rule_id',
        //             ],
        //             '-'
        //         ),
        //         'name' => 'sales_coupon.name',
        //         'code' => 'coupon.code',
        //         'start' => 'sales_coupon.from_date',
        //         'end' => 'sales_coupon.to_date',
        //         'status' => 'sales_coupon.is_active',
        //     ])
        //     ->joinLeft(
        //         ['coupon' => $this->getTable('salesrule_coupon')],
        //         'sales_coupon.rule_id = coupon.rule_id',
        //         '*'
        //     );

        // return $this;
        parent::_initSelect();
 
        $this->getSelect()->joinLeft(
            ['coupon' => $this->getTable('salesrule_coupon')], //2nd table name by which you want to join mail table
            'main_table.rule_id = coupon.rule_id', // common column which available in both table 
            '*' // '*' define that you want all column of 2nd table. if you want some particular column then you can define as ['column1','column2']
        );
		$this->getSelect()->joinLeft(
            ['customer' => $this->getTable('salesrule_customer_group')], //3rd table name by which you want to join mail table
            'main_table.rule_id = customer.rule_id',			// common column which available in both table 
			[
			 'rule_id' => 'customer.rule_id',
			 'customer_group_id' => 'GROUP_CONCAT(DISTINCT customer.customer_group_id)'
			]
             // '*' define that you want all column of 3rd table. if you want some particular column then you can define as ['column1','column2']
        )//->where("main_table.rule_id = '70'" or "main_table.rule_id = '42'")
		->group("main_table.rule_id");
    }

    /**
     * Get aggregations.
     *
     * @return \Magento\Framework\Api\Search\AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * Set aggregations.
     *
     * @param \Magento\Framework\Api\Search\AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
}
