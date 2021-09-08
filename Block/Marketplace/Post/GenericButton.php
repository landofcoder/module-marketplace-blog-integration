<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Post;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 * @package Lofmp\SellerBlog\Block\Marketplace\Block\Edit
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry
    ) {
    
        $this->context = $context;
        $this->registry = $registry;
    }

    /**
     * Return the synonyms group Id.
     *
     * @return int|null
     */
    public function getId()
    {
        $slot = $this->registry->registry('slot_id');
        return $slot ? $slot : null;
    }


    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
