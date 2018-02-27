<?php

namespace BootIq\CmsApiVendor\Nette\Factory;

use BootIq\CmsApiVendor\Adapter\AdapterInterface;
use BootIq\CmsApiVendor\Request\Page\PageRequestFactory;
use BootIq\CmsApiVendor\ResponseMapper\ResponseMapperFactory;
use BootIq\CmsApiVendor\Service\PageService;

class PageServiceFactory implements PageServiceFactoryInterface
{

    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var PageRequestFactory
     */
    private $pageRequestFactory;

    /**
     * @var ResponseMapperFactory
     */
    private $responseMapperFactory;

    /**
     * PageServiceFactory constructor.
     * @param AdapterInterface $adapter
     * @param PageRequestFactory $pageRequestFactory
     * @param ResponseMapperFactory $responseMapperFactory
     */
    public function __construct(
        AdapterInterface $adapter,
        PageRequestFactory $pageRequestFactory,
        ResponseMapperFactory $responseMapperFactory
    ) {
        $this->adapter = $adapter;
        $this->pageRequestFactory = $pageRequestFactory;
        $this->responseMapperFactory = $responseMapperFactory;
    }

    /**
     * @return PageService
     */
    public function createPageService(): PageService
    {
        return new PageService(
            $this->pageRequestFactory,
            $this->adapter,
            $this->responseMapperFactory->createPageResponseMapper()
        );
    }
}
