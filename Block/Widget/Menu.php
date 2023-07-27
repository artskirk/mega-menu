<?php

namespace Kirkor\MegaMenu\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template\Context;

class Menu extends Template implements BlockInterface
{
    protected $_template = "widget/menu.phtml";
}
