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

class FastDivision_ThemeConfig_Model_Observer extends Varien_Object 
{
	public function saveConfig($observer)
	{
		$configVars = $this->_getConfigVariables();
		$this->_getStyle($configVars);
		$this->_getSprite(str_replace('#', '', $configVars['primaryColor']));
		$this->_getStars(str_replace('#', '', $configVars['starColor']));
	}

	protected function _getConfigVariables()
	{
		$configVars = array();
		$configVars['headerFont'] = Mage::getStoreConfig('avalanche_config/avalanche_design/avalanche_headerfont');
		$configVars['bodyFont'] = Mage::getStoreConfig('avalanche_config/avalanche_design/avalanche_bodyfont');
		$configVars['primaryColor'] = Mage::getStoreConfig('avalanche_config/avalanche_design/avalanche_primarycolor');
		$configVars['primaryColorName'] = 'red';
		$configVars['secondaryColor'] = Mage::getStoreConfig('avalanche_config/avalanche_design/avalanche_secondarycolor');
		$configVars['pageBackground'] = Mage::getStoreConfig('avalanche_config/avalanche_design/avalanche_background');
		$configVars['borderRadius'] = Mage::getStoreConfig('avalanche_config/avalanche_design/avalanche_borderradius') . 'px';
		$configVars['starColor'] = Mage::getStoreConfig('avalanche_config/avalanche_design/avalanche_starcolor');
		$configVars['googleFonts'] = '';
		
		if(strpos($configVars['headerFont'], 'Helvetica') === false && strpos($configVars['headerFont'], 'Lucida Grande') === false) {
			$configVars['googleFonts'] .= $configVars['headerFont'] . ':Regular,Bold';
			$configVars['headerFont'] .= ',Arial,Helvetica,sans-serif';
		} else {
			$fontFamily = explode('/', $configVars['headerFont']);
			$configVars['headerFont'] = '';
			foreach($fontFamily as $font) {
				if($configVars['headerFont'] != '')
					$configVars['headerFont'] .= ', ';
				$configVars['headerFont'] .= $font;
			}
		}
		if(strpos($configVars['bodyFont'], 'Helvetica') === false && strpos($configVars['bodyFont'], 'Lucida Grande') === false && $configVars['bodyFont'] != $configVars['headerFont']) {
			if($configVars['googleFonts'] != '')
				$configVars['googleFonts'] .= '|';
			$configVars['googleFonts'] .= $configVars['bodyFont'] . ':Regular,Bold';
			$configVars['bodyFont'] .= ',Arial,Helvetica,sans-serif';
		} else {
			$fontFamily = explode('/', $configVars['bodyFont']);
			$configVars['bodyFont'] = '';
			foreach($fontFamily as $font) {
				if($configVars['bodyFont'] != '')
					$configVars['bodyFont'] .= ', ';
				$configVars['bodyFont'] .= $font;
			}
		}

		return $configVars;
	}

	protected function _getStyle($configVars)
	{
		$cssBase = Mage::getBaseDir('skin') . '/frontend/avalanche/default/css/';
		$lc = new lessc($cssBase . 'style.less');

		try {
			$lessCss = file_get_contents($cssBase . 'style.less');
			$output = $lc->parse($lessCss, $configVars);
			file_put_contents($cssBase . 'style.css', $output);
		} catch (exception $ex) {
			Mage::getSingleton('adminhtml/session')->addException($ex,
                Mage::helper('adminhtml')->__('An error occurred while exporting the stylesheet:') . ' '
                . $ex->getMessage());
		}
	}

	protected function _getSprite($hex)
	{
		try {
			$ch = curl_init('http://fastdivision.com/services/avalanche/customization/sprite.php?type=sprite&hex=' . $hex);
			$fp = fopen(Mage::getBaseDir('skin') . '/frontend/avalanche/default/images/sprite.png', 'wb');
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			fclose($fp);
		} catch (exception $ex) {
			Mage::getSingleton('adminhtml/session')->addException($ex,
                Mage::helper('adminhtml')->__('An error occurred while recoloring the sprite:') . ' '
                . $ex->getMessage());			
		}
	}

	protected function _getStars($hex)
	{
		try {
			$ch = curl_init('http://fastdivision.com/services/avalanche/customization/sprite.php?type=stars&hex=' . $hex);
			$fp = fopen(Mage::getBaseDir('skin') . '/frontend/avalanche/default/images/stars.png', 'wb');
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			fclose($fp);
		} catch (exception $ex) {
			Mage::getSingleton('adminhtml/session')->addException($ex,
                Mage::helper('adminhtml')->__('An error occurred while recoloring the rating stars:') . ' '
                . $ex->getMessage());			
		}		
	}
}