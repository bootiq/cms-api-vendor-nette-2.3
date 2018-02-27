<?php

namespace BootIqTest\CmsApiVendor\Nette\Control;

use BootIq\CmsApiVendor\DataObject\Block;
use BootIq\CmsApiVendor\DataObject\Layout;
use BootIq\CmsApiVendor\DataObject\Page;
use BootIq\CmsApiVendor\Exception\CmsApiVendorException;
use BootIq\CmsApiVendor\Nette\Control\Block\BlockControlInterface;
use BootIq\CmsApiVendor\Nette\Control\PageControl;
use BootIq\CmsApiVendor\Service\PageService;
use Latte\CompileException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class PageControlTest extends TestCase
{

    /**
     * @var PageService|MockObject
     */
    private $pageService;

    /**
     * @var BlockControlInterface|MockObject
     */
    private $blockControl;

    /**
     * @var PageControl
     */
    private $instance;

    /**
     * @var string
     */
    private $blockType;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->pageService = $this->createMock(PageService::class);
        $this->blockControl = $this->createMock(BlockControlInterface::class);
        $this->blockType = uniqid();

        $this->instance = new PageControl($this->pageService);
        $this->instance->addBlockControlByType($this->blockControl, $this->blockType);
    }

    public function testSuccess()
    {
        $pageSlug = uniqid();
        $useCache = false;

        $page = $this->createMock(Page::class);
        $layout = $this->createMock(Layout::class);
        $block = $this->createMock(Block::class);

        $this->pageService->expects(self::once())
            ->method('getPageBySlug')
            ->with($pageSlug, $useCache)
            ->willReturn($page);
        $page->expects(self::once())
            ->method('getLayout')
            ->willReturn($layout);
        $layout->expects(self::once())
            ->method('getBlocks')
            ->willReturn([$block]);
        $block->expects(self::once())
            ->method('getType')
            ->willReturn($this->blockType);
        $this->blockControl->expects(self::once())
            ->method('isValid')
            ->with($this->blockType)
            ->willReturn(true);
        $this->blockControl->expects(self::once())
            ->method('setBlock')
            ->with($block);
        $this->blockControl->expects(self::once())
            ->method('setParent');
        $this->blockControl->expects(self::once())
            ->method('render');

        $this->instance->render($pageSlug, $useCache);
    }

    public function testErrorCmsApi()
    {
        $pageSlug = uniqid();
        $useCache = false;
        $exception = new CmsApiVendorException();

        $logger = $this->createMock(LoggerInterface::class);
        $this->instance->setLogger($logger);

        $this->pageService->expects(self::once())
            ->method('getPageBySlug')
            ->with($pageSlug, $useCache)
            ->willThrowException($exception);
        $logger->expects(self::once())
            ->method('error')
            ->with($exception);
        $this->instance->render($pageSlug, $useCache);
    }

    public function testErrorTypeNotFound()
    {
        $pageSlug = uniqid();
        $useCache = false;

        $logger = $this->createMock(LoggerInterface::class);
        $page = $this->createMock(Page::class);
        $layout = $this->createMock(Layout::class);
        $block = $this->createMock(Block::class);
        $this->instance->setLogger($logger);

        $this->pageService->expects(self::once())
            ->method('getPageBySlug')
            ->with($pageSlug, $useCache)
            ->willReturn($page);
        $page->expects(self::once())
            ->method('getLayout')
            ->willReturn($layout);
        $layout->expects(self::once())
            ->method('getBlocks')
            ->willReturn([$block]);
        $block->expects(self::once())
            ->method('getType')
            ->willReturn($this->blockType);
        $this->blockControl->expects(self::once())
            ->method('isValid')
            ->with($this->blockType)
            ->willReturn(false);
        $logger->expects(self::once())
            ->method('warning');

        $this->instance->render($pageSlug, $useCache);
    }

    public function testCompileError()
    {
        $pageSlug = uniqid();
        $useCache = false;

        $logger = $this->createMock(LoggerInterface::class);
        $page = $this->createMock(Page::class);
        $layout = $this->createMock(Layout::class);
        $block = $this->createMock(Block::class);
        $this->instance->setLogger($logger);

        $this->pageService->expects(self::once())
            ->method('getPageBySlug')
            ->with($pageSlug, $useCache)
            ->willReturn($page);
        $page->expects(self::once())
            ->method('getLayout')
            ->willReturn($layout);
        $layout->expects(self::once())
            ->method('getBlocks')
            ->willReturn([$block]);
        $block->expects(self::once())
            ->method('getType')
            ->willReturn($this->blockType);
        $this->blockControl->expects(self::once())
            ->method('isValid')
            ->with($this->blockType)
            ->willReturn(true);
        $this->blockControl->expects(self::once())
            ->method('setBlock')
            ->with($block);
        $this->blockControl->expects(self::once())
            ->method('setParent');
        $this->blockControl->expects(self::once())
            ->method('render')
            ->willThrowException(new CompileException());
        $logger->expects(self::once())
            ->method('error');

        $this->instance->render($pageSlug, $useCache);
    }
}
