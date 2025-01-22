<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasProviders
{
    public ?string $publishableProviderName = null;

    public function publishesServiceProvider(string $providerName): self
    {
        $this->publishableProviderName = $providerName;

        return $this;
    }
}
