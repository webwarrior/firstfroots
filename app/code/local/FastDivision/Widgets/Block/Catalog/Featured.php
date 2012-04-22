<?php
/**
 * Avalanche for Magento 1.6+
 * Designed by Fast Division (http://fastdivision.com)
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://fastdivision.com/legal/license.txt
 *
 * @author     Fast Division
 * @version    1.3.0
 * @copyright  Copyright 2012 Fast Division
 * @license    http://fastdivision.com/legal/license.txt
 */

class FastDivision_Widgets_Block_Catalog_Featured extends Mage_Catalog_Block_Product_Abstract implements Mage_Widget_Block_Interface
{
    protected function _toHtml()
    {
    	$storeId = Mage::app()->getStore()->getId();
        $title = $this->getData('title');
        $categoryId = $this->getData('category_id');
        $displayCount = $this->getData('display_count');

        if(isset($categoryId)) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            $products = Mage::getResourceModel('reports/product_collection')
                ->addAttributeToSelect(array('name', 'price', 'small_image'))
                ->setStoreId($storeId)
                ->addStoreFilter($storeId)
                ->addCategoryFilter($category)
                ->setOrder('name', 'asc');
        }
        
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);

        if(isset($displayCount)) {
            $pageSize = $displayCount;
        } else {
            $pageSize = 5;
        }

        $products->setPageSize($pageSize)->setCurPage(1);
        $this->setProductCollection($products);

        if(isset($title)) {
            $this->setData('title', $this->__('%s', $title));
        } else {
            $this->setData('title', $this->__('Featured Products'));
        }

        return parent::_toHtml();
    }
}