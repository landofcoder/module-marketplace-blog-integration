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

namespace Lofmp\SellerBlog\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\Helper\AbstractHelper;
use Lof\MarketPlace\Model\SellerFactory;
use Lof\MarketPlace\Model\ConfigFactory;

/**
 * Class Data
 * @package Lofmp\SellerBlog\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    public $serializer;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directory;

    /**
     * @var \Magento\Customer\Model\SessionFactory
     */
    protected $_customerSession;

    /**
     * @var SellerFactory
     */
    protected $sellerFactory;

    /**
     * @var ConfigFactory
     */
    protected $sellerConfigFactory;

    /**
     * @var mixed|array
     */
    protected $_seller = [];

    /**
     * @var mixed|array|object|null
     */
    protected $_sellerConfigData = null;

    /**
     * Data constructor.
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directory
     * @param \Magento\Customer\Model\SessionFactory $customerSession
     * @param SellerFactory $sellerFactory
     * @param ConfigFactory $sellerConfigFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        \Magento\Framework\App\Helper\Context $context,
        DateTime $dateTime,
        \Magento\Framework\App\Filesystem\DirectoryList $directory,
        \Magento\Customer\Model\SessionFactory $customerSession,
        SellerFactory $sellerFactory,
        ConfigFactory $sellerConfigFactory
    ) {
        $this->dateTime = $dateTime;
        $this->storeManager = $storeManager;
        $this->directory = $directory;
        $this->_customerSession = $customerSession;
        $this->sellerFactory = $sellerFactory;
        $this->sellerConfigFactory = $sellerConfigFactory;
        parent::__construct($context);
    }

    /**
     * Get current seller
     * 
     * @return \Lof\MarketPlace\Model\Seller|mixed|array
     */
    public function getSeller(){
        $customerId = $this->_customerSession->create()->getCustomerId();
        if($customerId && !isset($this->_seller[$customerId])){
            $this->_seller[$customerId] = $this->sellerFactory->create()->load($customerId, 'customer_id');
            if($this->_seller[$customerId]->getId() && $this->_seller[$customerId]->getStatus() == 0) { //need approval
                $this->_seller[$customerId] = null;
            }
        }
        return $this->_seller[$customerId];
    }

    /**
     * Get Seller Data by current customer
     * 
     * @return array|mixed|object|null
     */
    public function getSellerByCustomer(){
        $seller = $this->getSeller();
        return $seller?$seller->getData():null;
    }

    /**
     * Get config value
     * 
     * @param $field
     * @param null $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get current store
     * @return Object|null
     */
    public function getStore()
    {
        return $this->storeManager->getStore();
    }
}
