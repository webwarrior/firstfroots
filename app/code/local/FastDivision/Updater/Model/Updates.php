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

class FastDivision_Updater_Model_Updates extends Mage_AdminNotification_Model_Feed
{
	public static function check()
    {
		return Mage::getModel('updater/updates')->checkUpdate();
	}
	
    public function getFrequency()
    {
        return 86400 * 5;
    }

    public function getLastUpdate()
    {
        return Mage::app()->loadCache('avalanche_updater_lastupdate');
    }

    public function setLastUpdate()
    {
        Mage::app()->saveCache(time(), 'avalanche_updater_lastupdate');
        return $this;
    }

    public function checkUpdate() 
    {
        if(($this->getFrequency() + $this->getLastUpdate()) > time()) {
            return $this;
        }

        $feedData = array();
        $feedXml = $this->getFeedData();

        if($feedXml && $feedXml->channel && $feedXml->channel->item) {
            foreach($feedXml->channel->item as $item) {
                $feedData[] = array(
                    'severity'      => (int)$item->severity ? (int)$item->severity : 3,
                    'date_added'    => $this->getDate((string)$item->pubDate),
                    'title'         => (string)$item->title,
                    'description'   => (string)$item->description,
                    'url'           => (string)$item->link,
                );
            }
            if($feedData) {
                Mage::getModel('adminnotification/inbox')->parse(array_reverse($feedData));
            }
        }

        $this->setLastUpdate();
        return $this;
    }
}