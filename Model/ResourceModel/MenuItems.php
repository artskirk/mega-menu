<?php
namespace Kirkor\MegaMenu\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MenuItems extends AbstractDb
{
    const ID = 'id';
    const MAIN_TABLE = 'kirkor_megamenu_items';

    /**
     * Define main table.
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID);
    }
}
