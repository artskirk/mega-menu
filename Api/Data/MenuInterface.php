<?php
namespace Kirkor\MegaMenu\Api\Data;

interface MenuInterface
{
    /**
     * @param string $code
     * @return string[]
     */
    public function getMenu(string $code);
}
