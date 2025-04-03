<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Illuminate\Support\Str;

trait HasServiceProviders
{
    private static string $publishableProviderDefaultPath = '../resources/stubs/';

    public array $publishableProviderNames = [];
    public array $publishableProviderPaths = [];

    public function publishesServiceProvidersByName(...$providerNames): self
    {
        if (! $providerNames) {
            $providerNames = [$this->studlyCase($this->shortName()) . 'ServiceProvider'];
        }

        $providerNames = collect($providerNames)->flatten()->toArray();

        foreach ($providerNames as $providerName) {
            $providerName =
                (Str::contains($providerName, '/') ? '' : static::$publishableProviderDefaultPath) .
                $providerName .
                (str_ends_with($providerName, '.php.stub') ? '' : '.php.stub');

            $this->publishableProviderNames[] = $this->verifyRelativeFile(__FUNCTION__, $providerName);
        }

        return $this;
    }

    public function publishesServiceProvidersByPath(?string $path = null): self
    {
        $this->publishableProviderPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$publishableProviderDefaultPath);

        return $this;
    }

    public function publishesServiceProvider(string $providerName): self
    {
        return $this->publishesServiceProvidersByName($providerName);
    }
}
