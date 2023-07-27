<?php
namespace Kirkor\MegaMenu\Ui\Component\Form;

use Kirkor\MegaMenu\Api\Data\OptionsInterface;
use Magento\Framework\Escaper;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Store\Ui\Component\Listing\Column\Store\Options as StoreOptions;
use Kirkor\MegaMenu\Model\ResourceModel\Category\CollectionFactory;

class CategoryOptions extends StoreOptions implements \Kirkor\MegaMenu\Api\Data\OptionsInterface
{
    /**
     * @var \Kirkor\MegaMenu\Model\ResourceModel\Category\Collection
     */
    protected $collection;

    /**
     * @param array
    */
    protected $options = [];

    /**
     * Options constructor.
     *
     * @param SystemStore $systemStore
     * @param Escaper $escaper
     * @param CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        SystemStore $systemStore,
        Escaper $escaper,
        CollectionFactory $categoryCollectionFactory
    ){
        parent::__construct($systemStore, $escaper);
        $this->collection = $categoryCollectionFactory->create();
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $items = $this->collection->getItems();
        $this->setDefaultOption();

        /** @var \Kirkor\MegaMenu\Api\Data\CategoryInterface $category */
        foreach ($items as $category) {
            $this->options[] = ['label' => __($category->getTitle()), 'value' => $category->getId()];
        }

        return $this->options;
    }

    /**
     * Get Default Option
     *
     * @return array
     */
    public function getDefaultOption(): array
    {
        return isset($this->options[0]) ?
            $this->options[0] : [];
    }

    /**
     * Set Default Option
     *
     * @return $this
     */
    public function setDefaultOption()
    {
        $this->options[] = ['label' => __('Please Select'), 'value' => 0];
        return $this;
    }
}
