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

require_once('Mage/Checkout/controllers/CartController.php');

class FastDivision_QuickCart_Checkout_CartController extends Mage_Checkout_CartController
{    
	/**
    * Shopping cart display action
    */
    public function indexAction()
    {
        $cart = $this->_getCart();
        if ($cart->getQuote()->getItemsCount()) {
            $cart->init();
            $cart->save();

            if (!$this->_getQuote()->validateMinimumAmount()) {
                $warning = Mage::getStoreConfig('sales/minimum_order/description');
                $cart->getCheckoutSession()->addNotice($warning);
            }
        }

        foreach ($cart->getQuote()->getMessages() as $message) {
            if ($message) {
                $cart->getCheckoutSession()->addMessage($message);
            }
        }

        /**
         * if customer enteres shopping cart we should mark quote
         * as modified bc he can has checkout page in another window.
         */
        $this->_getSession()->setCartWasUpdated(true);

		// Quick Cart: If AJAX call, then return the cart dropdown HTML
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_sendSideCartHtml();
        } else {
            Varien_Profiler::start(__METHOD__ . 'cart_display');
            $this
                ->loadLayout()
                ->_initLayoutMessages('checkout/session')
                ->_initLayoutMessages('catalog/session')
                ->getLayout()->getBlock('head')->setTitle($this->__('Shopping Cart'));
            $this->renderLayout();
            Varien_Profiler::stop(__METHOD__ . 'cart_display');
        }
    }

    /**
     * Add product to shopping cart action
     */
    public function addAction()
    {
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $product = $this->_initProduct();
            $related = $this->getRequest()->getParam('related_product');

            /**
             * Check product availability
             */
            if (!$product) {
                $this->_goBack();
                return;
            }

            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );
       
            if (!$this->_getSession()->getNoCartRedirect(true)) {
                if (!$cart->getQuote()->getHasError()){
                    // If we're not adding to cart via AJAX, show flash message
                    if (!$this->getRequest()->isXmlHttpRequest()) { // No AJAX
                        $message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->htmlEscape($product->getName()));
                        $this->_getSession()->addSuccess($message);
                    }
                }

                // Shows AJAX cart or returns user to product page from POST
                $this->_goBack();
            }
        } catch (Mage_Core_Exception $e) {
            // Redirect for Non-AJAX Exceptions
            if (!$this->getRequest()->isXmlHttpRequest()) { // No AJAX
                if ($this->_getSession()->getUseNotice(true)) {
                    $this->_getSession()->addNotice($e->getMessage());
                } else {
                    $messages = array_unique(explode("\n", $e->getMessage()));
                    foreach ($messages as $message) {
                        $this->_getSession()->addError($message);
                    }
                }

                $url = $this->_getSession()->getRedirectUrl(true);
                if ($url) {
                    $this->getResponse()->setRedirect($url);
                } else {
                    $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
                }
            } else {
                // Report exceptions via JSON
                $ajaxExceptions = array();
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    $ajaxExceptions['exceptions'][] = $message;
                }
                echo json_encode($ajaxExceptions);
            }
        } catch (Exception $e) {
            if (!$this->getRequest()->isXmlHttpRequest()) { // No AJAX
                $this->_getSession()->addException($e, $this->__('Cannot add the item to shopping cart.'));
                Mage::logException($e);
                $this->_goBack();
            } else {
                echo json_encode(array('exceptions' => 'Cannot add the item to shopping cart.'));
                Mage::logException($e);
            }
        }
    }
	
	/**
     * Set back redirect url to response
     *
     * @return Mage_Checkout_CartController
     */
    protected function _goBack()
    {
		// Quick Cart: If AJAX call, then return the cart dropdown HTML
		if ($this->getRequest()->isXmlHttpRequest()) {
			$this->_sendSideCartHtml();
		} else {
	        $returnUrl = $this->getRequest()->getParam('return_url');
	        if ($returnUrl) {
	            // clear layout messages in case of external url redirect
	            if ($this->_isUrlInternal($returnUrl)) {
	                $this->_getSession()->getMessages(true);
	            }
	            $this->getResponse()->setRedirect($returnUrl);
	        } elseif (!Mage::getStoreConfig('checkout/cart/redirect_to_cart')
	            && !$this->getRequest()->getParam('in_cart')
	            && $backUrl = $this->_getRefererUrl()
	        ) {
	            $this->getResponse()->setRedirect($backUrl);
	        } else {
	            if (($this->getRequest()->getActionName() == 'add') && !$this->getRequest()->getParam('in_cart')) {
	                $this->_getSession()->setContinueShoppingUrl($this->_getRefererUrl());
	            }
	            $this->_redirect('checkout/cart');
	        }
	        return $this;
		}
    }
    
    protected function _sendSideCartHtml()
    {
        $params = $this->getRequest()->getParams();

        if(isset($params['current_url'])) {
            $currentUrl = $params['current_url'];
        } else {
            $currentUrl = Mage::getUrl('checkout/cart');
        }

		// Return the Quick Cart's dropdown block
        $this->loadLayout();
        $output = $this->getLayout()->getBlock('quickcart')->assign('currentUrl', $currentUrl)->toHtml();
        $jsonData = Zend_Json::encode(array('quickcart' => $output));
        $this->getResponse()->setBody($jsonData);
    }
}