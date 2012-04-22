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

require_once(Mage::getBaseDir('skin') . '/frontend/avalanche/default/css/framework/lessc.inc.php');

class FastDivision_Mobile_Model_Observer_Style extends Varien_Object 
{
	public function saveConfig($observer) 
	{
		$cssBase = Mage::getBaseDir('skin') . '/frontend/avalanche/mobile/css/';
		$lc = new lessc($cssBase . 'style.less');

		try {
			// Get config variables and parse less file
			$configVars = $this->_getConfigVariables();
			$lessCss = file_get_contents($cssBase . 'style.less');
			$output = $lc->parse($lessCss, $configVars);

			// Save file
			file_put_contents($cssBase . 'style.css', $output);

		} catch (exception $ex) {
			Mage::getSingleton('adminhtml/session')->addException($ex,
                Mage::helper('adminhtml')->__('An error occurred while exporting the stylesheet:') . ' '
                . $ex->getMessage());
		}

		try {
			$touchIconUrl = Mage::getBaseDir('media') . DS . 'touch_icons' . DS . Mage::getStoreConfig('avalanche_mobile/design/touch_icon');
			$this->_resizeTouchIcons($touchIconUrl);
			$splashScreenUrl = Mage::getBaseDir('media') . DS . 'splash_screens' . DS . Mage::getStoreConfig('avalanche_mobile/design/splash_screen');
			$this->_resizeSplashScreen($splashScreenUrl);
		} catch (exception $ex) {
			Mage::getSingleton('adminhtml/session')->addException($ex,
                Mage::helper('adminhtml')->__('An error occurred while resizing the touch icons:') . ' '
                . $ex->getMessage());
		}
	}

	protected function _getConfigVariables()
	{
		$configVars = array();
		$configVars['logo'] = '"' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . 'media/logos/' . Mage::getStoreConfig('avalanche_mobile/design/logo') . '"';
		$configVars['logoRetina'] = '"' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . 'media/logos/' . Mage::getStoreConfig('avalanche_mobile/design/logo_retina') . '"';
		$configVars['primaryColor'] = Mage::getStoreConfig('avalanche_mobile/design/primarycolor');
		$configVars['secondaryColor'] = Mage::getStoreConfig('avalanche_mobile/design/secondarycolor');
		
		return $configVars;
	}

	protected function _resizeTouchIcons($touchIconPath)
	{
		$resizeDimensions = array('72x72', '57x57');

		foreach($resizeDimensions as $dimensions) {
			$resizePath = Mage::getBaseDir('media') . DS . 'touch_icons' . DS . str_replace('.' . $this->_getFileExtension(Mage::getStoreConfig('avalanche_mobile/design/touch_icon')), '_' . $dimensions . '.' . $this->_getFileExtension(Mage::getStoreConfig('avalanche_mobile/design/touch_icon')), Mage::getStoreConfig('avalanche_mobile/design/touch_icon'));
			$dimensions = explode('x', $dimensions);

			if(!file_exists($resizePath) && file_exists($touchIconPath)):
			    $imageObj = new Varien_Image($touchIconPath);
			    $imageObj->constrainOnly(TRUE);
			    $imageObj->keepAspectRatio(TRUE);
			    $imageObj->keepFrame(FALSE);
			    $imageObj->resize($dimensions[0], $dimensions[1]);
			    $imageObj->save($resizePath);
			endif;
		}
	}

	protected function _resizeSplashScreen($splashScreenPath)
	{
		$resizeDimensions = array('320x460');

		foreach($resizeDimensions as $dimensions) {
			$resizePath = Mage::getBaseDir('media') . DS . 'splash_screens' . DS . str_replace('.' . $this->_getFileExtension(Mage::getStoreConfig('avalanche_mobile/design/splash_screen')), '_' . $dimensions . '.' . $this->_getFileExtension(Mage::getStoreConfig('avalanche_mobile/design/splash_screen')), Mage::getStoreConfig('avalanche_mobile/design/splash_screen'));
			$dimensions = explode('x', $dimensions);

			if(!file_exists($resizePath) && file_exists($splashScreenPath)):
			    $imageObj = new Varien_Image($splashScreenPath);
			    $imageObj->constrainOnly(TRUE);
			    $imageObj->keepAspectRatio(TRUE);
			    $imageObj->keepFrame(FALSE);
			    $imageObj->resize($dimensions[0], $dimensions[1]);
			    $imageObj->save($resizePath);
			endif;
		}		
	}

	protected function _getFileExtension($file_name)
	{
		return substr(strrchr($file_name, '.'), 1);
	}
}