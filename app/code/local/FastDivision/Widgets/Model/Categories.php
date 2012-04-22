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

class FastDivision_Widgets_Model_Categories {
    public function toOptionArray() {
        return $this->_loadTree();
    }

    protected function _buildCategoriesMultiselectValues(Varien_Data_Tree_Node $node, $values, $level = 0) {
        $level++;
        
        $nonEscapableNbspChar = html_entity_decode('&#160;', ENT_NOQUOTES, 'UTF-8');
        $values[$node->getId()]['value'] = $node->getId();
        $values[$node->getId()]['label'] = str_repeat($nonEscapableNbspChar, ($level - 1) * 4) . $node->getName();
        
        foreach($node->getChildren() as $child) {
            $values = $this->_buildCategoriesMultiselectValues($child, $values, $level);
        }
        
        return $values;
    }
    
    protected function _loadTree() {
        $tree = Mage::getResourceSingleton('catalog/category_tree')->load(); 

        $store = 1; 
        $parentId = 1; 
        $tree = Mage::getResourceSingleton('catalog/category_tree')->load();
        $root = $tree->getNodeById($parentId);
        
        if($root && $root->getId() == 1) { 
            $root->setName(Mage::helper('catalog')->__('Root')); 
        }
        
        $collection = Mage::getModel('catalog/category')->getCollection() 
            ->setStoreId($store) 
            ->addAttributeToSelect('name') 
            ->addAttributeToSelect('is_active');
        
        $tree->addCollectionData($collection, true); 

        return $this->_buildCategoriesMultiselectValues($root, array());    
    }
}