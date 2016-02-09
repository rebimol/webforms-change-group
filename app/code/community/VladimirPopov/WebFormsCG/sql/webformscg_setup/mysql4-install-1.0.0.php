<?php
/**
 * @author 		Vladimir Popov
 * @copyright  	Copyright (c) 2012 Vladimir Popov
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE  `{$this->getTable('webforms/webforms')}` ADD `group_id` SMALLINT( 5 ) NOT NULL DEFAULT '-1';
");

$installer->endSetup();
?>