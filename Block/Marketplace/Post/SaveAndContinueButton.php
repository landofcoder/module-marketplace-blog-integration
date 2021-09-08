<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Post;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Lofmp\SellerBlog\Block\Marketplace\Post\GenericButton;

/**
 * Class SaveAndContinueButton
 * @package Lofmp\SellerBlog\Block\Marketplace\Post
 */
class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            'on_click' => 'return false;',
            'sort_order' => 80,
        ];
    }
}
