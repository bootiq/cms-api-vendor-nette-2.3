<?php

namespace BootIq\CmsApiVendor\Nette\DI;

use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;

final class CmsApiVendorExtension extends CompilerExtension
{

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $this->compiler->parseServices(
            $builder,
            $this->loadFromFile(__DIR__ . '/../../config/services.neon'),
            $this->name
        );
    }
}
