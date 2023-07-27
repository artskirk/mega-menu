<?php
namespace Kirkor\MegaMenu\Ui\Component\Form;

use Magento\Framework\Escaper;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Store\Ui\Component\Listing\Column\Store\Options as StoreOptions;
use Kirkor\MegaMenu\Model\ResourceModel\MenuItems\CollectionFactory;

/**
 * Form Options.
 */
class MenuItemOptions extends StoreOptions
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
     * @param CollectionFactory $menuCollectionFactory
     */
    public function __construct(
        SystemStore $systemStore,
        Escaper $escaper,
        CollectionFactory $menuCollectionFactory
    ) {
        parent::__construct($systemStore, $escaper);
        $this->collection = $menuCollectionFactory->create();
    }

    /**
     * Get options.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $items = $this->collection->getItems();
        /** @var \Kirkor\MegaMenu\Api\Data\MenuItemsInterface $menu */
        foreach ($items as $menu) {
            $this->options[] = ['label' => __($menu->getTitle()), 'value' => $menu->getId()];
        }

        return $this->options;
    }
}
