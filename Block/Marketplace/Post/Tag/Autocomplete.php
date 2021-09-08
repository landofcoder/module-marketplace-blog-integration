<?php

namespace Lofmp\SellerBlog\Block\Marketplace\Post\Tag;

use \Magento\Framework\Registry;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

/**
 * Class Tag Autocomplete Block
 */
class Autocomplete extends Template
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Autocomplete constructor.
     * @param Context $context
     * @param array $data
     * @param Registry $registry
     */
    public function __construct(Context $context, array $data = [], Registry $registry)
    {
        parent::__construct($context, $data);
        $this->registry = $registry;
    }

    /**
     * @return bool|false|string
     */
    public function getLinkedTags()
    {
        $post = $this->registry->registry('current_model');
        if ($post) {
            $tagsCollection = $post->getRelatedTags();
            $tagsTitles = [];
            foreach ($tagsCollection as $tag) {
                $tagsTitles[] = $tag->getData('title');
            }
            $tagsTitles = array_unique($tagsTitles);
        } else {
            $tagsTitles = [];
        }
        return json_encode($tagsTitles);
    }

    /**
     * @return string
     */
    public function getAutocompleteUrl()
    {
        return $this->getUrl('sellerblog/tag/autocomplete');
    }
}
