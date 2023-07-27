<?php
namespace Kirkor\MegaMenu\Ui\Component\Category\Listing\Column;

use Kirkor\MegaMenu\Api\MenuItemsRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class CmsPage column.
 */
class ParentMenu extends Column
{
    /**
     * @var MenuItemsRepositoryInterface
     */
    private $menuItemsRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param MenuItemsRepositoryInterface $menuItemsRepository
     * @param array $components
     * @param array $data
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ScopeConfigInterface $scopeConfig,
        MenuItemsRepositoryInterface $menuItemsRepository,
        array $components = [],
        array $data = []
    ) {
        $this->menuItemsRepository = $menuItemsRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = $this->getParentMenuTitleById($item['menu_id']);
            }
        }

        return $dataSource;
    }

    /**
     * @param int $menuId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getParentMenuTitleById($menuId = 0)
    {
        if (!$menuId) {
            return '';
        }

        return $this->menuItemsRepository->getById($menuId)->getTitle();
    }
}
