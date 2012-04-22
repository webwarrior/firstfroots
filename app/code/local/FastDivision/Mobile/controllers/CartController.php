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
 
require_once 'Mage/Checkout/controllers/CartController.php';

class FastDivision_Mobile_CartController extends Mage_Checkout_CartController
{
    /*public function ajaxAction()
    {
        $this->loadLayout();
        $output = $this->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/ajax-cart.phtml')->toHtml();
        $jsonData = Zend_Json::encode(array('quickcart' => $output));
        $this->getResponse()->setBody($jsonData);
    }*/
}
