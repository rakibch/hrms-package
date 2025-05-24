<?php

namespace Softzino\StHrmsCore;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Softzino\StHrmsCore\Commands\StHrmsCoreCommand;

class StHrmsCoreServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('st-hrms-core')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(StHrmsCoreCommand::class);
    }
}
