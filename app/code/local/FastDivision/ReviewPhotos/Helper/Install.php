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
 
class FastDivision_ReviewPhotos_Helper_Install extends Mage_Core_Helper_Abstract {
    
    public function addColumns(&$installer, $table_name, $columns) {
		foreach ($columns as $column) {
			$sql = "ALTER TABLE {$table_name} ADD COLUMN ({$column});";
			try {
				$installer->run($sql);
			} catch(Exception $ex) {}
		}
		
		return $this;
	}
	
	public function createInstallNotice($msg_title, $msg_desc, $url = null) {
		$message = Mage::getModel('adminnotification/inbox');
		$message->setDateAdded(date("c", time()));
		
		if($url == null) {
		  $url = "http://fastdivision.com/extensions/review-photos";
		}
		
		$message->setSeverity(Mage_AdminNotification_Model_Inbox::SEVERITY_NOTICE);
		$message->setTitle($msg_title);
		$message->setDescription($msg_desc);
		$message->setUrl($url);
		$message->save();
		
		return $this;
	}
}
