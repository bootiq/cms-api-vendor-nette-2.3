<?php

namespace BootIqTest\CmsApiVendor\Nette\Control\Block;

use BootIq\CmsApiVendor\DataObject\Block;
use BootIq\CmsApiVendor\Enum\BlockType;
use BootIq\CmsApiVendor\Nette\Control\Block\LatteBlockControl;
use Latte\Engine;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use PHPUnit\Framework\TestCase;

class LatteBlockControlTest extends TestCase
{

    public function testAll()
    {
        $latteFactory = $this->createMock(ILatteFactory::class);
        $engine = $this->createMock(Engine::class);
        $block = $this->createMock(Block::class);
        $blockType = BlockType::BLOCK_TYPE_LATTE;
        $content = uniqid();

        $instance = new LatteBlockControl($latteFactory);
        $instance->setBlock($block);

        $latteFactory->expects(self::once())
            ->method('create')
            ->willReturn($engine);
        $engine->expects(self::once())
            ->method('setLoader');
        $block->expects(self::once())
            ->method('getType')
            ->willReturn($blockType);
        $block->expects(self::once())
            ->method('getContent')
            ->willReturn($content);
        $engine->expects(self::once())
            ->method('render')
            ->with($content);

        $this->assertTrue($instance->isValid(BlockType::BLOCK_TYPE_LATTE));
        $this->assertFalse($instance->isValid(BlockType::BLOCK_TYPE_HTML));
        $this->assertFalse($instance->isValid(BlockType::BLOCK_TYPE_PLAIN));
        $instance->render();
    }

    public function testInvalidBlockType()
    {
        $latteFactory = $this->createMock(ILatteFactory::class);
        $block = $this->createMock(Block::class);
        $blockType = uniqid();

        $instance = new LatteBlockControl($latteFactory);
        $instance->setBlock($block);

        $block->expects(self::once())
            ->method('getType')
            ->willReturn($blockType);

        $this->expectException(\InvalidArgumentException::class);
        $instance->render();
    }
}
