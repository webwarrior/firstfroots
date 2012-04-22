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

class FastDivision_Widgets_Block_Catalog_Menu extends Mage_Catalog_Block_Product_Abstract implements Mage_Widget_Block_Interface
{
    protected function _toHtml()
    {
        $menu = Mage::getBlockSingleton('catalog/navigation')->renderCategoriesMenuHtml(0, 'level-top', 'dropdown');
        $this->setData('menu', $menu);
        
        return parent::_toHtml();
    }
}