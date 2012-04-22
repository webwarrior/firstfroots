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
 
class FastDivision_Mobile_Model_Observer_Mobile extends Varien_Object 
{
    protected $_mobileVal = '';
    protected $_themeFolders = array('layout', 'template', 'skin');

    protected function _initMobile() 
    {
        Mage::getSingleton('core/design_package')->setPackageName('avalanche');
        
        foreach($this->_themeFolders as $type) {
            Mage::getSingleton('core/design_package')->setTheme('mobile');
        }

        return $this;
    }
    
    protected function _checkMobile()
    {
        $result = true;
        foreach($this->_themeFolders as $folder) {
            if(Mage::app()->getStore()->getConfig('design/theme/' . $folder) != $this->_mobileVal) {
                $result = false;
            }
        }
        return $result;
    }

    public function predispatch($event) 
    {
        if(Mage::getDesign()->getArea() == 'adminhtml') {
            return;
        }

        if(Mage::helper('avalanche_mobile')->getTargetPlatform() == 'mobile') {
            $this->_initMobile();
        }
    }
}