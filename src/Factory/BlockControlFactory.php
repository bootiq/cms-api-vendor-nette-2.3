<?php

namespace BootIq\CmsApiVendor\Nette\Factory;

use BootIq\CmsApiVendor\Nette\Control\Block\HtmlBlockControl;
use BootIq\CmsApiVendor\Nette\Control\Block\LatteBlockControl;
use BootIq\CmsApiVendor\Nette\Control\Block\PlainTextBlockControl;
use Nette\Bridges\ApplicationLatte\ILatteFactory;

class BlockControlFactory
{

    /**
     * @var ILatteFactory
     */
    private $latteFactory;

    /**
     * BlockControlFactory constructor.
     * @param ILatteFactory $latteFactory
     */
    public function __construct(ILatteFactory $latteFactory)
    {
        $this->latteFactory = $latteFactory;
    }

    /**
     * @return HtmlBlockControl
     */
    public function getHtmlBlockControl(): HtmlBlockControl
    {
        return new HtmlBlockControl();
    }

    /**
     * @return PlainTextBlockControl
     */
    public function getPlainTextBlockControl(): PlainTextBlockControl
    {
        return new PlainTextBlockControl();
    }

    /**
     * @return LatteBlockControl
     */
    public function getLatteBlockControl(): LatteBlockControl
    {
        return new LatteBlockControl($this->latteFactory);
    }
}
