<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Post;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Lofmp\SellerBlog\Block\Marketplace\Post\GenericButton;

/**
 * Class ResetButton
 * @package Lofmp\SellerBlog\Block\Marketplace\Post
 */
class ResetButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];
    }
}
