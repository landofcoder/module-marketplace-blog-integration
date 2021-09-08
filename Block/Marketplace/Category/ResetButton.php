<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Category;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Lofmp\SellerBlog\Block\Marketplace\Category\GenericButton;

/**
 * Class ResetButton
 * @package Lofmp\SellerBlog\Block\Marketplace\Category
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
