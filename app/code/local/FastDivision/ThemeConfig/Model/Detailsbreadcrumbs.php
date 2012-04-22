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

class FastDivision_ThemeConfig_Model_Detailsbreadcrumbs {
    public function toOptionArray() {
        return array(
            array('value'=>1, 'label'=>Mage::helper('themeconfig')->__('Show Breadcrumbs')),
            array('value'=>2, 'label'=>Mage::helper('themeconfig')->__('Hide Breadcrumbs')),
        );
    }
}