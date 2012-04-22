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
 
function updateValue(Mage_Eav_Model_Entity_Setup $setup, $entityTypeId, $code, $key, $value)
{
    $id = $setup->getAttribute($entityTypeId, $code, 'attribute_id');
    $setup->updateAttribute($entityTypeId, $id, $key, $value);
}

$installer = $this;
$installer->startSetup();

// Add Mobile Homepage CMS Page
try {
    $page = Mage::getModel('cms/page');
    $data = array(
        'title' => 'Avalanche Mobile',
        'root_template' => 'one_column',
        'meta_keywords' => '',
        'meta_description' => '',
        'identifier' => 'mobile-home',
        'content_heading' => '',
        'stores' => array(0),
        'content' => '{{block type="core/template" name="mobile_homepage" template="page/homepage.phtml"}}'
    );
    $page->setData($data);
    $page->save();
} catch(Exception $e) {
    Mage::logException($e);
}

// Add Mobile Footer Static Block
try {
    $block = Mage::getModel('cms/block');
    $data = array(
        'title' => 'Avalanche Mobile Footer',
        'identifier' => 'mobile_footer',
        'content' => '<ul>
<li><a href="#">About</a></li>
<li><a href="#">Customer Service</a></li>
<li>Contact</li>
</ul>
<p id="copyright">&copy; 2012 Fast Division<br /> <a href="#">Contact us</a> at 1-800-000-000</p>',
        'is_active' => 1,
        'stores' => array(0)
    );
    $block->addData($data);
    $block->save();
} catch(Exception $e) {
    Mage::logException($e);
}

// Add Mobile Description to Manage Products Individual Page
try {
    $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
    $setup->removeAttribute('catalog_product', 'mobile_description');
    $setup->addAttribute('catalog_product', 'mobile_description', array(
            'type' => 'text',
            'backend' => '',
            'frontend' => '',
            'label' => 'Mobile Description',
            'input' => 'textarea',
            'class' => '',
            'source' => '',
            'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
            'visible' => true,
            'group' => 'Mobile Options',
            'required' => false,
            'user_defined' => false,
            'default' => '',
            'searchable' => true,
            'filterable' => false,
            'comparable' => false,
            'is_wysiwyg_enabled' => true,
            'is_html_allowed_on_front' => true,
            'visible_on_front' => false,
            'visible_in_advanced_search' => false,
            'unique' => false,
        ));

    updateValue($setup, 'catalog_product', 'mobile_description', 'is_global', 0);
    updateValue($setup, 'catalog_product', 'mobile_description', 'is_wysiwyg_enabled', true);
    updateValue($setup, 'catalog_product', 'mobile_description', 'is_html_allowed_on_front', true);
} catch(Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();