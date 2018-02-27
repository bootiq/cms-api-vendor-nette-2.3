<?php

namespace BootIq\CmsApiVendor\Nette\Control\Block;

use BootIq\CmsApiVendor\Enum\BlockType;
use Latte\Engine;
use Latte\Loaders\StringLoader;
use Nette\Application\UI\ITemplate;
use Nette\Bridges\ApplicationLatte\ILatteFactory;

class LatteBlockControl extends BaseBlockControl
{

    /**
     * @var ILatteFactory
     */
    private $latteFactory;

    /**
     * KosikHtmlBlockControl constructor.
     * @param ILatteFactory $latteFactory
     */
    public function __construct(ILatteFactory $latteFactory)
    {
        parent::__construct();
        $this->latteFactory = $latteFactory;
    }

    /**
     * @param string $blockType
     * @return bool
     */
    public function isValid(string $blockType): bool
    {
        return ($blockType === BlockType::BLOCK_TYPE_LATTE);
    }

    /**
     * @return void
     */
    public function render()
    {
        parent::render();
        $latteEngine = $this->latteFactory->create();
        $latteEngine->setLoader(new StringLoader());
        $latteEngine->render($this->block->getContent());
    }
}
