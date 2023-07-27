<?php
namespace Kirkor\MegaMenu\Api;

/**
 * Menu Items CRUD interface.
 *
 * @api
 */
interface MenuItemsRepositoryInterface
{
    /**
     * Save Menu Item.
     *
     * @param \Kirkor\MegaMenu\Api\Data\MenuItemsInterface $menu
     * @return \Kirkor\MegaMenu\Api\Data\MenuItemsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Kirkor\MegaMenu\Api\Data\MenuItemsInterface $menu);

    /**
     * Retrieve menu item.
     *
     * @param int $menuId
     * @return \Kirkor\MegaMenu\Model\MenuItems
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($menuId);

    /**
     * Retrieve menu matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete menu item.
     *
     * @param \Kirkor\MegaMenu\Api\Data\MenuItemsInterface $menu
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Magento\Framework\Model\AbstractModel $menu);

    /**
     * Delete menu item by ID.
     *
     * @param int $menuId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($menuId);
}
