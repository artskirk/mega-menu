<?php
namespace Kirkor\MegaMenu\Controller\Adminhtml\Item;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Kirkor\MegaMenu\Controller\Adminhtml\Index;
use Magento\Framework\Exception\LocalizedException;

class Save extends Index implements HttpPostActionInterface
{
    const ITEM_TYPE_KEY = 'item_type';
    const TYPE_MENU = 'menu';
    const TYPE_CATEGORY = 'category';
    const MENU_STRUCTURE = 'menu_structure';

    /**
     * Save menu item action
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $path = '*/';

        if (empty($data) || !array_key_exists(self::ITEM_TYPE_KEY, $data)) {
            throw new LocalizedException(__('Data has not been received'));
        }

        if ($data[self::ITEM_TYPE_KEY] == self::TYPE_MENU) {
            $menuItems = $this->menuItemsFactory->create();
            $menuItems->setData($data);
            $this->categoryRepository->saveStructure($data[self::MENU_STRUCTURE]);
            $this->menuItemsRepository->save($menuItems);
        }

        if ($data[self::ITEM_TYPE_KEY] == self::TYPE_CATEGORY) {
            $category = $this->categoryFactory->create();
            $category->setData($data);
            $this->categoryRepository->save($category);
            $path = '*/index/categories/';
        }

        return $resultRedirect->setPath($path);
    }
}
