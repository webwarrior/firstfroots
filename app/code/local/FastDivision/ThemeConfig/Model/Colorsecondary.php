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

class FastDivision_ThemeConfig_Model_ColorSecondary {
    public function toOptionArray() {
        return array(
            array('value'=>'eb2b2b::ff6666::red', 'label'=>Mage::helper('themeconfig')->__('Red')),
            array('value'=>'c87400::eb9b00::orange', 'label'=>Mage::helper('themeconfig')->__('Orange')),
            array('value'=>'c2bb00::e0d300::yellow', 'label'=>Mage::helper('themeconfig')->__('Yellow')),            
            array('value'=>'5aa900::6ecb00::green', 'label'=>Mage::helper('themeconfig')->__('Green')),
			array('value'=>'0066cc::3399ff::blue', 'label'=>Mage::helper('themeconfig')->__('Blue')),
			array('value'=>'9400c8::9c00d2::purple', 'label'=>Mage::helper('themeconfig')->__('Purple')),
			array('value'=>'ff66b9::ff9ad1::pink', 'label'=>Mage::helper('themeconfig')->__('Pink')),           
        );
    }
}