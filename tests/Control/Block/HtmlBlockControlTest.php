<?php

namespace BootIqTest\CmsApiVendor\Nette\Control\Block;

use BootIq\CmsApiVendor\DataObject\Block;
use BootIq\CmsApiVendor\Enum\BlockType;
use BootIq\CmsApiVendor\Nette\Control\Block\HtmlBlockControl;
use PHPUnit\Framework\TestCase;

class HtmlBlockControlTest extends TestCase
{

    public function testAll()
    {
        $instance = new HtmlBlockControl();

        $this->assertTrue($instance->isValid(BlockType::BLOCK_TYPE_HTML));
        $this->assertFalse($instance->isValid(BlockType::BLOCK_TYPE_LATTE));
        $this->assertFalse($instance->isValid(BlockType::BLOCK_TYPE_PLAIN));
    }

    public function testInvalidBlockType()
    {
        $block = $this->createMock(Block::class);
        $blockType = uniqid();

        $instance = new HtmlBlockControl();
        $instance->setBlock($block);

        $block->expects(self::once())
            ->method('getType')
            ->willReturn($blockType);

        $this->expectException(\InvalidArgumentException::class);
        $instance->render();
    }
}
