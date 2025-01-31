<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasViewComposers
{
    public array $viewComposers = [];

    public function hasViewComposer($view, $viewComposer): self
    {
        foreach (collect($view)->flatten()->toArray() as $viewName) {
            $this->viewComposers[$viewName] = $viewComposer;
        }

        return $this;
    }
}
