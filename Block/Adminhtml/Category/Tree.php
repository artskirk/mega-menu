<?php
namespace Kirkor\MegaMenu\Block\Adminhtml\Category;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Kirkor\MegaMenu\Model\ResourceModel\Category\CollectionFactory;
use Kirkor\MegaMenu\Model\ResourceModel\MenuItems\CollectionFactory as MenuCollectionFactory;
use Kirkor\MegaMenu\Api\Data\CategoryInterface;
use Kirkor\MegaMenu\Api\MenuItemsRepositoryInterface;
use Kirkor\MegaMenu\Api\Data\MenuItemsInterface;

/**
 * Class Tree.
 */
class Tree extends \Magento\Catalog\Block\Adminhtml\Category\AbstractCategory
{
    const CHILDREN = 'children';
    const MENU_ID = 'id';

    private PageRepositoryInterface $pageRepository;
    private SearchCriteriaBuilder $searchCriteria;
    private array $tree = [];
    private int $menuId = 0;
    private string $treeHtml = '';
    private \Kirkor\MegaMenu\Model\ResourceModel\Category\Collection $collection;
    private \Kirkor\MegaMenu\Model\ResourceModel\MenuItems\Collection $menuCollection;
    private MenuItemsRepositoryInterface $menuItemsRepository;
    private \Magento\Backend\Model\Auth\Session $backendSession;
    private \Magento\Framework\DB\Helper $resourceHelper;
    private StoreManagerInterface $storeManager;
    private \Magento\Framework\Json\EncoderInterface $jsonEncoder;
    private bool $isWebApi = false;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\Tree $categoryTree,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\DB\Helper $resourceHelper,
        \Magento\Backend\Model\Auth\Session $backendSession,
        CollectionFactory $categoryCollectionFactory,
        MenuCollectionFactory $menuCollectionFactory,
        StoreManagerInterface $storeManager,
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        MenuItemsRepositoryInterface $menuItemsRepository,
        array $data = []
    ) {
        $this->pageRepository = $pageRepository;
        $this->jsonEncoder = $jsonEncoder;
        $this->resourceHelper = $resourceHelper;
        $this->backendSession = $backendSession;
        $this->storeManager = $storeManager;
        $this->collection = $categoryCollectionFactory->create();
        $this->menuCollection = $menuCollectionFactory->create();
        $this->searchCriteria = $searchCriteriaBuilder;
        $this->menuItemsRepository = $menuItemsRepository;
        parent::__construct($context, $categoryTree, $registry, $categoryFactory, $data);
    }

    /**
     * @param CategoryInterface $item
     * @return array
     */
    private function getItemData(\Kirkor\MegaMenu\Api\Data\CategoryInterface $item)
    {
        if ($this->isWebApi) {
            return [
                CategoryInterface::TITLE => $item->getTitle(),
                CategoryInterface::CSS_CLASSES => (string) $item->getCssClasses(),
                CategoryInterface::URL => $item->getUrl(),
                CategoryInterface::NEW_TAB => $item->getInNewTab(),
                CategoryInterface::CMS_PAGE => $item->getCmsPage()
            ];
        } else {
            return $item->getData();
        }
    }

    /**
     * @param array $tree
     * @param \Kirkor\MegaMenu\Api\Data\CategoryInterface $item
     * @throws LocalizedException
     */
    private function appendToTree(array &$tree, CategoryInterface $item)
    {
        // Initialize tree
        if (empty($tree)) {
            $item->setData(self::CHILDREN, []);
            $tree[$item->getId()] = $this->getItemData($item);
            return;
        }

        /** @var \Kirkor\MegaMenu\Api\Data\CategoryInterface $category */
        foreach ($tree as $categoryId => &$category) {
            // Check in child categories
            if (!empty($category[self::CHILDREN])) {
                $this->appendToTree($category[self::CHILDREN], $item);
            }
            // Append to child
            if ($categoryId == $item->getParentId()) {
                $item->setData(self::CHILDREN, []);
                $item->setData(CategoryInterface::URL, $this->getItemUrl($item->getData()));
                $category[self::CHILDREN][$item->getId()] = $this->getItemData($item);
                return;
            }
            // Append 1st level category
            $item->setData(self::CHILDREN, []);
            $tree[$item->getId()] = $this->getItemData($item);
        }
        return;
    }

    /**
     * @param string $menuId
     * @return void
     */
    private function setMenuId(string $menuId = '')
    {
        if ($this->menuId) {
            return;
        }
        $menuId ? $this->menuId = $menuId : $this->menuId = $this->getRequest()->getParam(self::MENU_ID);
    }

    /**
     * Get related categories.
     * @return $this
     * @throws LocalizedException
     */
    private function prepareCategoriesTree()
    {
        $this->setMenuId();
        $this->collection->orderByParent()->setSortOrder();
        $items = $this->collection->getItems();
        /** @var \Kirkor\MegaMenu\Api\Data\CategoryInterface $category */
        foreach ($items as $category) {
            if ($this->menuId != $category->getMenuId() || !$category->getIsActive()) {
                continue;
            }
            $this->appendToTree($this->tree, $category);
        }
        return $this;
    }

    /**
     * @param array $item
     * @return string
     * @throws LocalizedException
     */
    private function getItemUrl($item)
    {
        if ($item[CategoryInterface::CMS_PAGE]) {
            return '/' . $this->pageRepository->getById($item[CategoryInterface::CMS_PAGE])->getIdentifier();
        }
        return $item[CategoryInterface::URL] ? $item[CategoryInterface::URL] : '#';
    }

    /**
     * @param \Kirkor\MegaMenu\Api\Data\CategoryInterface[] $tree
     * @return string
     * @throws LocalizedException
     */
    public function getTreeHtml(&$tree = false)
    {
        if (empty($tree)) {
            $this->prepareCategoriesTree();
            $tree = $this->tree;
        }
        $this->treeHtml .= '<ul>';
        foreach ($tree as $item) {
            $this->treeHtml .= sprintf(
                '<li data-sort-order="%s" data-item-id="%s" data-parent-id="%s"><a href="%s">%s</a>',
                $item[CategoryInterface::SORT_ORDER],
                $item[CategoryInterface::ID],
                $item[CategoryInterface::PARENT_ID],
                $item[CategoryInterface::URL],
                $item[CategoryInterface::TITLE]
            );
            empty($item[self::CHILDREN]) ?: $this->getTreeHtml($item[self::CHILDREN]);
            $this->treeHtml .= '</li>';
        }
        $this->treeHtml .= '</ul>';
        return $this->treeHtml;
    }

    /**
     * @param string $code
     * @param bool $isWebapi
     * @return string[]
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getMenuTree(string $code, $isWebapi = false)
    {
        $this->isWebApi = $isWebapi;
        $searchCriteria = $this->searchCriteria
            ->addFilter(MenuItemsInterface::CODE, $code,'eq')
            ->addFilter(MenuItemsInterface::STORE_ID, $this->storeManager->getStore()->getId())
            ->addFilter(MenuItemsInterface::IS_ACTIVE, true)
            ->create();

        try {
            $items = $this->menuItemsRepository->getList($searchCriteria)->getItems();
        } catch (LocalizedException $e) {
            throw new LocalizedException(__('Unable to load menu entity'));
        }

        if (empty($items)) {
            throw new NoSuchEntityException(__('Menu is not found'));
        }

        $this->setMenuId(current($items)->getId());
        $this->prepareCategoriesTree();
        return $this->tree;
    }
}
