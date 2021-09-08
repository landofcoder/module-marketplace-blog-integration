<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Tag;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Lofmp\SellerBlog\Block\Marketplace\Tag\GenericButton;

/**
 * Class SaveContinueButton
 * @package Lofmp\SellerBlog\Block\Marketplace\Tag
 */
class SaveContinueButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'saveAndContinueEdit']],
            ],
            'on_click' => 'return false;',
            'sort_order' => 90,
        ];
    }
}
