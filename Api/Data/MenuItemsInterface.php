<?php
namespace Kirkor\MegaMenu\Api\Data;

/**
 * Menu Items interface.
 *
 * @api
 */
interface MenuItemsInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const CSS_CLASSES = 'css_classes';
    const TITLE = 'title';
    const CODE = 'code';
    const IS_ACTIVE = 'is_active';
    const STORE_ID = 'store_id';
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
     * Get Is Active flag.
     *
     * @return int|null
     */
    public function getIsActive();

    /**
     * Set menu title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * Get menu title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set Is Active flag.
     *
     * @param bool|int $flag
     * @return $this
     */
    public function setIsActive($flag);

    /**
     * Get Store ID.
     *
     * @return int|null
     */
    public function getStoreId();

    /**
     * Set Store ID.
     *
     * @param mixed $id
     * @return $this
     */
    public function setStoreId($id);
}
