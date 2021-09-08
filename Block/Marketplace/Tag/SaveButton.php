<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Tag;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Lofmp\SellerBlog\Block\Marketplace\Tag\GenericButton;

/**
 * Class SaveButton
 * @package Lofmp\SellerBlog\Block\Marketplace\Tag
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'on_click' => 'return false;',
            'sort_order' => 90,
        ];
    }
}
