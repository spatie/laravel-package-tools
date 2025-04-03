<?php

namespace Spatie\LaravelPackageTools\Concerns\InstallCommand;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait InstallerServiceProviderInApp
{
    protected bool $copyServiceProviderInApp = false;

    public function registerServiceProvidersInApp(bool $copy = true): self
    {
        $this->copyServiceProviderInApp = $copy;

        return $this;
    }

    public function copyAndRegisterServiceProviderInApp(bool $copy = true): self
    {
        return $this->registerServiceProvidersInApp($copy);
    }

    protected function processServiceProviderInApp(): self
    {
        if (! $this->copyServiceProviderInApp) {
            return $this;
        }

        $this->comment('Publishing service provider...');

        $providerNames = $this->package->publishableProviderNames;

        if (empty($providerNames)) {
            throw InvalidPackage::conflictingMethods(
                $this->package->name,
                'registerServiceProvidersInApp',
                'not publishesServiceProvider'
            );
        }

        $this->callSilent('vendor:publish', ['--tag' => $this->package->shortName() . '-provider']);

        $appPHP = intval(app()->version()) < 11 || ! file_exists(base_path('bootstrap/providers.php'));

        if ($appPHP) {
            $configFile = config_path('app.php');
        } else {
            $configFile = base_path('bootstrap/providers.php');
        }
        $appConfig = file_get_contents($configFile);

        $appConfigOriginal = $appConfig;

        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        $changes = false;

        foreach ($providerNames as $providerName) {
            $providerName = basename($providerName, '.php.stub');
            $class = '\\Providers\\' . Str::replace('/', '\\', $providerName) . '::class';

            if (Str::contains($appConfig, $namespace . $class)) {
                continue;
            }

            $changes = true;

            if ($appPHP) {
                $appConfig = str_replace(
                    "{$namespace}\\Providers\\BroadcastServiceProvider::class,",
                    "{$namespace}\\Providers\\BroadcastServiceProvider::class," . PHP_EOL . "        {$namespace}{$class},",
                    $appConfig
                );
            } else {
                $appConfig = str_replace(
                    "{$namespace}\\Providers\\AppServiceProvider::class,",
                    "{$namespace}\\Providers\\AppServiceProvider::class," . PHP_EOL . "        {$namespace}{$class},",
                    $appConfig
                );
            }

            file_put_contents(app_path('Providers/' . $providerName . '.php'), str_replace(
                "namespace App\Providers;",
                "namespace {$namespace}\Providers;",
                file_get_contents(app_path('Providers/' . $providerName . '.php'))
            ));
        }

        if ($changes) {
            file_put_contents($configFile, $appConfig);
        }

        return $this;
    }
}
