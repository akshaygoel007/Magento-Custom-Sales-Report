<?php
namespace Venture7\SalesReport\Ui\Component\Listing\Column;

/**
 * Class Integer
 * @package TNW\TriadHQ\Ui\Component\Listing\Column
 */
class Integer extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = (int) $item[$this->getData('name')];
            }
        }

        return $dataSource;
    }
}
