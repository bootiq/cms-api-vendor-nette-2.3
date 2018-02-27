<?php

namespace BootIq\CmsApiVendor\Nette\Control\Block;

use BootIq\CmsApiVendor\DataObject\Block;
use Nette\ComponentModel\IContainer;
use Nette\InvalidStateException;

interface BlockControlInterface
{

    /**
     * @param Block $block
     */
    public function setBlock(Block $block);

    /**
     * @return Block
     */
    public function getBlock(): Block;

    /**
     * @param string $blockType
     * @return bool
     */
    public function isValid(string $blockType): bool;

    /**
     * @return void
     */
    public function render();

    /**
     * Sets or removes the parent of this component. This method is managed by containers and should
     * not be called by applications
     * @param $parent IContainer
     * @param $name string
     * @return static
     * @throws InvalidStateException
     */
    public function setParent(IContainer $parent = null, $name = null);
}
