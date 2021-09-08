<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Tag;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Lofmp\SellerBlog\Block\Marketplace\Tag\GenericButton;

/**
 * Class ResetButton
 * @package Lofmp\SellerBlog\Block\Marketplace\Tag
 */
class ResetButton extends GenericButton implements ButtonProviderInterface
{
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
