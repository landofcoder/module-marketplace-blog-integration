<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Tag;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Lofmp\SellerBlog\Block\Marketplace\Tag\GenericButton;

/**
 * Class DeleteButton
 * @package Lofmp\SellerBlog\Block\Marketplace\Tag
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        $data = [];
        if ($this->getId()) {
            $data = [
                'label' => __('Delete Slot'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/*/delete', ['group_id' => $this->getId()]);
    }
}
