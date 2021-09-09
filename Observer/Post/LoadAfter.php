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
 * @copyright  Copyright (c) 2021 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */
namespace Lofmp\SellerBlog\Observer\Post;

use Magento\Framework\Event\ObserverInterface;
use Lof\MarketPlace\Model\SellerFactory;
use Magento\Customer\Model\Session;

class LoadAfter implements ObserverInterface
{
    const TABLE_NAME = "magefan_blog_post_seller";
    const FIELD_ID = 'post_id';

    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_model = $observer->getBlogPost();
        $table = $_model->getResource()->getTable(self::TABLE_NAME);
        $connection = $_model->getResource()->getConnection();

        $seller_id = $this->lookupSellerId($_model->getId(), $table, $connection, self::FIELD_ID);
        $_model->setData('seller_id', $seller_id);
    }

    /**
     * seve seller post
     * 
     * @param int $modelId
     * @param string $table
     * @param Object $adapter
     * @param string $field_id
     * @return int
     * 
     */
    protected function lookupSellerId($modelId, $table, $adapter, $field_id)
    {
        $select = $adapter->select()->from(
            $table,
            'seller_id'
        )->where(
            $field_id.' = ?',
            (int)$modelId
        );

        $sellerIds =  $adapter->fetchCol($select);
        if ($sellerIds && is_array($sellerIds) && count($sellerIds) > 0) {
            return (int)$sellerIds[0];
        }
        return (int)$sellerIds;
    }
}