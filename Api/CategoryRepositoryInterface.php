<?php
namespace Kirkor\MegaMenu\Api;

/**
 * Category CRUD interface.
 *
 * @api
 */
interface CategoryRepositoryInterface
{
    /**
     * Save Category.
     *
     * @param \Kirkor\MegaMenu\Api\Data\CategoryInterface $menu
     * @return \Kirkor\MegaMenu\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Kirkor\MegaMenu\Api\Data\CategoryInterface $menu);

    /**
     * Retrieve category.
     *
     * @param int $categoryId
     * @return \Kirkor\MegaMenu\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($categoryId);

    /**
     * Retrieve menu matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete category.
     *
     * @param \Kirkor\MegaMenu\Api\Data\CategoryInterface $category
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Kirkor\MegaMenu\Api\Data\CategoryInterface $category);

    /**
     * Delete category by ID.
     *
     * @param int $categoryId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($categoryId);
}
