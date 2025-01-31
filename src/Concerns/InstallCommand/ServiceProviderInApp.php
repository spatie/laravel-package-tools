<?php

namespace Spatie\LaravelPackageTools\Concerns\InstallCommand;

use Illuminate\Support\Str;

trait ServiceProviderInApp
{
    protected bool $copyServiceProviderInApp = false;

    public function copyAndRegisterServiceProviderInApp(): self
    {
        $this->copyServiceProviderInApp = true;

        return $this;
    }

    protected function processServiceProviderInApp(): self
    {
        if ($this->copyServiceProviderInApp) {
            $this->comment('Publishing service provider...');

            $this->copyServiceProviderInApp();
        }

        return $this;
    }

    protected function copyServiceProviderInApp(): self
    {
        $providerNames = $this->package->publishableProviderNames;

        if (empty($providerNames)) {
            return $this;
        }

        $this->callSilent('vendor:publish', ['--tag' => $this->package->shortName() . '-provider']);

        $appPHP = intval(app()->version()) < 11 || ! file_exists(base_path('bootstrap/providers.php'));

        if ($appPHP) {
            $appConfig = file_get_contents(config_path('app.php'));
        } else {
            $appConfig = file_get_contents(base_path('bootstrap/providers.php'));
        }

        $appConfigOriginal = $appConfig;

        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        foreach ($providerNames as $providerName) {
            $class = '\\Providers\\' . Str::replace('/', '\\', $providerName) . '::class';

            if (Str::contains($appConfig, $namespace . $class)) {
                continue;
            }

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

        if ($appConfig == $appConfigOriginal) {
            return $this;
        }

        if ($appPHP) {
            file_put_contents(config_path('app.php'), $appConfig);
        } else {
            file_put_contents(base_path('bootstrap/providers.php'), $appConfig);
        }

        return $this;
    }
}
