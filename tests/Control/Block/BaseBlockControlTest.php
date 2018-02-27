<?php

namespace BootIqTest\CmsApiVendor\Nette\Control\Block;

use BootIq\CmsApiVendor\DataObject\Block;
use BootIq\CmsApiVendor\Nette\Control\Block\BaseBlockControl;
use PHPUnit\Framework\TestCase;

class BaseBlockControlTest extends TestCase
{

    /**
     * @var BaseBlockControl
     */
    private $instance;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->instance = new class extends BaseBlockControl
        {

            /**
             * @param string $blockType
             * @return bool
             */
            public function isValid(string $blockType): bool
            {
                return true;
            }
        };
    }

    public function testAll()
    {
        $block = $this->createMock(Block::class);

        $this->instance->setBlock($block);
        $this->assertEquals($block, $this->instance->getBlock());
    }
}
