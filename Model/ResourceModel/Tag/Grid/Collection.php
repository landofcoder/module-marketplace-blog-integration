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

namespace Lofmp\SellerBlog\Model\ResourceModel\Tag\Grid;

use Lof\MarketPlace\Model\SellerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;

/**
 * Blog Tag collection
 */
class Collection extends \Magefan\Blog\Model\ResourceModel\Tag\Collection implements SearchResultInterface
{
    /**
     * @var string
     */
    protected $_referenceTableName = "magefan_blog_tag_seller";

    /**
     * @var string
     */
    protected $_fieldId = 'tag_id';

    /**
     * @var bool|int
     */
    protected $_joinSellerFlag = false;

    /**
     * @var Session
     */
    private $session;
    /**
     * @var SellerFactory
     */
    private $sellerFactory;

    /**
     * @var AggregationInterface
     */
    protected $aggregations;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    
    /**
     * @param \Magento\Framework\Data\Collection\EntityFactory $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Session $session
     * @param SellerFactory $sellerFactory
     * @param $mainTable
     * @param $eventPrefix
     * @param $eventObject
     * @param $resourceModel
     * @param $model
     * @param null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Session $session,
        SellerFactory $sellerFactory,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
        \Magento\Framework\DB\Adapter\AdapterInterface  $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
        ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
            );
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
        $this->session = $session;
        $this->sellerFactory = $sellerFactory;
        $this->storeManager = $storeManager;
    }
    /**
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->_aggregations = $aggregations;
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->_aggregations;
    }
    /**
     * Retrieve all ids for collection
     * Backward compatibility with EAV collection
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }
    

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * Perform operations before rendering filters
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        $customerSession = $this->session;
        $customerId = $customerSession->getId();
        if ($customerId) {
            $seller = $this->sellerFactory->create()
                ->load($customerId, 'customer_id');
            $sellerId = $seller->getId();
            if ($sellerId) {
                $this->addFieldToFilter('seller_id', $sellerId);
            }
        }

        parent::_renderFiltersBefore();
    }

    /**
     * Perform adding filter by store
     *
     * @param int
     * @return $this
     */
    protected function performAddSellerFilter($sellerId)
    {
        if (!$this->_joinSellerFlag) {
            $this->joinSellerRelationTable($this->_referenceTableName, $this->_fieldId);
            $this->_joinSellerFlag = true;
        }
        $condition = is_array($sellerId)?["in" => $sellerId]:["eq" => (int)$sellerId];
        $this->addFilter($this->_referenceTableName.'.seller_id', $condition, 'public');
        return $this;
    }

    /**
     * Add field filter to collection
     *
     * @param array|string $field
     * @param string|int|array|null $condition
     * @return $this
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if ($field === 'seller_id') {
            return $this->performAddSellerFilter($condition, false);
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * Join store relation table if there is store filter
     *
     * @param string $tableName
     * @param string $columnName
     * @return void
     */
    protected function joinSellerRelationTable($tableName, $columnName)
    {
       $this->getSelect()->join(
            [$tableName => $this->getTable($tableName)],
            'main_table.' . $columnName . ' = '.$tableName.'.' . $columnName,
            []
        )->group(
            'main_table.' . $columnName
        );
    }
}
