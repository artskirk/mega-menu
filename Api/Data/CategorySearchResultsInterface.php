<?php
namespace Kirkor\MegaMenu\Api\Data;

/**
 * @api
 */
interface CategorySearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Gets collection items.
     *
     * @return \Kirkor\MegaMenu\Api\Data\CategoryInterface[] array of collection items
     */
    public function getItems();

    /**
     * Sets collection items.
     *
     * @param \Kirkor\MegaMenu\Api\Data\CategoryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
