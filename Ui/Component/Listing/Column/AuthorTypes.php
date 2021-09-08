<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lofmp_SellerBlog
 * @copyright  Copyright (c) 2021 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */
namespace Lofmp\SellerBlog\Ui\Component\Listing\Column;

class AuthorTypes extends \Magento\Ui\Component\Listing\Columns\Column
{

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['author_type']) && !empty($item['author_type'])) {
                    if ($item['author_type'] == 1) {
                        $item['author_type'] = __('Custumer');
                    } elseif ($item['author_type'] == 2) {
                        $item['author_type'] = __('Admin');
                    } elseif ($item['author_type'] == 3) {
                        $item['author_type'] = __('Seller');
                    } else {
                        $item['author_type'] = __('Guest');
                    }
                }
            }
        }

        return $dataSource;
    }
}
