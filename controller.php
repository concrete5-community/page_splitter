<?php

namespace Concrete\Package\PageSplitter;

use A3020\PageSplitter\Installer;
use A3020\PageSplitter\Provider;
use Concrete\Core\Package\Package;
use Concrete\Core\Support\Facade\Package as PackageFacade;

final class Controller extends Package
{
    protected $pkgHandle = 'page_splitter';
    protected $appVersionRequired = '8.4.0';
    protected $pkgVersion = '1.0.2';
    protected $pkgAutoloaderRegistries = [
        'src/PageSplitter' => '\A3020\PageSplitter',
    ];

    public function getPackageName()
    {
        return t('Page Splitter');
    }

    public function getPackageDescription()
    {
        return t('Split content in multiple pages.');
    }

    public function on_start()
    {
        /** @var Provider $provider */
        $provider = $this->app->make(Provider::class);
        $provider->register();
    }

    public function install()
    {
        $pkg = parent::install();

        $installer = $this->app->make(Installer::class);
        $installer->install($pkg);
    }

    public function upgrade()
    {
        $pkg = PackageFacade::getByHandle($this->pkgHandle);

        $installer = $this->app->make(Installer::class);
        $installer->install($pkg);
    }
}
