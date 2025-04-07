<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasBladeCustomDirectives
{
    public array $bladeLoadsDirectives = [];
    public array $bladeLoadsEchos = [];
    public array $bladeLoadsIfs = [];

    public function loadsBladeCustomDirective(string $name, callable $callable): self
    {
        $this->verifyUniqueKey(__FUNCTION__, 'custom directive', $this->bladeLoadsDirectives, $name);
        $this->bladeLoadsDirectives[$name] = $callable;

        return $this;
    }

    public function loadsBladeCustomEchoHandler(callable $callable): self
    {
        $this->bladeLoadsEchos[] = $callable;

        return $this;
    }

    public function loadsBladeCustomIf(string $name, callable $callable): self
    {
        $this->verifyUniqueKey(__FUNCTION__, 'custom If', $this->bladeLoadsIfs, $name);
        $this->bladeLoadsIfs[$name] = $callable;

        return $this;
    }
}
