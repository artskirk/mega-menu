<?php
namespace Kirkor\MegaMenu\Model;

use Magento\Framework\Model\AbstractModel;
use Kirkor\MegaMenu\Api\Data\CategoryInterface;

class Category extends AbstractModel implements CategoryInterface
{
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Kirkor\MegaMenu\Model\ResourceModel\Category');
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

    /**
     * Get Parent ID.
     *
     * @return int|null
     */
    public function getParentId()
    {
        return $this->getData(self::PARENT_ID);
    }

    /**
     * Set Parent ID.
     *
     * @param int $id
     * @return $this
     */
    public function setParentId(int $id)
    {
        $this->setData(self::PARENT_ID, $id);

        return $this;
    }

    /**
     * Get ID.
     *
     * @return int|null
     */
    public function getCmsPage()
    {
        return $this->getData(self::CMS_PAGE);
    }

    /**
     * Set Cms Page ID.
     *
     * @param int $id
     * @return $this
     */
    public function setCmsPage(int $id)
    {
        $this->setData(self::CMS_PAGE, $id);

        return $this;
    }

    /**
     * Get Menu ID.
     *
     * @return int|null
     */
    public function getMenuId()
    {
        return $this->getData(self::MENU_ID);
    }

    /**
     * Set Menu ID.
     *
     * @param int $id
     * @return $this
     */
    public function setMenuId(int $id)
    {
        $this->setData(self::MENU_ID, $id);

        return $this;
    }

    /**
     * Set Url.
     *
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->setData(self::URL, $url);

        return $this;
    }

    /**
     * Get Url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getData(self::URL);
    }

    /**
     * Get Sort Order.
     *
     * @return int|null
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * Set Sort Order.
     *
     * @param int $id
     * @return $this
     */
    public function setSortOrder(int $id)
    {
        $this->setData(self::SORT_ORDER, $id);

        return $this;
    }

    /**
     * Open item in new tab.
     *
     * @return bool
     */
    public function getInNewTab()
    {
        return (bool) $this->getData(self::NEW_TAB);
    }

    /**
     * Open item in new tab.
     *
     * @param bool|int $flag
     * @return $this
     */
    public function setInNewTab($flag)
    {
        $this->setData(self::NEW_TAB, $flag);

        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @return string
     */
    public function getCssClasses()
    {
        return $this->getData(self::CSS_CLASSES);
    }
}
