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

class FastDivision_Widgets_Block_Catalog_Latest extends Mage_Catalog_Block_Product_Abstract implements Mage_Widget_Block_Interface
{
    protected function _toHtml()
    {
    	$storeId = Mage::app()->getStore()->getId();
        $title = $this->getData('title');
        $categoryId = $this->getData('category_id');
        $displayCount = $this->getData('display_count');

        $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);

        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
        $collection = $this->_addProductAttributesAndPrices($collection)
            ->addStoreFilter()
            ->addAttributeToFilter('news_from_date', array('or'=> array(
                0 => array('date' => true, 'to' => $todayDate),
                1 => array('is' => new Zend_Db_Expr('null')))
            ), 'left')
            ->addAttributeToFilter('news_to_date', array('or'=> array(
                0 => array('date' => true, 'from' => $todayDate),
                1 => array('is' => new Zend_Db_Expr('null')))
            ), 'left')
            ->addAttributeToFilter(
                array(
                    array('attribute' => 'news_from_date', 'is'=>new Zend_Db_Expr('not null')),
                    array('attribute' => 'news_to_date', 'is'=>new Zend_Db_Expr('not null'))
                    )
              );

        if(isset($displayCount)) {
            $pageSize = $displayCount;
        } else {
            $pageSize = 5;
        }

        if(isset($categoryId)) {
            $category = Mage::getModel('catalog/category')->load($this->getData('category_id'));
            $collection->addCategoryFilter($category)
                        ->addAttributeToSort('news_from_date', 'desc')
                        ->setPageSize($pageSize)
                        ->setCurPage(1);
        } else {
            $collection->addAttributeToSort('news_from_date', 'desc')
                        ->setPageSize($pageSize)
                        ->setCurPage(1);           
        }

        $this->setProductCollection($collection);
        
        if(isset($title)) {
            $this->setData('title', $this->__('%s', $title));
        } else {
            $this->setData('title', $this->__('Latest Products'));
        }
        
        return parent::_toHtml();
    }
}