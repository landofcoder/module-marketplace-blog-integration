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

        /**
         * Create table 'magefan_blog_post_seller'
         */
        $magefan_blog_post_seller = $setup->getConnection()
        ->newTable($setup->getTable('magefan_blog_post_seller'))
        ->addColumn(
            'post_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'primary' => true],
            'Post Id'
            )
        ->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Seller Id'
            )
        ->addIndex(
            $setup->getIdxName('magefan_blog_post_seller', ['seller_id', 'post_id']),
            ['seller_id', 'post_id']
            )
        ->addForeignKey(
            $setup->getFkName('magefan_blog_post_seller', 'post_id', 'magefan_blog_post', 'post_id'),
            'post_id',
            $setup->getTable('magefan_blog_post'),
            'post_id',
            Table::ACTION_CASCADE
            )
        ->addForeignKey(
            $setup->getFkName('magefan_blog_post_seller', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
            'seller_id',
            $setup->getTable('lof_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
            )
        ->setComment('Seller Blog Post Seller');

        $setup->getConnection()->createTable($magefan_blog_post_seller);

        /**
         * Create table 'magefan_blog_category_seller'
         */
        $magefan_blog_category_seller = $setup->getConnection()
        ->newTable($setup->getTable('magefan_blog_category_seller'))
        ->addColumn(
            'category_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'primary' => true],
            'Category Id'
            )
        ->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Seller Id'
            )
        ->addIndex(
            $setup->getIdxName('magefan_blog_category_seller', ['seller_id', 'category_id']),
            ['seller_id', 'category_id']
            )
        ->addForeignKey(
            $setup->getFkName('magefan_blog_category_seller', 'category_id', 'magefan_blog_category', 'category_id'),
            'category_id',
            $setup->getTable('magefan_blog_category'),
            'category_id',
            Table::ACTION_CASCADE
            )
        ->addForeignKey(
            $setup->getFkName('magefan_blog_category_seller', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
            'seller_id',
            $setup->getTable('lof_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
            )
        ->setComment('Seller Blog Category Seller');

        $setup->getConnection()->createTable($magefan_blog_category_seller);

        /**
         * Create table 'magefan_blog_tag_seller'
         */
        $magefan_blog_tag_seller = $setup->getConnection()
        ->newTable($setup->getTable('magefan_blog_tag_seller'))
        ->addColumn(
            'tag_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'primary' => true],
            'Tag Id'
            )
        ->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Seller Id'
            )
        ->addIndex(
            $setup->getIdxName('magefan_blog_tag_seller', ['seller_id','tag_id']),
            ['seller_id','tag_id']
            )
        ->addForeignKey(
            $setup->getFkName('magefan_blog_tag_seller', 'tag_id', 'magefan_blog_tag', 'tag_id'),
            'tag_id',
            $setup->getTable('magefan_blog_tag'),
            'tag_id',
            Table::ACTION_CASCADE
            )
        ->addForeignKey(
            $setup->getFkName('magefan_blog_tag_seller', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
            'seller_id',
            $setup->getTable('lof_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
            )
        ->setComment('Seller Blog Tag Seller');

        $setup->getConnection()->createTable($magefan_blog_tag_seller);

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
            $installer->getFkName('lofmp_sellerblog_setting', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
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