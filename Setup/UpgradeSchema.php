<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lofmp_SellerBlog
 * @copyright  Copyright (c) 2020 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lofmp\SellerBlog\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class UpgradeSchema
 *
 * @package Lofmp\SellerBlog\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface {
    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            if ($setup->getConnection()->isTableExists('magefan_blog_category')) {
                if ($setup->getConnection()->isTableExists('magefan_blog_category')) {
                    $setup->getConnection()->addForeignKey(
                        $setup->getFkName('magefan_blog_category', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
                        'magefan_blog_category',
                        'seller_id',
                        $setup->getTable('lof_marketplace_seller'),
                        'seller_id',
                        \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                    );
                }
            }
            if ($setup->getConnection()->isTableExists('magefan_blog_comment')) {
                if ($setup->getConnection()->isTableExists('magefan_blog_comment')) {
                    $setup->getConnection()->addForeignKey(
                        $setup->getFkName('magefan_blog_comment', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
                        'magefan_blog_comment',
                        'seller_id',
                        $setup->getTable('lof_marketplace_seller'),
                        'seller_id',
                        \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                    );
                }
            }
            if ($setup->getConnection()->isTableExists('magefan_blog_post')) {
                if ($setup->getConnection()->isTableExists('magefan_blog_post')) {
                    $setup->getConnection()->addForeignKey(
                        $setup->getFkName('magefan_blog_post', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
                        'magefan_blog_post',
                        'seller_id',
                        $setup->getTable('lof_marketplace_seller'),
                        'seller_id',
                        \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                    );
                }
            }
            if ($setup->getConnection()->isTableExists('magefan_blog_tag')) {
                if ($setup->getConnection()->isTableExists('magefan_blog_tag')) {
                    $setup->getConnection()->addForeignKey(
                        $setup->getFkName('magefan_blog_tag', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
                        'magefan_blog_tag',
                        'seller_id',
                        $setup->getTable('lof_marketplace_seller'),
                        'seller_id',
                        \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                    );
                }
            }
        }
        $setup->endSetup();
    }
}