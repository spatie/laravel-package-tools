<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasViewComposers
{
    public array $viewLoadsComposers = [];

    public function loadsViewComposer(string|array $view, callable|string $viewComposer): self
    {
        foreach ((array) $view as $viewName) {
            $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->viewLoadsComposers, $viewName);
            $this->viewLoadsComposers[$viewName] = $viewComposer;
        }

        return $this;
    }

    public function hasViewComposer(string|array $view, callable|string $viewComposer): self
    {
        return $this->loadsViewComposer($view, $viewComposer);
    }
}
