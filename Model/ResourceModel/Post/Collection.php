<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Lofmp\SellerBlog\Model\ResourceModel\Post;

/**
 * Blog post collection
 */
class Collection extends \Magefan\Blog\Model\ResourceModel\Post\Collection
{
    /**
     * @var string
     */
    protected $_referenceTableName = "magefan_blog_post_seller";

    /**
     * @var string
     */
    protected $_fieldId = 'post_id';

    /**
     * @var bool|int
     */
    protected $_joinSellerFlag = false;

    /**
     * Perform adding filter by store
     *
     * @param int
     * @return $this
     */
    protected function performAddSellerFilter($sellerId)
    {
        if (!$this->_joinSellerFlag) {
            $this->joinSellerRelationTable($this->_referenceTableName, $this->_fieldId);
            $this->_joinSellerFlag = true;
        }
        $condition = is_array($sellerId)?["in" => $sellerId]:["eq" => (int)$sellerId];
        $this->addFilter($this->_referenceTableName.'.seller_id', $condition, 'public');

        return $this;
    }

    /**
     * Add field filter to collection
     *
     * @param array|string $field
     * @param string|int|array|null $condition
     * @return $this
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if ($field === 'seller_id') {
            return $this->performAddSellerFilter($condition, false);
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * Join store relation table if there is store filter
     *
     * @param string $tableName
     * @param string $columnName
     * @return void
     */
    protected function joinSellerRelationTable($tableName, $columnName)
    {
       $this->getSelect()->join(
            [$tableName => $this->getTable($tableName)],
            'main_table.' . $columnName . ' = '.$tableName.'.' . $columnName,
            []
        )->group(
            'main_table.' . $columnName
        );
    }
}
