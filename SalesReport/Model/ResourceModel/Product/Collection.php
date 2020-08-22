<?php
namespace Venture7\SalesReport\Model\ResourceModel\Product;

/**
 * Class Collection
 * @package TNW\TriadHQ\Model\ResourceModel\Product
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
        $resourceModel,
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
    }

    /**
     * Define resource model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magento\Sales\Model\Order\Item', 'Magento\Sales\Model\ResourceModel\Order\Item');
    }

    /**
     * Initialize collection select.
     *
     * @return $this|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|void
     * @throws \Zend_Db_Select_Exception
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        date_default_timezone_set('UTC');

        $orderItems = $this->getConnection()->select()
            ->from(['order_item'=> $this->getTable('sales_order_item')])
            ->reset(\Magento\Framework\DB\Select::COLUMNS)
            ->columns([
                'report_item_id' => $this->getConnection()->getConcatSql(
                    [
                        'order.increment_id',
                        '(0)',
                        'order_item.item_id',
                    ],
                    '-'
                ),
                'order_number' => 'order_item.order_id',
                'increment_order_id' => 'order.increment_id',
                'order_date' => 'order.created_at',
                'creditmemo_number' => '(null)',
                'increment_creditmemo_id' => '(null)',
                'creditmemo_date' => '(null)',
                'payment_date' => 'invoice.updated_at',
                'payment_method' => 'payment.method',
                'customer_name' => $this->getConnection()->getConcatSql(
                    [
                        'order.customer_prefix',
                        'order.customer_firstname',
                        'order.customer_middlename',
                        'order.customer_lastname',
                        'order.customer_suffix',
                    ],
                    ' '
                ),
                'customer_email' => 'order_grid.customer_email',
                'customer_group_code' => 'group.customer_group_code',
				'Salesforce_Customer_ID'=>'wk_salesforce_eshopsync_customer_mapping.sforce_id',
                'sku' => 'order_item.sku',
                'product_id' => 'order_item.product_id',
                'name' => 'order_item.name',
                'qty' => 'order_item.qty_invoiced',
                'row_total' => 'order_item.row_total',
                'creditmemo_adjustment_positive' => '(null)',
                'creditmemo_adjustment_negative' => '(null)',
                'item_discount_amount' => 'order_item.discount_amount',
                'item_tax_amount' => 'order_item.tax_amount',
                'row_total_incl_tax' => 'order_item.row_total_incl_tax',
                'coupon_code' => 'order.coupon_code',
                'discount_amount' => 'order.discount_amount',
                'shipping_amount' => 'order.shipping_amount',
                'shipping_tax' => 'order.shipping_tax_amount',
                'tax_percent' => 'order_item.tax_percent',
                'shipping_city' => 'shipping_address.city',
                'shipping_region' => 'shipping_address.region',
                'billing_city' => 'billing_address.city',
                'billing_region' => 'billing_address.region',
                'total_tax' => '',
                'product_tax_class' => '',
                'order_status' => 'order_grid.status',
                'sub_total' => 'order.subtotal',
                'grand_total' => 'order.grand_total',
            ])
            ->joinLeft(
                ['order' => $this->getTable('sales_order')],
                'order_item.order_id = order.entity_id',
                []
            )
			->joinLeft(
                ['group' => $this->getTable('customer_group')],
                'order.customer_group_id = group.customer_group_id',
                []
            )
            ->joinLeft(
                ['wk_salesforce_eshopsync_customer_mapping' => $this->getTable('wk_salesforce_eshopsync_customer_mapping')],
                'order.customer_id = wk_salesforce_eshopsync_customer_mapping.magento_id',
                []
            )
            ->joinLeft(
                ['shipping_address' => $this->getTable('sales_order_address')],
                'order.shipping_address_id = shipping_address.entity_id',
                []
            )
            ->joinLeft(
                ['billing_address' => $this->getTable('sales_order_address')],
                'order.billing_address_id = billing_address.entity_id',
                []
            )
            ->joinLeft(
                ['payment' => $this->getTable('sales_order_payment')],
                'order.entity_id = payment.parent_id',
                []
            )
            ->joinLeft(
                ['order_grid' => $this->getTable('sales_order_grid')],
                'order.entity_id = order_grid.entity_id',
                []
            )
            ->joinLeft(
                ['invoice' => $this->getTable('sales_invoice_grid')],
                'order_item.order_id = invoice.order_id',
                []
            );

        $memoItems = $this->getConnection()->select()
            ->from(['memo_item'=> $this->getTable('sales_creditmemo_item')])
            ->reset(\Magento\Framework\DB\Select::COLUMNS)
            ->columns([
                'report_item_id' => $this->getConnection()->getConcatSql(
                    [
                        'order.increment_id',
                        '(1)',
                        'memo_item.entity_id',
                    ],
                    '-'
                ),
                'order_number' => 'order.entity_id',
                'increment_order_id' => 'order.increment_id',
                'order_date' => 'order.created_at',
                'creditmemo_number' => 'memo.entity_id',
                'increment_creditmemo_id' => 'memo.increment_id',
                'creditmemo_date' => 'memo.created_at',
                'payment_date' => 'invoice.updated_at',
                'payment_method' => 'invoice.payment_method',
                'customer_name' => 'memo_grid.customer_name',
                'customer_email' => 'order_grid.customer_email',
                'customer_group_code' => 'group.customer_group_code',
				'Salesforce_Customer_ID'=>'wk_salesforce_eshopsync_customer_mapping.sforce_id',
                'sku' => 'memo_item.sku',
                'product_id' => 'memo_item.product_id',
                'name' => 'memo_item.name',
                'qty' => '(-memo_item.qty)',
                'row_total' => '(-memo_item.row_total)',
                'creditmemo_adjustment_positive' => '(-memo.adjustment_positive)',
                'creditmemo_adjustment_negative' => '(-memo.adjustment_negative)',
                'item_discount_amount' => '(-memo_item.discount_amount)',
                'item_tax_amount' => '(-memo_item.tax_amount)',
                'row_total_incl_tax' => '(-memo_item.row_total_incl_tax)',
                'coupon_code' => '(null)',
                'discount_amount' => '(-memo.discount_amount)',
                'shipping_amount' => '(-memo.shipping_amount)',
                'shipping_tax' => '(-memo.shipping_tax_amount)',
                'tax_percent' => '(memo_item.tax_ratio * 100)',
                'shipping_city' => 'shipping_address.city',
                'shipping_region' => 'shipping_address.region',
                'billing_city' => 'billing_address.city',
                'billing_region' => 'billing_address.region',
                'total_tax' => '',
                'product_tax_class' => '',
                'order_status' => 'order_grid.status',
                'sub_total' => '(-memo.subtotal)',
                'grand_total' => '(-memo.grand_total)',
            ])
            ->joinLeft(
                ['memo' => $this->getTable('sales_creditmemo')],
                'memo_item.parent_id = memo.entity_id',
                []
            )
            ->joinLeft(
                ['memo_grid' => $this->getTable('sales_creditmemo_grid')],
                'memo_item.parent_id = memo_grid.entity_id',
                []
            )
            ->joinLeft(
                ['order' => $this->getTable('sales_order')],
                'memo.order_id = order.entity_id',
                []
            )
			->joinLeft(
                ['wk_salesforce_eshopsync_customer_mapping' => $this->getTable('wk_salesforce_eshopsync_customer_mapping')],
                'order.customer_id = wk_salesforce_eshopsync_customer_mapping.magento_id',
                []
            )

            ->joinLeft(
                ['group' => $this->getTable('customer_group')],
                'memo_grid.customer_group_id = group.customer_group_id',
                []
            )
            ->joinLeft(
                ['shipping_address' => $this->getTable('sales_order_address')],
                'memo.shipping_address_id = shipping_address.entity_id',
                []
            )
            ->joinLeft(
                ['billing_address' => $this->getTable('sales_order_address')],
                'memo.billing_address_id = billing_address.entity_id',
                []
            )
            ->joinLeft(
                ['order_grid' => $this->getTable('sales_order_grid')],
                'memo.order_id = order_grid.entity_id',
                []
            )
            ->joinLeft(
                ['invoice' => $this->getTable('sales_invoice_grid')],
                'memo.invoice_id = invoice.entity_id',
                []
            );

        $union = $this->getConnection()->select()
            ->union([$orderItems, $memoItems], \Magento\Framework\DB\Select::SQL_UNION_ALL)
            ->order('report_item_id ' . \Magento\Framework\DB\Select::SQL_DESC);

        if ($this->_mainTable !== null && $union !== $this->_mainTable && $this->getSelect() !== null) {
            $from = $this->getSelect()->getPart(\Magento\Framework\DB\Select::FROM);
            if (isset($from['main_table'])) {
                $from['main_table']['tableName'] = $union;
            }
            $this->getSelect()->setPart(\Magento\Framework\DB\Select::FROM, $from);
        }
        $this->_mainTable = $union;

        return $this;
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
