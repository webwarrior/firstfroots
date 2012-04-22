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
 
class FastDivision_ReviewPhotos_Helper_Resizer extends Mage_Core_Helper_Abstract {
    /**
     * Resize Image proportionally and return the resized image url
     *
     * @param string $imageName         name of the image file
     * @param integer|null $width       resize width
     * @param integer|null $height      resize height
     * @param string|null $imagePath    directory path of the image present inside media directory
     * @return string               full url path of the image
     */
    public function resizeImage($imageName, $width=NULL, $height=NULL, $imagePath=NULL)
    {
        $imagePath = str_replace("/", DS, $imagePath);
        $imagePathFull = Mage::getBaseDir('media') . DS . $imagePath . DS . $imageName;
  
        if($width == NULL && $height == NULL) {
            $width = 100;
            $height = 100;
        }
    
        $resizePath = $width . 'x' . $height;
        $resizePathFull = Mage::getBaseDir('media') . DS . $imagePath . DS . $resizePath . DS . $imageName;
 
        // Create directory if it doesn't exist
        if(!file_exists(Mage::getBaseDir('media') . DS . $imagePath . DS . $resizePath)) {
            mkdir(Mage::getBaseDir('media') . DS . $imagePath . DS . $resizePath, 0777);
        }
 
        if (file_exists($imagePathFull) && !file_exists($resizePathFull)) {
            $imageObj = new Varien_Image($imagePathFull);
            $imageObj->constrainOnly(TRUE);
            //$imageObj->keepAspectRatio(TRUE);
            $imageObj->resize($width,$height);
            $imageObj->quality(100);
            $imageObj->save($resizePathFull);
        }
 
        $imagePath=str_replace(DS, "/", $imagePath);
        return Mage::getBaseUrl("media") . $imagePath . "/" . $resizePath . "/" . $imageName;
    }
}