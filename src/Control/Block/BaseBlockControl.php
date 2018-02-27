<?php

namespace BootIq\CmsApiVendor\Nette\Control\Block;

use BootIq\CmsApiVendor\DataObject\Block;
use Nette\Application\UI\Control;

abstract class BaseBlockControl extends Control implements BlockControlInterface
{

    /**
     * @var Block
     */
    protected $block;

    /**
     * @param Block $block
     */
    public function setBlock(Block $block)
    {
        $this->block = $block;
    }

    /**
     * @return Block
     */
    public function getBlock(): Block
    {
        return $this->block;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function render()
    {
        if (!$this->isValid($this->getBlock()->getType())) {
            throw new \InvalidArgumentException('Block with invalid type set');
        }
    }
}
