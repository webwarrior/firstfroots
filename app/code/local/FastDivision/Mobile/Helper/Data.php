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
 
class FastDivision_Mobile_Helper_Data extends Mage_Core_Helper_Abstract
{
    const DEFAULT_PACKAGE = 'avalanche';
    const DEFAULT_THEME = 'mobile';

    protected $_targetPlatform = null;     

    public function getShowDesktop()
    {
        return Mage::getSingleton('customer/session')->getShowDesktop();
    }

    public function setStateChanged()
    {
        Mage::getSingleton('customer/session')->setStateChanged(true);
    }

    public function setForced()
    {
        Mage::getSingleton('customer/session')->setForced(true);
        return $this;
    }

    public function checkForcedDesktop()
    {        
        return Mage::getSingleton('customer/session')->getForced();
    }
    
    public function setShowDesktop($value)
    {
        $this->setStateChanged();
        $this->setForced();
        Mage::getSingleton('customer/session')->setShowDesktop($value);
    }

    public function getTargetPlatform()
    {
        // Validate Package
        $package = Mage::getStoreConfig('design/package/name', Mage::app()->getStore()->getStoreId());
        if($package != "avalanche") {
            return 'desktop';
        }

        if($this->checkDisableOutput()) {
            return 'desktop';
        }
        
        if(!$this->_targetPlatform) {
            $targetPlatform = 'desktop';

            if($this->checkForcedDesktop()) {
                $targetPlatform = $this->getShowDesktop() ? 'desktop' : 'mobile';
            } elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
                $targetPlatform = 'mobile';
            }

            $this->_targetPlatform = $targetPlatform;
        }

        return $this->_targetPlatform;
    }

    public function checkDisableOutput()
    {
        return !!Mage::getStoreConfig('advanced/modules_disable_output/FastDivision_Mobile');
    }

    public function getResizedImageName($imageName, $dimensions)
    {
        $imageExt = substr(strrchr($imageName, '.'), 1);
        return str_replace('.' . $imageExt, '_' . $dimensions . '.' . $imageExt, $imageName);
    }
}
