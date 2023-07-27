<?php
namespace Kirkor\MegaMenu\Model\ResourceModel\MenuItems;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model.
     */
    protected function _construct()
    {
        $this->_init(
            \Kirkor\MegaMenu\Model\MenuItems::class,
            \Kirkor\MegaMenu\Model\ResourceModel\MenuItems::class
        );
    }
}
