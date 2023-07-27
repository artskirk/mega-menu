<?php
namespace Kirkor\MegaMenu\Ui\Component\Category\Listing\Column;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Customer\Model\AccountConfirmation;

/**
 * Class CmsPage column.
 */
class CmsPage extends Column
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param PageRepositoryInterface $pageRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ScopeConfigInterface $scopeConfig,
        PageRepositoryInterface $pageRepository,
        array $components,
        array $data
    ) {
        $this->pageRepository = $pageRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = $this->getCmsPageTitleById($item['cms_page']);
            }
        }

        return $dataSource;
    }

    /**
     * @param int $pageId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getCmsPageTitleById($pageId = 0)
    {
        if (!$pageId) {
            return '';
        }

        return $this->pageRepository->getById($pageId)->getTitle();
    }
}
