<?php
namespace Kirkor\MegaMenu\Controller\Adminhtml\Item;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Kirkor\MegaMenu\Controller\Adminhtml\Index;
use Magento\Framework\Exception\LocalizedException;

class Delete extends Index implements HttpPostActionInterface
{
    const ID = 'id';
    const ITEM_TYPE_KEY = 'item_type';
    const TYPE_MENU = 'menu';
    const TYPE_CATEGORY = 'category';

    /**
     * Save menu item action.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $itemId = $this->getRequest()->getParam(self::ID);
        $itemType = $this->getRequest()->getParam(self::ITEM_TYPE_KEY);
        $path = '*/';

        if (empty($itemType) || !$itemId) {
            throw new LocalizedException(__('Data has not been removed'));
        }

        if (self::TYPE_MENU == $itemType) {
            $this->menuItemsRepository->deleteById($itemId);
        }

        if (self::TYPE_CATEGORY == $itemType) {
            $this->categoryRepository->deleteById($itemId);
            $path = '*/index/categories/';
        }

        return $resultRedirect->setPath($path);
    }
}
