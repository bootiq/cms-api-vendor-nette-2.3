<?php

namespace BootIqTest\CmsApiVendor\Nette\Factory;

use BootIq\CmsApiVendor\Nette\Control\Block\HtmlBlockControl;
use BootIq\CmsApiVendor\Nette\Control\Block\LatteBlockControl;
use BootIq\CmsApiVendor\Nette\Control\Block\PlainTextBlockControl;
use BootIq\CmsApiVendor\Nette\Control\PageControl;
use BootIq\CmsApiVendor\Nette\Factory\BlockControlFactory;
use BootIq\CmsApiVendor\Nette\Factory\PageControlFactory;
use BootIq\CmsApiVendor\Nette\Factory\PageServiceFactoryInterface;
use BootIq\CmsApiVendor\Service\PageService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class PageControlFactoryTest extends TestCase
{

    /**
     * @var PageServiceFactoryInterface|MockObject
     */
    private $pageServiceFactory;

    /**
     * @var BlockControlFactory|MockObject
     */
    private $blockControlFactory;

    /**
     * @var PageControlFactory
     */
    private $instance;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->pageServiceFactory = $this->createMock(PageServiceFactoryInterface::class);
        $this->blockControlFactory = $this->createMock(BlockControlFactory::class);

        $this->instance = new PageControlFactory(
            $this->pageServiceFactory,
            $this->blockControlFactory
        );
    }

    public function testAll()
    {
        $pageService = $this->createMock(PageService::class);

        $this->pageServiceFactory->expects(self::once())
            ->method('createPageService')
            ->willReturn($pageService);
        $this->blockControlFactory->expects(self::once())
            ->method('getHtmlBlockControl')
            ->willReturn($this->createMock(HtmlBlockControl::class));
        $this->blockControlFactory->expects(self::once())
            ->method('getPlainTextBlockControl')
            ->willReturn($this->createMock(PlainTextBlockControl::class));
        $this->blockControlFactory->expects(self::once())
            ->method('getLatteBlockControl')
            ->willReturn($this->createMock(LatteBlockControl::class));

        $result = $this->instance->create();
        $this->assertInstanceOf(PageControl::class, $result);
    }

    public function testAllWithLogger()
    {
        $pageService = $this->createMock(PageService::class);
        $logger = $this->createMock(LoggerInterface::class);

        $this->pageServiceFactory->expects(self::once())
            ->method('createPageService')
            ->willReturn($pageService);
        $this->blockControlFactory->expects(self::once())
            ->method('getHtmlBlockControl')
            ->willReturn($this->createMock(HtmlBlockControl::class));
        $this->blockControlFactory->expects(self::once())
            ->method('getPlainTextBlockControl')
            ->willReturn($this->createMock(PlainTextBlockControl::class));
        $this->blockControlFactory->expects(self::once())
            ->method('getLatteBlockControl')
            ->willReturn($this->createMock(LatteBlockControl::class));

        $result = $this->instance->create($logger);
        $this->assertInstanceOf(PageControl::class, $result);
    }
}
