<?php
namespace Kirkor\MegaMenu\Api\Data;

/**
 * @api
 */
interface MenuItemsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Gets collection items.
     *
     * @return \Kirkor\MegaMenu\Api\Data\MenuItemsInterface[] array of collection items
     */
    public function getItems();

    /**
     * Sets collection items.
     *
     * @param \Kirkor\MegaMenu\Api\Data\MenuItemsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
