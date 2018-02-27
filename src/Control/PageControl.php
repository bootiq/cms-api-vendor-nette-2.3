<?php

namespace BootIq\CmsApiVendor\Nette\Control;

use BootIq\CmsApiVendor\DataObject\Block;
use BootIq\CmsApiVendor\Exception\CmsApiVendorException;
use BootIq\CmsApiVendor\Nette\Control\Block\BaseBlockControl;
use BootIq\CmsApiVendor\Nette\Control\Block\BlockControlInterface;
use BootIq\CmsApiVendor\Service\PageService;
use Latte\CompileException;
use Nette\Application\UI\Control;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @method onNotRendered(\Exception $exception)
 * @method onBlockNotRendered(Block $block, \Exception $exception)
 */
class PageControl extends Control
{

    /**
     * @var array
     */
    public $onNotRendered = [];

    /**
     * @var array
     */
    public $onBlockNotRendered = [];

    /**
     * @var PageService
     */
    private $pageService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array|BaseBlockControl[]
     */
    private $blockControls = [];

    /**
     * PageControl constructor.
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        parent::__construct();
        $this->pageService = $pageService;
        $this->logger = new NullLogger();
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param BlockControlInterface $blockControl
     * @param string $blockType
     */
    public function addBlockControlByType(BlockControlInterface $blockControl, string $blockType)
    {
        $this->blockControls[$blockType] = $blockControl;
    }

    /**
     * @param string $pageSlug
     * @param bool $useCache
     */
    public function render(string $pageSlug, bool $useCache)
    {
        try {
            $page = $this->pageService->getPageBySlug($pageSlug, $useCache);
        } catch (CmsApiVendorException $exception) {
            $this->logger->error($exception);
            $this->onNotRendered($exception);
            return;
        }

        $blocks = $page->getLayout()->getBlocks();
        $rendered = false;
        foreach ($blocks as $block) {
            $rendered |= $this->renderBlock($block);
        }

        if (false === $rendered) {
            $this->onNotRendered(new CmsApiVendorException('Page not rendered'));
        }
    }

    /**
     * @param Block $block
     * @return bool
     */
    private function renderBlock(Block $block): bool
    {
        $blockType = $block->getType();
        /** @var BaseBlockControl $control */
        foreach ($this->blockControls as $control) {
            if (!$control->isValid($blockType)) {
                continue;
            }

            $control->setBlock($block);
            $control->setParent($this);
            try {
                $control->render();
                return true;
            } catch (CompileException $exception) {
                $this->logger->error($exception);
                $this->onBlockNotRendered($block, $exception);
                return false;
            }
        }
        $this->logger->warning('Control for type:' . $blockType . ' not defined');
        $this->onBlockNotRendered($block, new CmsApiVendorException('Control for type:' . $blockType . ' not defined'));
        return false;
    }
}
