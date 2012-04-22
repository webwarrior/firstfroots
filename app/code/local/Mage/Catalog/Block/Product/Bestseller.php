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

/**
* Deprecated in 1.3.0 - Use CMS Widgets Instead
*/
class Mage_Catalog_Block_Product_Bestseller extends Mage_Catalog_Block_Product_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $storeId = Mage::app()->getStore()->getId();
        $categoryId = $this->getData('category_id');
        $count = $this->getData('count');

        if(isset($categoryId)) {
            $category = Mage::getModel('catalog/category')->load($this->getData('category_id'));
            $products = Mage::getResourceModel('reports/product_collection')
                ->addOrderedQty()
                ->addAttributeToSelect(array('name', 'price', 'small_image'))
                ->setStoreId($storeId)
                ->addStoreFilter($storeId)
                ->addCategoryFilter($category)
                ->setOrder('ordered_qty', 'desc');
        } else {
            $products = Mage::getResourceModel('reports/product_collection')
                ->addOrderedQty()
                ->addAttributeToSelect(array('name', 'price', 'small_image'))
                ->setStoreId($storeId)
                ->addStoreFilter($storeId)
                ->setOrder('ordered_qty', 'desc');
        }
        
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);

        if(isset($count)) {
            $pageSize = $this->getData('count');
        } else {
            $pageSize = 5;
        }

        $products->setPageSize($pageSize)->setCurPage(1);
        $this->setProductCollection($products);
    }
}