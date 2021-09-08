<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Lofmp\SellerBlog\Ui\DataProvider\Post\Form;

use Magefan\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;

/**
 * Class DataProvider
 */
class PostDataProvider extends \Magefan\Blog\Ui\DataProvider\Post\Form\PostDataProvider
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $postCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param Registry $registry
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $postCollectionFactory,
        DataPersistorInterface $dataPersistor,
        Registry $registry,
        array $meta = [],
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $postCollectionFactory, $dataPersistor, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $this->setSellerToFilter();

        return parent::getData();
    }

    /**
     * {@inheritdoc}
     */
    public function setSellerToFilter()
    {
        $sellerId = $this->registry->registry('current_seller_id');
        if ($sellerId) {
            $this->getCollection()->addFieldToFilter('seller_id', $sellerId);
        }
        return $this;
    }
}
