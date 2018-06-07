<?php
namespace Astound\InfoBar\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

use Astound\InfoBar\Api\Schema\NotificationInterface as SchemaInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable(SchemaInterface::TABLE_NAME)
        )->addColumn(
            SchemaInterface::ID_FIELD,
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true
            ],
            'Entity ID'
        )->addColumn(
            SchemaInterface::TITLE_FIELD,
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Title'
        )->addColumn(
            SchemaInterface::CONTENT_FIELD,
            Table::TYPE_TEXT,
            '64k',
            [],
            'Content'
        )->addColumn(
            SchemaInterface::STATUS_FIELD,
            Table::TYPE_SMALLINT,
            null,
            [
                'nullable' => false,
                'default' => '1'
            ],
            'Is Enabled'
        )->addColumn(
            SchemaInterface::BACKGROUND_COLOR_FIELD,
            Table::TYPE_TEXT,
            6,
            []
        )->addColumn(
            SchemaInterface::SORT_ORDER_FIELD,
            Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'default' => '0'
            ]
        );
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()
            ->newTable($installer->getTable(SchemaInterface::NOTIFICATION_TO_STORE_TABLE_NAME))
            ->addColumn(
                SchemaInterface::NOTIFICATION_ID_FIELD,
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Notification Id'
            )
            ->addColumn(
                SchemaInterface::STORE_VIEW_ID_FIELD,
                Table::TYPE_SMALLINT,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Store Id'
            )
            ->addIndex(
                $installer->getIdxName(
                    SchemaInterface::NOTIFICATION_TO_STORE_TABLE_NAME,
                    [SchemaInterface::STORE_VIEW_ID_FIELD]
                ),
                [SchemaInterface::STORE_VIEW_ID_FIELD]
            )
            ->addForeignKey(
                $installer->getFkName(
                    SchemaInterface::NOTIFICATION_TO_STORE_TABLE_NAME,
                    SchemaInterface::NOTIFICATION_ID_FIELD,
                    SchemaInterface::TABLE_NAME,
                    SchemaInterface::ID_FIELD
                ),
                SchemaInterface::NOTIFICATION_ID_FIELD,
                $installer->getTable(SchemaInterface::TABLE_NAME),
                SchemaInterface::ID_FIELD,
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName(
                    SchemaInterface::NOTIFICATION_TO_STORE_TABLE_NAME,
                    SchemaInterface::STORE_VIEW_ID_FIELD,
                    'store',
                    'store_id'
                ),
                SchemaInterface::STORE_VIEW_ID_FIELD,
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )
            ->setComment('Notification Store');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
