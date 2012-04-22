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

class FastDivision_Widgets_Block_Catalog_Bestseller extends Mage_Catalog_Block_Product_Abstract implements Mage_Widget_Block_Interface
{
    protected function _toHtml()
    {
    	$storeId = Mage::app()->getStore()->getId();
        $title = $this->getData('title');
        $categoryId = $this->getData('category_id');
        $displayCount = $this->getData('display_count');

        $statuses = Mage::getSingleton('catalog/product_status')->getVisibleStatusIds();
        $products = Mage::getResourceModel('reports/product_collection')
                        ->addOrderedQty()
                        ->addAttributeToSelect(array('name', 'price', 'small_image'))
                        ->setStoreId($storeId)
                        ->addStoreFilter($storeId)
                        ->setOrder('ordered_qty', 'desc');
        if(isset($categoryId)) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            $products->addCategoryFilter($category);
        }
        $products->addViewsCount();

        $checkedProducts = new Varien_Data_Collection();
        $curPage = 1;

        while(count($checkedProducts) < $displayCount) {
            $products->clear()->setCurPage($curPage)->load();

            if($products->getCurPage() != $curPage) {
                break;
            }

            foreach($products as $k => $p) {
                $p = $p->loadParentProductIds();
                $parentIds = $p->getData('parent_product_ids');

                if(is_array($parentIds) && !empty($parentIds)) {
                    if(!$checkedProducts->getItemById($parentIds[0])) {
                        $parentProduct = Mage::getModel('catalog/product')->setStoreId($storeId)->load($parentIds[0]);
                        if($parentProduct->isVisibleInCatalog()) {
                            $checkedProducts->addItem($parentProduct);
                        }
                    }
                } else {
                    if(!$checkedProducts->getItemById($k)) {
                        $bestseller = Mage::getModel('catalog/product')
                            ->setStoreId($storeId)
                            ->load($p->getId());
                        $checkedProducts->addItem($bestseller);
                    }
                }

                if(count($checkedProducts) >= $displayCount) {
                    break;
                }
            }

            $curPage++;
        }

        $products = $checkedProducts;

        if(isset($displayCount)) {
            $pageSize = $displayCount;
        } else {
            $pageSize = 5;
        }
        
        $this->setProductCollection($products);

        if(isset($title)) {
            $this->setData('title', $this->__('%s', $title));
        } else {
            $this->setData('title', $this->__('Best Sellers'));
        }

        return parent::_toHtml();
    }
}