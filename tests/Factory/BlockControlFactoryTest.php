<?php

namespace BootIqTest\CmsApiVendor\Nette\Factory;

use BootIq\CmsApiVendor\Nette\Control\Block\HtmlBlockControl;
use BootIq\CmsApiVendor\Nette\Control\Block\LatteBlockControl;
use BootIq\CmsApiVendor\Nette\Control\Block\PlainTextBlockControl;
use BootIq\CmsApiVendor\Nette\Factory\BlockControlFactory;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use PHPUnit\Framework\TestCase;

class BlockControlFactoryTest extends TestCase
{

    /**
     * @var BlockControlFactory
     */
    private $instance;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $latteFactory = $this->createMock(ILatteFactory::class);
        $this->instance = new BlockControlFactory($latteFactory);
    }

    public function testHtmlBlockControlGetter()
    {
        $this->assertInstanceOf(
            HtmlBlockControl::class,
            $this->instance->getHtmlBlockControl()
        );
    }

    public function testPlainTextBlockControlGetter()
    {
        $this->assertInstanceOf(
            PlainTextBlockControl::class,
            $this->instance->getPlainTextBlockControl()
        );
    }

    public function testLatteBlockControlGetter()
    {
        $this->assertInstanceOf(
            LatteBlockControl::class,
            $this->instance->getLatteBlockControl()
        );
    }
}
