<?php
namespace Kirkor\MegaMenu\Model\ResourceModel;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Kirkor\MegaMenu\Model\MenuItemsFactory;
use Kirkor\MegaMenu\Model\ResourceModel\MenuItems\CollectionFactory;
use Kirkor\MegaMenu\Api\Data\MenuItemsSearchResultsInterfaceFactory;
use Kirkor\MegaMenu\Api\Data\MenuItemsInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Menu Items repository.
 */
class MenuItemsRepository implements \Kirkor\MegaMenu\Api\MenuItemsRepositoryInterface
{
    /**
     * @var MenuItemsFactory
     */
    private $menuItemsFactory;

    /**
     * @var MenuItems
     */
    private $resource;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var MenuItemsSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @param MenuItemsFactory $menuItemsFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param MenuItems $menuItems
     * @param MenuItemsSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        MenuItemsFactory $menuItemsFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        MenuItems $menuItems,
        MenuItemsSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $menuItems;
        $this->menuItemsFactory = $menuItemsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save customer address.
     *
     * @param MenuItemsInterface $menu
     * @return MenuItemsInterface
     * @throws LocalizedException
     */
    public function save(MenuItemsInterface $menu)
    {
        $menuItemsModel = $this->menuItemsFactory->create();
        if (!$menu->getData()) {
            throw new LocalizedException(__('Data is not received'));
        }
        $menuItemsModel
            ->setData($menu->getData())
            ->save();

        return $menuItemsModel;
    }

    /**
     * Retrieve menu item.
     *
     * @param int $menuId
     * @return \Kirkor\MegaMenu\Model\MenuItems
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($menuId)
    {
        $menu = $this->menuItemsFactory->create();
        $this->resource->load($menu, $menuId);

        return $menu;
    }

    /**
     * Retrieve menu matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface[]
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Kirkor\MegaMenu\Model\ResourceModel\MenuItems\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        /** @var \Magento\Framework\Api\SearchResultsInterface[] $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * Delete menu item by ID.
     *
     * @param int $menuId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($menuId)
    {
        $menu = $this->getById($menuId);

        return $this->delete($menu);
    }

    /**
     * Delete menu item.
     *
     * @param \Kirkor\MegaMenu\Api\Data\MenuItemsInterface $menu
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     */
    public function delete(\Magento\Framework\Model\AbstractModel $menu)
    {
        try {
            $this->resource->delete($menu);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Unable to delete menu entity'), $exception);
        }

        return true;
    }
}
