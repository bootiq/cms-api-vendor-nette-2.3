<?php

namespace BootIqTest\CmsApiVendor\Nette\Factory;

use BootIq\CmsApiVendor\Adapter\AdapterInterface;
use BootIq\CmsApiVendor\Nette\Factory\PageServiceFactory;
use BootIq\CmsApiVendor\Request\Page\PageRequestFactory;
use BootIq\CmsApiVendor\ResponseMapper\ResponseMapperFactory;
use BootIq\CmsApiVendor\Service\PageService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PageServiceFactoryTest extends TestCase
{
    /**
     * @var PageRequestFactory|MockObject
     */
    private $pageRequestFactory;

    /**
     * @var AdapterInterface|MockObject
     */
    private $adapter;

    /**
     * @var ResponseMapperFactory|MockObject
     */
    private $pageResponseMapperFactory;

    /**
     * @var PageServiceFactory
     */
    private $instance;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->pageRequestFactory = $this->createMock(PageRequestFactory::class);
        $this->adapter = $this->createMock(AdapterInterface::class);
        $this->pageResponseMapperFactory = $this->createMock(ResponseMapperFactory::class);

        $this->instance = new PageServiceFactory(
            $this->adapter,
            $this->pageRequestFactory,
            $this->pageResponseMapperFactory
        );
    }

    public function testSuccess()
    {
        $result = $this->instance->createPageService();
        $this->assertInstanceOf(PageService::class, $result);
    }
}