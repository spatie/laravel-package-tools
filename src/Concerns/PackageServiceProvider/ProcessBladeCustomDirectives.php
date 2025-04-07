<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Facades\Blade;

trait ProcessBladeCustomDirectives
{
    protected function bootPackageBladeCustomDirectives(): self
    {
        return $this
            ->bootLoadsPackageBladeDirectives()
            ->bootLoadsPackageBladeEchos()
            ->bootLoadsPackageBladeIfs();
    }

    protected function bootLoadsPackageBladeDirectives(): self
    {
        if (empty($this->package->bladeLoadsDirectives)) {
            return $this;
        }

        foreach ($this->package->bladeLoadsDirectives as $name => $callable) {
            Blade::directive($name, $callable);
        }

        return $this;
    }

    protected function bootLoadsPackageBladeEchos(): self
    {
        if (empty($this->package->bladeLoadsEchos)) {
            return $this;
        }

        foreach ($this->package->bladeLoadsEchos as $callable) {
            Blade::stringable($callable);
        }

        return $this;
    }

    protected function bootLoadsPackageBladeIfs(): self
    {
        if (empty($this->package->bladeLoadsIfs)) {
            return $this;
        }

        foreach ($this->package->bladeLoadsIfs as $name => $callable) {
            Blade::if($name, $callable);
        }

        return $this;
    }
}
