<?php

// packages/vendorname/setup-package/src/SetupPackageServiceProvider.php

namespace VendorName\SetupPackage;

use Illuminate\Support\ServiceProvider;
use VendorName\SetupPackage\Commands\InstallProjectCommand;

class SetupPackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallProjectCommand::class,
            ]);
        }
    }

    public function boot()
    {
        // Publier le fichier de configuration (optionnel)
        $this->publishes([
            __DIR__.'/../config/setup-package.php' => config_path('setup-package.php'),
        ], 'setup-package-config');
    }
}
