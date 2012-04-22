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
 
class FastDivision_ReviewPhotos_Block_AdminHtml_Review_Edit_Form extends Mage_Adminhtml_Block_Review_Edit_Form
{
    protected function _prepareForm()
    {
      $review = Mage::registry('review_data');
      $product = Mage::getModel('catalog/product')->load($review->getEntityPkValue());
      $customer = Mage::getModel('customer/customer')->load($review->getCustomerId());
      $statuses = Mage::getModel('review/review')
          ->getStatusCollection()
          ->load()
          ->toOptionArray();

      $form = new Varien_Data_Form(array(
          'id'        => 'edit_form',
          'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'), 'ret' => Mage::registry('ret'))),
          'method'    => 'post',
          'enctype' => 'multipart/form-data'
      ));

      $fieldset = $form->addFieldset('review_details', array('legend' => Mage::helper('review')->__('Review Details'), 'class' => 'fieldset-wide'));

      $fieldset->addField('product_name', 'note', array(
          'label'     => Mage::helper('review')->__('Product'),
          'text'      => '<a href="' . $this->getUrl('*/catalog_product/edit', array('id' => $product->getId())) . '" onclick="this.target=\'blank\'">' . $product->getName() . '</a>'
      ));

      if ($customer->getId()) {
          $customerText = Mage::helper('review')->__('<a href="%1$s" onclick="this.target=\'blank\'">%2$s %3$s</a> <a href="mailto:%4$s">(%4$s)</a>',
              $this->getUrl('*/customer/edit', array('id' => $customer->getId(), 'active_tab'=>'review')),
              $this->htmlEscape($customer->getFirstname()),
              $this->htmlEscape($customer->getLastname()),
              $this->htmlEscape($customer->getEmail()));
      } else {
          if (is_null($review->getCustomerId())) {
              $customerText = Mage::helper('review')->__('Guest');
          } elseif ($review->getCustomerId() == 0) {
              $customerText = Mage::helper('review')->__('Administrator');
          }
      }

      $fieldset->addField('customer', 'note', array(
          'label'     => Mage::helper('review')->__('Posted By'),
          'text'      => $customerText,
      ));

      $fieldset->addField('summary_rating', 'note', array(
          'label'     => Mage::helper('review')->__('Summary Rating'),
          'text'      => $this->getLayout()->createBlock('adminhtml/review_rating_summary')->toHtml(),
      ));

      $fieldset->addField('detailed_rating', 'note', array(
          'label'     => Mage::helper('review')->__('Detailed Rating'),
          'required'  => true,
          'text'      => '<div id="rating_detail">' . $this->getLayout()->createBlock('adminhtml/review_rating_detailed')->toHtml() . '</div>',
      ));

      $fieldset->addField('status_id', 'select', array(
          'label'     => Mage::helper('review')->__('Status'),
          'required'  => true,
          'name'      => 'status_id',
          'values'    => Mage::helper('review')->translateArray($statuses),
      ));

      /**
       * Check is single store mode
       */
      if (!Mage::app()->isSingleStoreMode()) {
          $fieldset->addField('select_stores', 'multiselect', array(
              'label'     => Mage::helper('review')->__('Visible In'),
              'required'  => true,
              'name'      => 'stores[]',
              'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm()
          ));
          $review->setSelectStores($review->getStores());
      }
      else {
          $fieldset->addField('select_stores', 'hidden', array(
              'name'      => 'stores[]',
              'value'     => Mage::app()->getStore(true)->getId()
          ));
          $review->setSelectStores(Mage::app()->getStore(true)->getId());
      }
      
      // Review Photo
      if(Mage::getStoreConfigFlag('avalanche_wall/reviewphotos_general/reviewphotos_enabled')) {
        $mediaFieldset = $form->addFieldset('review_media', array('legend' => Mage::helper('review')->__('Review Media'), 'class' => 'fieldset-wide'));

        $mediaFieldset->addType('review_image', 'FastDivision_ReviewPhotos_Lib_Varien_Data_Form_Element_ReviewImage');
        $mediaFieldset->addField('photo_url', 'review_image', array(
            'label'         => 'Review Photo',
            'name'          => 'photo',
            'required'      => false
        ));
        
        if(Mage::getStoreConfigFlag('avalanche_wall/reviewphotos_general/reviewphotos_show_title')) {
            $mediaFieldset->addField('photo_title', 'text', array(
                'label'         => 'Photo Title',
                'name'          => 'photo_title',
                'required'      => false
            ));
        }
        
        if(Mage::getStoreConfigFlag('avalanche_wall/reviewphotos_general/reviewphotos_show_description')) {
            $mediaFieldset->addField('photo_description', 'textarea', array(
                'label'         => 'Photo Description',
                'name'          => 'photo_description',
                'required'      => false,
                'style'        => 'height: 6em;'
            ));
        }
      }

      $fieldset->addField('nickname', 'text', array(
          'label'     => Mage::helper('review')->__('Nickname'),
          'required'  => true,
          'name'      => 'nickname'
      ));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('review')->__('Summary of Review'),
          'required'  => true,
          'name'      => 'title',
      ));
      
      $fieldset->addField('detail', 'textarea', array(
          'label'     => Mage::helper('review')->__('Review'),
          'required'  => true,
          'name'      => 'detail',
          'style'     => 'height:24em;',
      ));

      $form->setUseContainer(true);
      $form->setValues($review->getData());
      $this->setForm($form);
    }
}