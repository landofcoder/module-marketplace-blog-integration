<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/terms
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lofmp_SellerBlog
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */
namespace Lofmp\SellerBlog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $installer->getConnection()->addColumn(
            $installer->getTable('magefan_blog_category'),
            'seller_id',
            [
                'type' => Table::TYPE_INTEGER,
                'unsigned' => true,
                'nullable' => true,
                'comment' => 'Seller Id'
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('magefan_blog_comment'),
            'seller_id',
            [
                'type' => Table::TYPE_INTEGER,
                'unsigned' => true,
                'nullable' => true,
                'comment' => 'Seller Id'
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('magefan_blog_post'),
            'seller_id',
            [
                'type' => Table::TYPE_INTEGER,
                'unsigned' => true,
                'nullable' => true,
                'comment' => 'Seller Id'
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('magefan_blog_tag'),
            'seller_id',
            [
                'type' => Table::TYPE_INTEGER,
                'unsigned' => true,
                'nullable' => true,
                'comment' => 'Seller Id'
            ]
        );

        /**
         * Create table 'lofmp_sellerblog_setting'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lofmp_sellerblog_setting')
        )->addColumn(
            'seller_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Seller ID'
        )->addColumn(
            'enable',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => true],
            'Enable Seller Blog'
        )->addColumn(
            'show_blog_categories',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => true],
            'Show blog Categories'
        )->addColumn(
            'show_latest_posts',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => true],
            'Show Latest Posts'
        )->addColumn(
            'show_related_posts',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => true],
            'Show Related Posts in Product detail page'
        )->addColumn(
            'show_related_products',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => true],
            'Show Related Products in Post detail page'
        )->addForeignKey(
            $installer->getFkName('lofmp_sellerblog_setting', 'seller_id', 'lof_marketplace_seller','seller_id'),
            'seller_id',
            $installer->getTable('lof_marketplace_seller'),
            'seller_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Seller Blog Settings Table'
        );
        $installer->getConnection()->createTable($table);
    }
}