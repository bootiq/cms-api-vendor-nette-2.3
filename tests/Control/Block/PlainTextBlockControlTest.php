<?php

namespace BootIqTest\CmsApiVendor\Nette\Control\Block;

use BootIq\CmsApiVendor\DataObject\Block;
use BootIq\CmsApiVendor\Enum\BlockType;
use BootIq\CmsApiVendor\Nette\Control\Block\PlainTextBlockControl;
use PHPUnit\Framework\TestCase;

class PlainTextBlockControlTest extends TestCase
{

    public function testAll()
    {
        $instance = new PlainTextBlockControl();

        $this->assertTrue($instance->isValid(BlockType::BLOCK_TYPE_PLAIN));
        $this->assertFalse($instance->isValid(BlockType::BLOCK_TYPE_HTML));
        $this->assertFalse($instance->isValid(BlockType::BLOCK_TYPE_LATTE));
    }

    public function testInvalidBlockType()
    {
        $block = $this->createMock(Block::class);
        $blockType = uniqid();

        $instance = new PlainTextBlockControl();
        $instance->setBlock($block);

        $block->expects(self::once())
            ->method('getType')
            ->willReturn($blockType);

        $this->expectException(\InvalidArgumentException::class);
        $instance->render();
    }
}
