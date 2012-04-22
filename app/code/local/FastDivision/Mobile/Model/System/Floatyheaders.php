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

class FastDivision_Mobile_Model_System_Floatyheaders {
    public function toOptionArray() {
        return array(
            array('value'=>'', 'label'=>Mage::helper('avalanche_mobile')->__('Hide Floatable Header')),
            array('value'=>'#product-header', 'label'=>Mage::helper('avalanche_mobile')->__('Header Bar')),
            array('value'=>'#product-price .price-box', 'label'=>Mage::helper('avalanche_mobile')->__('Price Tag')),              
        );
    }
}