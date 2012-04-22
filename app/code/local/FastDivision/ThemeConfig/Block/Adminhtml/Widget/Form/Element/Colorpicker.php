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

class FastDivision_ThemeConfig_Block_Adminhtml_Widget_Form_Element_Colorpicker extends Varien_Data_Form_Element_Abstract
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
        $this->setType('text');
    }

    public function getElementHtml()
    {
        $this->setClass('input-text-colorpicker');
        $html = '<input type="text" name="' . $this->getName() . '" title="' . $this->getTitle()
                . '" id="' . $this->getHtmlId() . '"'
                . ' class="' . $this->getClass() . '"'
                . ' value="' . $this->getValue() . '" '
                . $this->serialize($this->getHtmlAttributes()) . ' />';
        return $html;
    }
}