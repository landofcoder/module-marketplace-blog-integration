<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Lofmp\SellerBlog\Ui\DataProvider\Post\Related;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magefan\Blog\Model\ResourceModel\Post\Collection;
use Magefan\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;

/**
 * Class PostDataProvider get post data
 */
class PostDataProvider extends \Magefan\Blog\Ui\DataProvider\Post\Related\PostDataProvider
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param Registry $registry
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        Registry $registry,
        array $meta = [],
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $collectionFactory,
            $request,
            $meta,
            $data
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection()
    {
        /** @var Collection $collection */
        $collection = parent::getCollection();

        if (!$this->getPost()) {
            return $collection;
        }

        $collection->addFieldToFilter(
            $collection->getIdFieldName(),
            ['nin' => [$this->getPost()->getId()]]
        );

        return $this->addCollectionFilters($collection);
    }
}
