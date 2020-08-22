<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column;

/**
 * Class ReportAction
 * @package Venture7\CouponReport\Ui\Component\Listing\Column
 */
class ReportAction extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $labelField = $this->getData('config/labelField') ?: 'entity_id';
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[$labelField])) {
                    $urlPath = $this->getData('config/urlPath') ?: '#';
                    $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: 'entity_id';
                    $urlEntityParamField = $this->getData('config/urlEntityParamField') ?: 'entity_id';
                    $actionType = $this->getData('config/actionType') ?: 'view';
                    $urlParams = [];
                    $urlParams[$urlEntityParamName] = $item[$urlEntityParamField];
                    if ($this->getData('config/sendStoreId')) {
                        $urlParams['store'] = $this->context->getFilterParam('store_id');
                    }
                    $item[$this->getData('name')] = [
                        $actionType => [
                            'href' => $this->urlBuilder->getUrl($urlPath, $urlParams),
                            'target' => '_blank',
                            'label' => $item[$labelField],
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
