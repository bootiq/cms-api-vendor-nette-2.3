<?php

namespace BootIq\CmsApiVendor\Nette\Factory;

use BootIq\CmsApiVendor\Enum\BlockType;
use BootIq\CmsApiVendor\Nette\Control\PageControl;
use Psr\Log\LoggerInterface;

class PageControlFactory
{

    /**
     * @var PageServiceFactoryInterface
     */
    private $pageServiceFactory;

    /**
     * @var BlockControlFactory
     */
    private $blockControlFactory;

    /**
     * PageControlFactory constructor.
     * @param PageServiceFactoryInterface $pageServiceFactory
     * @param BlockControlFactory $blockControlFactory
     */
    public function __construct(
        PageServiceFactoryInterface $pageServiceFactory,
        BlockControlFactory $blockControlFactory
    ) {
        $this->pageServiceFactory = $pageServiceFactory;
        $this->blockControlFactory = $blockControlFactory;
    }

    /**
     * @param LoggerInterface|null $logger
     * @return PageControl
     */
    public function create(LoggerInterface $logger = null): PageControl
    {
        $pageService = $this->pageServiceFactory->createPageService();
        $control = new PageControl($pageService);
        if (null !== $logger) {
            $control->setLogger($logger);
        }
        $control->addBlockControlByType(
            $this->blockControlFactory->getHtmlBlockControl(),
            BlockType::BLOCK_TYPE_HTML
        );
        $control->addBlockControlByType(
            $this->blockControlFactory->getPlainTextBlockControl(),
            BlockType::BLOCK_TYPE_PLAIN
        );
        $control->addBlockControlByType(
            $this->blockControlFactory->getLatteBlockControl(),
            BlockType::BLOCK_TYPE_LATTE
        );
        return $control;
    }
}
