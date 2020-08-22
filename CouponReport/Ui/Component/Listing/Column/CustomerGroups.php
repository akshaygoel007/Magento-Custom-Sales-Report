<?php
namespace Venture7\CouponReport\Ui\Component\Listing\Column;

/**
 * Class Percent
 * @package Venture7\CouponReport\Ui\Component\Listing\Column
 */
class CustomerGroups extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
  //  protected $modelGroupFactory;
/*
    public function __construct(
	
        \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $modelGroupFactory
    ) {
        $this->modelGroupFactory = $modelGroupFactory;
    }
*/
	 
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $categories = explode(',' , $item['customer_group_id']);
                $caegoryNames = $this->getCategoryName($categories);
                $item[$this->getData('name')] = (string) $caegoryNames;
            }
        }
        return $dataSource;
    }

    public function getCategoryName($categoryIds) {
	//	$categoryNames = implode(', ' , $categoryIds);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $categoryNames = [];
  /*  
        $groupRepository  = $objectManager->create('\Magento\Customer\Api\GroupRepositoryInterface');
foreach($categoryIds as $Id) {       
	   $customerGroup = $groupRepository->getById($Id);
        $categoryNames[] = $customerGroup->getCode();
}
*/


	$groupCollection  = $objectManager->create('\Magento\Customer\Model\ResourceModel\Group\Collection');
        $groups = $groupCollection->toOptionArray();
	
	foreach($categoryIds as $Id) {
         foreach($groupCollection as $group) {
            if($group->getId() == $Id) {
                 $categoryNames[] = $group->getCustomerGroupCode();
				}
			}
		}

		    $categoryNames = implode(', ' , $categoryNames);
			return $categoryNames;
			//var_dump($categoryNames);
			
	}
       /*

 foreach($categoryIds as $Id) {
     		// $groupRepository  = $objectManager->create('\Magento\Customer\Api\GroupRepositoryInterface');
			$customerGroupsCollection = $objectManager->get('\Magento\Customer\Model\ResourceModel\Group\Collection');
			$customerGroups = $customerGroupsCollection->toOptionArray();
			$group = $groupRepository->getById([$Id]);
			
	            $groupCollection = $objectManager->create('\Magento\Customer\Model\Group')->load($Id);
         $categoryNames[] = $groupCollection>getCustomerGroupCode();//Get current customer group name
		//	$categoryNames[] =$group->getCode(); // $objectManager->create('Magento\Catalog\Model\Category')->load($Id)->getName();
        }
        $categoryNames = implode(', ' , $categoryNames);
        return $categoryNames;
    }

   public function objectToArray($object) {
        return get_object_vars ( $object );
    }

    public function getCategories($object) {
        $condition = $this->objectToArray($object);
        if($condition['aggregator'] == 'any') {
            if($condition['conditions']) {
                $condition = $condition['conditions'][0];
                $condition = $this->objectToArray($condition);
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
            return $categories;
        }
    }
	
	*/
}
