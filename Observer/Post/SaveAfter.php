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

class SaveAfter implements ObserverInterface
{
    const TABLE_NAME = "magefan_blog_post_seller";
    const FIELD_ID = 'post_id';
    /**
     * @var Session
     */
    private $session;
    /**
     * @var SellerFactory
     */
    private $sellerFactory;

    /**
     * __construct Save After
     * 
     * @param Session $session
     * @param SellerFactory $sellerFactory
     */
    public function __construct(
        Session $session,
        SellerFactory $sellerFactory
    )
    {
        $this->session = $session;
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_model = $observer->getBlogPost();

        $customerSession = $this->session;
        $customerId = $customerSession->getId();
        if ($customerId) {
            $seller = $this->sellerFactory->create()
                ->load($customerId, 'customer_id');
            $sellerId = $seller->getId();
            if ($sellerId) {
                $table = $seller->getResource()->getTable(self::TABLE_NAME);
                $connection = $seller->getResource()->getConnection();
                $this->saveSellerModel($_model, $sellerId, $table, $connection, self::FIELD_ID);
            }
        }
    }

    /**
     * seve seller post
     * 
     * @param int $modelId
     * @param int $sellerId
     * @param string $table
     * @param Object $adapter
     * @param string $field_id
     * @return void
     * 
     */
    protected function saveSellerModel($modelId, $sellerId, $table, $adapter, $field_id)
    {
        $select = $adapter->select()->from(
            $table,
            'seller_id'
        )->where(
            $field_id.' = ?',
            (int)$modelId
        )->where(
            'seller_id = ?',
            (int)$sellerId
        );

        $sellerIds = $adapter->fetchCol($select);
        if (!$sellerIds) {
            $data = [ 
                [
                $field_id => $modelId,
                "seller_id" => $sellerId
                ]
            ];
            $adapter->insertMultiple($table, $data);
        }
    }
}