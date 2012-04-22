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
 
require_once 'Mage/Cms/controllers/IndexController.php';

class FastDivision_Mobile_Cms_IndexController extends Mage_Cms_IndexController
{
    public function indexAction($coreRoute = null)
    {
    	if(Mage::helper('avalanche_mobile')->getTargetPlatform() != 'mobile') {
    		parent::indexAction();
    	} else {
    		// If mobile, show different CMS homepage
	    	$pageId = Mage::getStoreConfig('avalanche_mobile/general/mobile_cms_home_page');
	        if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
	            $this->_forward('defaultIndex');
	        }    		
    	}
    }
}