<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Illuminate\Support\Str;

trait HasProviders
{
    private static string $publishableProviderDefaultPath = '../resources/stubs/';

    public array $publishableProviderNames = [];

    public function publishesServiceProvider(?string $providerName = null, string $path = null): self
    {
        $providerName =
            (Str::contains($providerName, '/') ? '' : static::$publishableProviderDefaultPath) .
            ($providerName ?? $this->studlyCase($this->shortName()) . 'ServiceProvider') . '.php.stub';

        $this->publishableProviderNames[] = $this->verifyRelativeFile(__FUNCTION__, $providerName);

        return $this;
    }
}
