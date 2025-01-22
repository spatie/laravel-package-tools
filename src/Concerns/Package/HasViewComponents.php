<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasViewComponents
{
    public array $viewComponents = [];

    public function hasViewComponent(string $prefix, string $viewComponentName): self
    {
        $this->viewComponents[$viewComponentName] = $prefix;

        return $this;
    }

    public function hasViewComponents(string $prefix,  ...$viewComponentNames): self
    {
        foreach ($viewComponentNames as $componentName) {
            $this->viewComponents[$componentName] = $prefix;
        }

        return $this;
    }
}
