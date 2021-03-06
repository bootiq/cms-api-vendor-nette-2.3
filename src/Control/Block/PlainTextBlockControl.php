<?php

namespace BootIq\CmsApiVendor\Nette\Control\Block;

use BootIq\CmsApiVendor\Enum\BlockType;
use Nette\Application\UI\ITemplate;

class PlainTextBlockControl extends BaseBlockControl
{

    /**
     * Creates component template
     * @param string
     * @return ITemplate
     */
    protected function createTemplate()
    {
        $template = parent::createTemplate();
        $filePath = __DIR__ . '/../../../templates/block/PlainTextBlockControl.latte';
        $template->setFile($filePath);
        return $template;
    }

    /**
     * @param string $blockType
     * @return bool
     */
    public function isValid(string $blockType): bool
    {
        return ($blockType === BlockType::BLOCK_TYPE_PLAIN);
    }

    /**
     * @return void
     */
    public function render()
    {
        parent::render();
        $this->template->blockContent = $this->block->getContent();
        $this->template->render();
    }
}
