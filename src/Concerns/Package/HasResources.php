<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasResources
{
    public array $resources = [];

    public function hasResource(string $resourceClassName): static
    {
        $this->resources[] = $resourceClassName;

        return $this;
    }

    public function hasResources(...$resourceClassNames): static
    {
        $this->resources = array_merge(
            $this->resources,
            collect($resourceClassNames)->flatten()->toArray()
        );

        return $this;
    }
}
