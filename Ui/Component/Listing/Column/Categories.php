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
namespace Lofmp\SellerBlog\Ui\Component\Listing\Column;

use Magefan\Blog\Model\CategoryFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Categories.
 */
class Categories extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var array
     */
    protected static $categories = [];

    /**
     * Constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param CategoryFactory $categoryFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        CategoryFactory $categoryFactory,
        array $components = [],
        array $data = []
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['categories'])) {
                    $titles = [];
                    foreach ($item['categories'] as $id) {
                        $title = $this->getCategoryById($id)->getTitle();
                        if ($title) {
                            $titles[] = $title;
                        }
                    }

                    $item[$fieldName] =  implode(', ', $titles);
                }
            }
        }

        return $dataSource;
    }

    /**
     * Retrieve category by id
     *
     * @param   int $id
     * @return  \Magefan\Blog\Model\Category
     */
    protected function getCategoryById($id)
    {
        if (!isset(self::$categories[$id])) {
            self::$categories[$id] = $this->categoryFactory->create()->load($id);
        }
        return self::$categories[$id];
    }
}
