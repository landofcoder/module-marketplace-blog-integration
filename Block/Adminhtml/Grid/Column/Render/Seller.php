<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Lofmp\SellerBlog\Block\Adminhtml\Grid\Column\Render;

/**
 * Seller column renderer
 */
class Seller extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var \Lof\MarketPlace\Api\SellersRepositoryInterfaceFactory
     */
    protected $sellerFactory;

    /**
     * @var array
     */
    protected static $sellers = [];

    /**
     * Author constructor.
     * @param \Magento\Backend\Block\Context $context
     * @param \Lof\MarketPlace\Api\SellersRepositoryInterfaceFactory $sellerFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Lof\MarketPlace\Api\SellersRepositoryInterfaceFactory $sellerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sellerFactory = $sellerFactory;
    }

    /**
     * Render seller grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        if ($id = $row->getData($this->getColumn()->getIndex())) {
            $name = $this->getSellerById($id)->getName();
            $title = $this->getSellerById($id)->getShopTitle();
            if ($title || $name) {
                return $title?$title:$name;
            }
        }
        return null;
    }

    /**
     * Retrieve seller by id
     *
     * @param   int $id
     * @return  \Lof\MarketPlace\Api\Data\SellerInterface
     */
    protected function getSellerById($id)
    {
        if (!isset(self::$sellers[$id])) {
            self::$sellers[$id] = $this->sellerFactory->create()->get($id);
        }
        return self::$sellers[$id];
    }
}
