<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column;

/**
 * Class Percent
 * @package Venture7\CouponReport\Ui\Component\Listing\Column
 */
class Categories extends \Magento\Ui\Component\Listing\Columns\Column
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
            /*foreach ($dataSource['data']['items'] as &$item) {
				$exculdeStr='';
				if(strpos($item['conditions_serialized'],'"attribute":"category_ids"'))
				{
					 $item[$this->getData('name')] ='';
				}
				else
				{
					if(strpos($item['conditions_serialized'],'"operator":"!="'))
					{
						$exculdeStr='All categories excluding: ';
					}
					$conditionObject = json_decode($item['conditions_serialized']);
					$categories = $this->getCategories($conditionObject);
					$categories = explode(',' , $categories);
					$caegoryNames = $this->getCategoryName($categories);
					$item[$this->getData('name')] =$exculdeStr. (string) $caegoryNames;
				}
            }*/
			foreach ($dataSource['data']['items'] as &$item) {
				$exculdeStr='';
					if(strpos($item['conditions_serialized'],'"attribute":"category_ids"'))
					{
					 $item[$this->getData('name')] ='';
					}
					if(strpos($item['conditions_serialized'],'"operator":"!="'))
					{
						$exculdeStr='All categories excluding: ';
					}
					$conditionObject = json_decode($item['conditions_serialized']);
					$categories = $this->getCategories($conditionObject);
					$categories = explode(',' , $categories);
					$caegoryNames = $this->getCategoryName($categories);
					$item[$this->getData('name')] =$exculdeStr. (string) $caegoryNames;
            }
        }
        return $dataSource;
    }

    public function getCategoryName($categoryIds) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $categoryNames = [];
        foreach($categoryIds as $Id) {
            $categoryNames[] = $objectManager->create('Magento\Catalog\Model\Category')->load($Id)->getName();
        }
        $categoryNames = implode(', ' , $categoryNames);
        return $categoryNames;
    }

    public function objectToArray($object) {
        return get_object_vars ( $object );
    }

    public function getCategories($object) {
		$categories='';
        $condition = $this->objectToArray($object);
		if(!array_key_exists('conditions', $condition)) 
				return $categories;

		//echo "<pre>";
		//print_r($condition['aggregator']);
		
		//var_dump($condition['aggregator']);
        /*if($condition['aggregator'] == 'any' || $condition['aggregator'] == 'all') {
            if($condition['conditions']) {
                $condition = $condition['conditions'][0];
				
                $condition = $this->objectToArray($condition);
				if(array_key_exists('conditions', $condition)) {
                if($condition['conditions']) {
                    $condition = $condition['conditions'][0];
                    $condition = $this->objectToArray($condition);
					
                    if(array_key_exists('conditions', $condition)) {
                        $condition = $condition['conditions'][0];
                        $condition = $this->objectToArray($condition);
                        $categories = $condition['value'];
                    } else {
                        $categories = $condition['value'];
                    }
                }
				}
            }
            return $categories;
        }
		*/
	if($condition['aggregator'] == 'all' || $condition['aggregator'] == 'any') {
            if($condition['conditions']) {
                $condition = $condition['conditions'][0];
				
                $condition = $this->objectToArray($condition);
				if(array_key_exists('conditions', $condition)) {
                if($condition['conditions']) {
                    $condition = $condition['conditions'][0];
                    $condition = $this->objectToArray($condition);
					
                    if(array_key_exists('conditions', $condition)) {
                        $condition = $condition['conditions'][0];
                        $condition = $this->objectToArray($condition);
                        $categories = $condition['value'];
                    } else {
                        $categories = $condition['value'];
                    }
                }
				}
				
            }
            return $categories;
        }
    }
}
