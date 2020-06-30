<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'core/resource'
 */
$table = $installer->getConnection()
                   ->newTable($installer->getTable('qps/rule'))
                   ->addColumn(
                       'id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
                       'identity' => true,
                       'unsigned' => true,
                       'nullable' => false,
                       'primary'  => true,
                   ], 'Id')
                   ->addColumn(
                       'url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, [],
                       'specific URL utilized by threat covered if present, adminhtml placeholder represents adminhtml path in current magento installation, optional.')
                   ->addColumn(
                       'type', Varien_Db_Ddl_Table::TYPE_TEXT, null, [],
                       'rule type (regex|custom), custom rules reserved for future purpose and not covered in this document, mandatory.')
                   ->addColumn(
                       'name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, ['nullable' => true, 'default' => ''],
                       'rule title, optional')
                   ->addColumn(
                       'rule_content', Varien_Db_Ddl_Table::TYPE_TEXT, null, [],
                       'regex string for request validation, custom rules could have more complex data like json object, mandatory.')
                   ->addColumn(
                       'target', Varien_Db_Ddl_Table::TYPE_TEXT, null, ['nullable' => true, 'default' => ''],
                       'explain which request part should be checked. Possible values are all headers (or specific header), post and get data, cookies and session variables (see REQUEST arrays and rules examples below), comma separated for multiple values. Whole request will be checked if not specified, optional.')
                   ->addColumn(
                       'preprocess', Varien_Db_Ddl_Table::TYPE_TEXT, null, ['nullable' => true, 'default' => ''],
                       'name of the function executed on raw target values, (base64_decode|json_decode|rawurldecode), optional.')
                   ->addColumn(
                       'patch_fix', Varien_Db_Ddl_Table::TYPE_TEXT, null, ['nullable' => true, 'default' => ''],
                       'patch that covers rule related threat, no need to check rule if customer magento 1 have this patch, optional');

if ($installer->getConnection()->isTableExists($installer->getTable('qps/rule'))) {
    $installer->getConnection()->dropTable($installer->getTable('qps/rule'));
}

$installer->getConnection()->createTable($table);

$installer->endSetup();

