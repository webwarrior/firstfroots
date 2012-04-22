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

class FastDivision_ThemeConfig_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getGoogleFonts()
	{
		$headerFont = Mage::getStoreConfig('avalanche_config/avalanche_design/avalanche_headerfont');
		$bodyFont = Mage::getStoreConfig('avalanche_config/avalanche_design/avalanche_bodyfont');
		$googleFonts = '';

		if(strpos($headerFont, 'Helvetica') === false && strpos($headerFont, 'Lucida Grande') === false) {
			$googleFonts .= $headerFont . ':Regular,Bold';
		}

		if(strpos($bodyFont, 'Helvetica') === false && strpos($bodyFont, 'Lucida Grande') === false && $bodyFont != $headerFont) {
			if($googleFonts != '')
				$googleFonts .= '|';
			$googleFonts .= $bodyFont . ':Regular,Bold';
		}

		return $googleFonts;
	}

	public function getStoreClass()
	{
		if(Mage::getStoreConfigFlag('avalanche_config/avalanche_design/avalanche_customcss')) {
			return 'store-' . strtolower(preg_replace("/[^A-Za-z0-9]/", "", Mage::app()->getStore()->getGroup()->getName())) . '-' . strtolower(preg_replace("/[^A-Za-z0-9]/", "", Mage::app()->getStore()->getName()));
		}
	}

	public function getCleanContent($data)
	{
		$content = $data;

		// Remove empty paragraphs
		$content = preg_replace('#<p[^>]*>(\s|&nbsp;?)*</p>#', '', $content);

		// Remove <br> line breaks
		$content = preg_replace('/<br(\s+)?\/?>/iU', '', $content);

		return $content;
	}
}