<?php

namespace BootIq\CmsApiVendor\Nette\Factory;

use BootIq\CmsApiVendor\Service\PageService;

/**
 * Interface PageServiceFactoryInterface
 */
interface PageServiceFactoryInterface
{

    public function createPageService(): PageService;
}
