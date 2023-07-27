<?php
namespace Kirkor\MegaMenu\Model\Config\Source;

use Kirkor\MegaMenu\Model\ResourceModel\MenuItems\Collection;
use Kirkor\MegaMenu\Model\ResourceModel\MenuItems\CollectionFactory;
use Magento\Framework\Option\ArrayInterface;

class Options implements ArrayInterface
{
    protected Collection $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory->create();
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $items = $this->collectionFactory->getItems();
        $options = [];

        foreach ($items as $item) {
            $options[] = [
                'value' => $item->getCode(),
                'label' => __($item->getTitle())
            ];
        }
        return $options;
    }
}
