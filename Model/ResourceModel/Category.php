<?php
namespace Kirkor\MegaMenu\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Category extends AbstractDb
{
    const ID = 'category_id';
    const MAIN_TABLE = 'kirkor_megamenu_categories';

    /**
     * Define main table.
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID);
    }
}
