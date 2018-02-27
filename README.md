BootIq - CMS API vendor for Nette
========
![BOOT!Q Logo](http://www.bootiq.io/images/footer-logo.png "BOOT!Q")


[![pipeline status](https://gitlab.mb-e.sk/platform/vendor-cms-api-nette/badges/master/pipeline.svg)](https://gitlab.mb-e.sk/platform/vendor-cms-api-nette/commits/master) [![coverage report](https://gitlab.mb-e.sk/platform/vendor-cms-api-nette/badges/master/coverage.svg)](https://gitlab.mb-e.sk/platform/vendor-cms-api-nette/commits/master)

## Installation

For installation of Boot!Q CMS API vendor for Nette, use composer 

```bash
composer require bootiq/cms-api-vendor-nette-2.3
```
## Configuration

Add Boot!Q CMS API vendor for Nette to your extensions:
```neon
extensions:
    - BootIq\CmsApiVendor\Nette\DI\CmsApiVendorExtension
```

Register adapter for communication by defining biq_cms_adapter to services configuration:
```neon
services:
    biq_cms_adapter:
        class: BootIq\CmsApiVendor\Adapter\GuzzleSecurityTokenAdapter(GuzzleHttp\Client(), BootIq\CmsApiVendor\Response\ResponseFactory(), %cms_api.urn%, %cms_api.publicId%, %cms_api.secret%)
```

Finally define parameters for configuration (name are used above in adapter definition):
```neon
parameters:
    cms_api:
        urn: "<cms.example.com/api>"
        publicId: "<public ID>"
        secret: "<secret>"
```

## Usage

Inject PageControlFactory into your Presenter and create PageControl component.
For example:
```php
    /**
     * @var PageControlFactory
     * @inject
     */
    public $pageControlFactory;

    /**
     * @return PageControl
     */
    public function createComponentPageControl(): PageControl
    {
        $control = $this->pageControlFactory->create();
        return $control;
    }
```

Now use PageControl component in your latte template:
```latte
{block content}
    <div id="banner">
        <h1 n:block=title>Congratulations!</h1>
    </div>

    <div id="content">
        <h2>You have successfully using Boot!Q CMS API vendor for Nette.</h2>
        <p>
            {control pageControl "/hello-workld-slug", false}
        </p>
    </div>
{/block}
```

## Modification

### Fallbacks

If nothing is rendered, callback *onNotRendered($mixed)* is triggered.
If one of the block is not rendered, callback *onBlockNotRendered(Block $block, \Exception $exception)* is triggered.
Example of usage of our callback.

```php
    /**
     * @var PageControlFactory
     * @inject
     */
    public $pageControlFactory;

    /**
     * @return PageControl
     */
    public function createComponentPageControl(): PageControl
    {
        $control = $this->pageControlFactory->create();
        
        $control->onNotRendered[] = function ($exception) {
            // DO SOMETHING WITH EXCEPTION
        };
        $control->onBlockNotRendered[] = function ($block, $exception) {
            // DO SOMETHING WITH BLOCK OR EXCEPTION
        };        
        
        return $control;
    }
```

### Own BlockControl

If you want use your own BlockControl, simply create new Control which implements *BootIq\CmsApiVendor\Nette\Control\Block\BlockControlInterface*.
Then register it to PageControl in createComponent method:
```php
    /**
     * @var PageControlFactory
     * @inject
     */
    public $pageControlFactory;

    /**
     * @return PageControl
     */
    public function createComponentPageControl(): PageControl
    {
        $control = $this->pageControlFactory->create();
        $myOwnBlockControl = new MyOwnBlockControl();
         
        $control->addBlockControlByType($myOwnBlockControl, 'myOwnBlockType');
        
        return $control;
    }
```

### Logger

If you want log, what is going on in our PageControl simply set Logger to PageControl in createComponent method.
Logger have to implement PSR-3 LoggerInterface.
For example:
```php
    /**
     * @var PageControlFactory
     * @inject
     */
    public $pageControlFactory;

    /**
     * @var LoggerInterface
     * @inject
     */
    public $monologLogger;    

    /**
     * @return PageControl
     */
    public function createComponentPageControl(): PageControl
    {
        $control = $this->pageControlFactory->create();
         
        $control->setLogger($this->monologLogger);
        
        return $control;
    }
```
