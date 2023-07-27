<?php
namespace Kirkor\MegaMenu\Model\ResourceModel;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Kirkor\MegaMenu\Api\Data\CategoryInterfaceFactory;
use Kirkor\MegaMenu\Model\ResourceModel\Category\CollectionFactory;
use Kirkor\MegaMenu\Api\Data\CategorySearchResultsInterfaceFactory;
use Kirkor\MegaMenu\Api\Data\CategoryInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Exception\LocalizedException;

/**
 * Category repository.
 */
class CategoryRepository implements \Kirkor\MegaMenu\Api\CategoryRepositoryInterface
{
    /**
     * @var CategoryInterfaceFactory
     */
    private $categoryFactory;

    /**
     * @var Category
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
     * @var CategorySearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * CategoryRepository constructor.
     * @param CategoryInterfaceFactory $categoryFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param Category $category
     * @param CategorySearchResultsInterfaceFactory $searchResultsFactory
     * @param Json $serializer
     */
    public function __construct(
        CategoryInterfaceFactory $categoryFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        Category $category,
        Json $serializer,
        CategorySearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $category;
        $this->categoryFactory = $categoryFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->serializer = $serializer;
    }

    /**
     * @param CategoryInterface $category
     * @return CategoryInterface
     * @throws LocalizedException
     */
    public function save(CategoryInterface $category)
    {
        $categoryModel = $this->categoryFactory->create();
        if (!$category->getData()) {
            throw new LocalizedException(__('Data is not received'));
        }
        $categoryModel
            ->setData($category->getData())
            ->save();

        return $categoryModel;
    }

    /**
     * @param string $dataStructure
     * @return bool
     * @throws \Exception
     */
    public function saveStructure(string $dataStructure)
    {
        if (empty($dataStructure)) {
            return false;
        }
        $structure = $this->unserializeStructure($dataStructure);
        $categoryIds = [];
        if (!is_array($structure)) {
            throw new \InvalidArgumentException('Invalid argument type');
        }
        $connection = $this->resource->getConnection();
        $sortOrderCondition = [];
        $parentIdCondition = [];
        foreach ($structure as $item) {
            $categoryIds[] = $item[CategoryInterface::ID];
            $sortOrderCondition[$item[CategoryInterface::ID]] = $item[CategoryInterface::SORT_ORDER];
            $parentIdCondition[$item[CategoryInterface::ID]] = $item[CategoryInterface::PARENT_ID];
        }
        $sortOrderCase = $connection->getCaseSql(
            CategoryInterface::ID,
            $sortOrderCondition,
            CategoryInterface::SORT_ORDER
        );
        $parentIdCase = $connection->getCaseSql(
            CategoryInterface::ID,
            $parentIdCondition,
            CategoryInterface::PARENT_ID
        );
        $where = ['category_id IN (?)' => $categoryIds];
        try {

            $connection->beginTransaction();
            $connection->update(
                $this->resource->getMainTable(),
                [CategoryInterface::SORT_ORDER => $sortOrderCase, CategoryInterface::PARENT_ID => $parentIdCase],
                $where
            );
            $connection->commit();

        } catch(\Exception $e) {
            $connection->rollBack();
            throw $e;
        }
        return true;
    }

    /**
     * Retrieve menu item.
     *
     * @param int $categoryId
     * @return \Kirkor\MegaMenu\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($categoryId)
    {
        $category = $this->categoryFactory->create();
        $this->resource->load($category, $categoryId);

        return $category;
    }

    /**
     * Retrieve menu matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface[]
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Kirkor\MegaMenu\Model\ResourceModel\Category\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        /** @var \Magento\Framework\Api\SearchResultsInterface[] $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * Delete category.
     *
     * @param \Kirkor\MegaMenu\Api\Data\CategoryInterface $category
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(CategoryInterface $category)
    {
        try {
            $this->resource->delete($category);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Unable to delete menu item'), $exception);
        }

        return true;
    }

    /**
     * Delete category by ID.
     *
     * @param int $categoryId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($categoryId)
    {
        $category = $this->getById($categoryId);

        return $this->delete($category);
    }

    /**
     * @param string $structure
     * @return mixed
     */
    private function unserializeStructure(string $structure)
    {
        return $this->serializer->unserialize($structure);
    }
}
