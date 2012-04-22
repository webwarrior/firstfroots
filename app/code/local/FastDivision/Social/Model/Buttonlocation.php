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

class FastDivision_Social_Model_ButtonLocation {
    public function toOptionArray() {
        return array(
        	array('value'=>'above-reviews-full', 'label'=>Mage::helper('social')->__('Above Review Summary (Full Width)')),
            array('value'=>'beside-reviews', 'label'=>Mage::helper('social')->__('Beside Review Summary (1-2 Buttons)')),
			array('value'=>'below-price', 'label'=>Mage::helper('social')->__('Below Product Price')),
            array('value'=>'below-cart', 'label'=>Mage::helper('social')->__('Below Add to Cart')),
            array('value'=>'add-to-box', 'label'=>Mage::helper('social')->__('Inside Add To Box')),
            array('value'=>'overview','label'=>Mage::helper('social')->__('Inside Overview')),
            array('value'=>'social-media-box','label'=>Mage::helper('social')->__('New Social Media Box'))
        );
    }
}