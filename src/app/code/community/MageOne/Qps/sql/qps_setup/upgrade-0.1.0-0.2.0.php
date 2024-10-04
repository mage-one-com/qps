<?php

/** @var Mage_Core_Model_Resource_Setup $installer */

$installer = $this;

$installer->getConnection()
    ->addColumn(
        $installer->getTable('qps/rule'),
        'm1_key',
        [
            'type'     => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length'   => 255,
            'nullable' => true,
            'comment'  => 'Mage One internal identifier'
        ]
    );
$installer->getConnection()
    ->addColumn(
        $installer->getTable('qps/rule'),
        'enabled',
        [
            'type'     => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
            'nullable' => false,
            'default'  => 0,
            'comment'  => 'Rule enabled or disabled for checking'
        ]
    );
