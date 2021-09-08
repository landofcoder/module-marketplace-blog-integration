<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Lofmp\SellerBlog\Block\Adminhtml\Grid\Column;

/**
 * Admin blog grid seller
 */
class Seller extends \Magento\Backend\Block\Widget\Grid\Column
{
    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->_rendererTypes['seller'] = \Lofmp\SellerBlog\Block\Adminhtml\Grid\Column\Render\Seller::class;
        $this->_filterTypes['seller'] = \Lofmp\SellerBlog\Block\Adminhtml\Grid\Column\Filter\Seller::class;
    }
}
