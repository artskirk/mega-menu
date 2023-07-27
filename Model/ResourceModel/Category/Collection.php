<?php
namespace Kirkor\MegaMenu\Model\ResourceModel\Category;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model.
     */
    protected function _construct()
    {
        $this->_init(
            \Kirkor\MegaMenu\Model\Category::class,
            \Kirkor\MegaMenu\Model\ResourceModel\Category::class
        );
    }

    /**
     * Order by parent
     * @return $this
     */
    public function orderByParent()
    {
        $this->getSelect()->order('main_table.parent_id asc');
        return $this;
    }

    /**
     * Order by parent
     * @return $this
     */
    public function setSortOrder()
    {
        $this->getSelect()->order('main_table.sort_order asc');
        return $this;
    }
}
