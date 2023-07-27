<?php
namespace Kirkor\MegaMenu\Api\Data;

/**
 * Options interface.
 *
 * @api
 */
interface OptionsInterface
{
    /**
     * Get Default Option.
     *
     * @return array
     */
    public function getDefaultOption(): array;

    /**
     * Set Default Option.
     *
     * @return $this
     */
    public function setDefaultOption();
}
