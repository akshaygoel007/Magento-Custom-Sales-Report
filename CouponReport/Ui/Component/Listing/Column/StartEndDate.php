<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column;

/**
 * Class Integer
 * @package Venture7\CouponReport\Ui\Component\Listing\Column
 */
class StartEndDate extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
		 $date_col_name = $this->getData('name');
		 if (isset($dataSource['data']['items'])) {
           foreach ($dataSource['data']['items'] as &$item) {
			   $item['from_date'] =  $this->prepareItem($item['from_date']);
			   $item['to_date'] =  $this->prepareItem($item['to_date']);
           }
       }
       return $dataSource;
    }
	 protected function prepareItem($curDate)
    {
        $content = '';
		if ((isset($curDate) && $curDate!='') )
		{
			$content = date_format(date_create($curDate), 'M d,Y'); // $this->prepareItem($item);
		}
		return $content;
		
		
		/*
        $date = $item[$this->getData('name')];

        if (empty($date)) {
            return '';
        }

        $content .= date_format(date_create($date), 'M d,Y');

        return $content;
		*/
    }
}
