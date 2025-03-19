<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait ProcessConfigs
{
    public function registerPackageConfigs(): self
    {
        return $this
            ->registerPackageConfigsByName()
            ->registerPackageConfigsByPath();
    }

    public function registerPackageConfigsByName(): self
    {
        if (empty($this->package->configsByNameFiles)) {
            return $this;
        }

        foreach ($this->package->configsByNameFiles as $configFilename) {
            /**
             * Laravel will only load/merge config files ending in .php so we cannot load or merge config .stub files
             **/
            if (is_file($cFN = $this->package->configsByNamePath("{$configFilename}.php"))) {
                $this->mergeConfigFrom(
                    $cFN,
                    $configFilename
                );
            }
        }

        return $this;
    }

    public function registerPackageConfigsByPath(): self
    {
        if (empty($this->package->configPaths)) {
            return $this;
        }

        foreach ($this->package->configPaths as $path) {
            foreach (glob($this->package->buildDirectory($path) . '/*.php') as $file) {
                if (is_file($file)) {
                    $this->mergeConfigFrom(
                        $file,
                        basename($file, '.php')
                    );
                }
            }
        }

        return $this;
    }

    public function bootPackageConfigs(): self
    {
        return $this
            ->bootPackageConfigsByName()
            ->bootPackageConfigsByPath();
    }

    protected function bootPackageConfigsByName(): self
    {
        if (empty($this->package->configsByNameFiles) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $shortName = $this->package->shortName();
        foreach ($this->package->configsByNameFiles as $configFilename) {
            if ($cFN = $this->phpOrStub($this->package->configsByNamePath($configFilename))) {
                $this->publishes(
                    [$cFN => config_path("{$configFilename}.php")],
                    "{$shortName}-config"
                );
            } else {
                throw InvalidPackage::filenameNeitherPhpNorStub(
                    $this->package->name,
                    'Config',
                    'hasConfigsByName',
                    $configFilename
                );
            }
        }

        return $this;
    }

    protected function bootPackageConfigsByPath(): self
    {
        if (empty($this->package->configPaths) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = $this->package->shortName() . '-config';
        foreach ($this->package->configPaths as $path) {
            foreach (glob($this->package->buildDirectory($path) . '/*') as $file) {
                if (Str::endsWith($file, ['.php.stub', '.php']) && is_file($file)) {
                    $this->publishes(
                        [$file => config_path(basename(basename($file, '.php'), '.php.stub') . '.php')],
                        $tag
                    );
                }
            }
        }

        return $this;
    }
}
