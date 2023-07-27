<?php
namespace Kirkor\MegaMenu\Model;

use Magento\Framework\Model\AbstractModel;
use Kirkor\MegaMenu\Api\Data\MenuItemsInterface;

class MenuItems extends AbstractModel implements MenuItemsInterface
{
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Kirkor\MegaMenu\Model\ResourceModel\MenuItems');
    }

    /**
     * Get Is Active flag.
     *
     * @return int|null
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set Is Active flag.
     *
     * @param bool|int $flag
     * @return $this
     */
    public function setIsActive($flag)
    {
        $this->setData(self::IS_ACTIVE, $flag);

        return $this;
    }

    /**
     * Get Store ID.
     *
     * @return int|null
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * Set Store ID.
     *
     * @param int $id
     * @return $this
     */
    public function setStoreId($id)
    {
        $this->setData(self::STORE_ID, $id);

        return $this;
    }

    /**
     * Set menu title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->setData(self::TITLE, $title);

        return $this;
    }

    /**
     * Get menu title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }
}
