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
 
class FastDivision_ReviewPhotos_Model_Resource_Review_Collection extends Mage_Review_Model_Resource_Review_Collection
{
    protected function _initSelect()
    {
        $this->getSelect()->from(array('main_table' => $this->getMainTable()));
        $this->getSelect()
            ->join(array('detail' => $this->_reviewDetailTable),
                'main_table.review_id = detail.review_id',
                array('detail_id', 'title', 'detail', 'nickname', 'customer_id', 'photo_url', 'photo_title', 'photo_description'));
        return $this;
    }
}