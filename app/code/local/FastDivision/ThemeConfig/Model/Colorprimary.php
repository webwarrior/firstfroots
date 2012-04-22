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

class FastDivision_ThemeConfig_Model_ColorPrimary {
    public function toOptionArray() {
        return array(
            array('value'=>'cd1f0b::red', 'label'=>Mage::helper('themeconfig')->__('Red')),
            array('value'=>'ffb400::orange', 'label'=>Mage::helper('themeconfig')->__('Orange')),
            array('value'=>'ffe866::yellow', 'label'=>Mage::helper('themeconfig')->__('Yellow')),            
            array('value'=>'66cc33::green', 'label'=>Mage::helper('themeconfig')->__('Green')),
			array('value'=>'66ccff::blue', 'label'=>Mage::helper('themeconfig')->__('Blue')),
			array('value'=>'cc66ff::purple', 'label'=>Mage::helper('themeconfig')->__('Purple')),
			array('value'=>'ff66b9::pink', 'label'=>Mage::helper('themeconfig')->__('Pink')),                  
        );
    }
}