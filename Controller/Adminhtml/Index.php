<?php
namespace Kirkor\MegaMenu\Controller\Adminhtml;

use Kirkor\MegaMenu\Api\Data\MenuItemsInterfaceFactory;
use Kirkor\MegaMenu\Api\Data\CategoryInterfaceFactory;
use Kirkor\MegaMenu\Api\MenuItemsRepositoryInterface;
use Kirkor\MegaMenu\Api\CategoryRepositoryInterface;
use Magento\Backend\App\Action\Context;

abstract class Index extends \Magento\Backend\App\Action
{
    /**
     * @var MenuItemsInterfaceFactory
     */
    protected $menuItemsFactory;

    /**
     * @var MenuItemsRepositoryInterface
     */
    protected $menuItemsRepository;

    /**
     * @var CategoryInterfaceFactory
     */
    protected $categoryFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param MenuItemsInterfaceFactory $menuItemsFactory
     * @param CategoryInterfaceFactory $categoryFactory
     * @param MenuItemsRepositoryInterface $menuItemsRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        Context $context,
        MenuItemsInterfaceFactory $menuItemsFactory,
        CategoryInterfaceFactory $categoryFactory,
        MenuItemsRepositoryInterface $menuItemsRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->menuItemsFactory = $menuItemsFactory;
        $this->menuItemsRepository = $menuItemsRepository;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;

        parent::__construct($context);
    }
}
