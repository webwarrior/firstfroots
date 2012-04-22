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

include("Mage/Adminhtml/controllers/Catalog/Product/ReviewController.php");

class FastDivision_ReviewPhotos_ReviewController extends Mage_Adminhtml_Catalog_Product_ReviewController
{
    public function saveAction()
    {
        if (($data = $this->getRequest()->getPost()) && ($reviewId = $this->getRequest()->getParam('id'))) {
            $review = Mage::getModel('review/review')->load($reviewId);

            if (! $review->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('catalog')->__('The review was removed by another user or does not exist.'));
            } else {
                try {
                    // Review Photo File Upload
                    if(isset($_FILES['photo']['name'])) {
                          try {
                            $uploader = new Varien_File_Uploader('photo');
                            $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));

                            $uploader->setAllowRenameFiles(false);
                            $uploader->setFilesDispersion(false);

                            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                            $newFileName = basename($_FILES['photo']['name'], '.' . $ext) . uniqid() . '.' . $ext;
                            $path = Mage::getBaseDir('media') . DS . 'reviews';

                            $uploader->save($path, $newFileName);
                            $data['photo_url'] = $newFileName;
                          } catch(Exception $e) { }
                    }

                    if(isset($data['photo']['delete']) && $data['photo']['delete'] == 1) {
                        $data['photo_url'] = '';
                    }
                    
                    // Save Review Data
                    $review->addData($data)->save();

                    $arrRatingId = $this->getRequest()->getParam('ratings', array());
                    $votes = Mage::getModel('rating/rating_option_vote')
                        ->getResourceCollection()
                        ->setReviewFilter($reviewId)
                        ->addOptionInfo()
                        ->load()
                        ->addRatingOptions();
                    foreach ($arrRatingId as $ratingId=>$optionId) {
                        if($vote = $votes->getItemByColumnValue('rating_id', $ratingId)) {
                            Mage::getModel('rating/rating')
                                ->setVoteId($vote->getId())
                                ->setReviewId($review->getId())
                                ->updateOptionVote($optionId);
                        } else {
                            Mage::getModel('rating/rating')
                                ->setRatingId($ratingId)
                                ->setReviewId($review->getId())
                                ->addOptionVote($optionId, $review->getEntityPkValue());
                        }
                    }

                    $review->aggregate();

                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('catalog')->__('The review has been saved.'));
                } catch (Exception $e){
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }

            return $this->getResponse()->setRedirect($this->getUrl($this->getRequest()->getParam('ret') == 'pending' ? '*/*/pending' : '*/*/'));
        }
        $this->_redirectReferer();
    }
    
    public function postAction()
    {
        $productId = $this->getRequest()->getParam('product_id', false);
        if ($data = $this->getRequest()->getPost()) {
            if(isset($data['select_stores'])) {
                $data['stores'] = $data['select_stores'];
            }
            
            // Review Photo File Upload
            if(isset($_FILES['photo']['name'])) {
                  try {
                    $uploader = new Varien_File_Uploader('photo');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));

                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);

                    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    $newFileName = basename($_FILES['photo']['name'], '.' . $ext) . uniqid() . '.' . $ext;
                    $path = Mage::getBaseDir('media') . DS . 'reviews';
                    
                    $uploader->save($path, $newFileName);
                    $data['photo_url'] = $newFileName;
                  } catch(Exception $e) { }
            }

            if(isset($data['photo']['delete']) && $data['photo']['delete'] == 1) {
                $data['photo_url'] = '';
            }

            $review = Mage::getModel('review/review')->setData($data);

            $product = Mage::getModel('catalog/product')
                ->load($productId);

            try {                
                $review->setEntityId(1) // product
                    ->setEntityPkValue($productId)
                    ->setStoreId($product->getStoreId())
                    ->setStatusId($data['status_id'])
                    ->setCustomerId(null)//null is for administrator only
                    ->save();

                $arrRatingId = $this->getRequest()->getParam('ratings', array());
                foreach ($arrRatingId as $ratingId=>$optionId) {
                    Mage::getModel('rating/rating')
                       ->setRatingId($ratingId)
                       ->setReviewId($review->getId())
                       ->addOptionVote($optionId, $productId);
                }

                $review->aggregate();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('catalog')->__('The review has been saved.'));
                if( $this->getRequest()->getParam('ret') == 'pending' ) {
                    $this->getResponse()->setRedirect($this->getUrl('*/*/pending'));
                } else {
                    $this->getResponse()->setRedirect($this->getUrl('*/*/'));
                }

                return;
            } catch (Exception $e){
                die($e->getMessage());
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
        return;
    }
}