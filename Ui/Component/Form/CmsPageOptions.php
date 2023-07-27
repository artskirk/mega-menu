<?php
namespace Kirkor\MegaMenu\Ui\Component\Form;

use Magento\Framework\Escaper;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Store\Ui\Component\Listing\Column\Store\Options as StoreOptions;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;

/**
 * Form Options.
 */
class CmsPageOptions extends StoreOptions implements \Kirkor\MegaMenu\Api\Data\OptionsInterface
{
    /**
     * @var \Kirkor\MegaMenu\Model\ResourceModel\MenuItems\Collection
     */
    protected $collection;

    /**
     * @param array
     */
    protected $options = [];

    /**
     * Options constructor.
     *
     * @param SystemStore       $systemStore
     * @param Escaper           $escaper
     * @param CollectionFactory $pageCollectionFactory
     */
    public function __construct(
        SystemStore $systemStore,
        Escaper $escaper,
        CollectionFactory $pageCollectionFactory
    ) {
        parent::__construct($systemStore, $escaper);
        $this->collection = $pageCollectionFactory->create();
    }

    /**
     * Get options.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $items = $this->collection->getItems();
        $this->setDefaultOption();

        /** @var \Magento\Cms\Api\Data\PageInterface $page */
        foreach ($items as $page) {
            $this->options[] = ['label' => __($page->getTitle()), 'value' => $page->getId()];
        }

        return $this->options;
    }

    /**
     * Get Default Option.
     *
     * @return array
     */
    public function getDefaultOption(): array
    {
        return array_key_exists(0, $this->options) ?
            $this->options[0] : [];
    }

    /**
     * Set Default Option.
     *
     * @return $this
     */
    public function setDefaultOption()
    {
        $this->options[] = ['label' => __('Please Select'), 'value' => 0];

        return $this;
    }
}
