<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Comment;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Lofmp\SellerBlog\Block\Marketplace\Comment\GenericButton;

/**
 * Class SaveButton
 * @package Lofmp\SellerBlog\Block\Marketplace\Comment
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
