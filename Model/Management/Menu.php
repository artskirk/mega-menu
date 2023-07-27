<?php

declare(strict_types=1);

namespace Kirkor\MegaMenu\Model\Management;

use Kirkor\MegaMenu\Api\Data\MenuInterface;
use Kirkor\MegaMenu\Block\Adminhtml\Category\Tree;

class Menu implements MenuInterface
{
    /**
     * @param Tree
     */
    private $tree;

    /**
     * Menu constructor.
     * @param Tree $tree
     */
    public function __construct(Tree $tree)
    {
        $this->tree = $tree;
    }

    /**
     * @param string $code
     * @return string[]
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMenu(string $code)
    {
        return $this->tree->getMenuTree($code, true);
    }
}
