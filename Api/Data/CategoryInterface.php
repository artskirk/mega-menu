<?php
namespace Kirkor\MegaMenu\Api\Data;

/**
 * Category interface.
 *
 * @api
 */
interface CategoryInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'category_id';
    const PARENT_ID = 'parent_id';
    const MENU_ID = 'menu_id';
    const CSS_CLASSES = 'css_classes';
    const TITLE = 'title';
    const URL = 'url';
    const CMS_PAGE = 'cms_page';
    const IS_ACTIVE = 'is_active';
    const STORE_ID = 'store_id';
    const SORT_ORDER = 'sort_order';
    const NEW_TAB = 'new_tab';
    /**#@-*/

    /**
     * Get ID.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID.
     *
     * @param mixed $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get Parent ID.
     *
     * @return int|null
     */
    public function getParentId();

    /**
     * Set Parent ID.
     *
     * @param int $id
     * @return $this
     */
    public function setParentId(int $id);

    /**
     * Get ID.
     * @return int|null
     */
    public function getCmsPage();

    /**
     * Set Cms Page ID.
     *
     * @param int $id
     * @return $this
     */
    public function setCmsPage(int $id);

    /**
     * Get Menu ID.
     *
     * @return int|null
     */
    public function getMenuId();

    /**
     * Set Menu ID.
     *
     * @param int $id
     * @return $this
     */
    public function setMenuId(int $id);

    /**
     * Get Is Active flag.
     *
     * @return int|null
     */
    public function getIsActive();

    /**
     * Set Is Active flag.
     *
     * @param bool|int $flag
     * @return $this
     */
    public function setIsActive($flag);

    /**
     * Open item in new tab.
     *
     * @return int|null
     */
    public function getInNewTab();

    /**
     * Open item in new tab.
     *
     * @param bool|int $flag
     * @return $this
     */
    public function setInNewTab($flag);

    /**
     * Set menu title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * Get category title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set Url.
     *
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url);

    /**
     * Get Url.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Get Sort Order.
     *
     * @return int|null
     */
    public function getSortOrder();

    /**
     * Set Sort Order.
     *
     * @param int $id
     * @return $this
     */
    public function setSortOrder(int $id);

    /**
     * @return int
     */
    public function getCategoryId();

    /**
     * @return string
     */
    public function getCssClasses();
}
