<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasLivewire
{
    private const livewireComponentsDefaultPath = '/Livewire';

    public array $livewireComponentPaths = [];

    public function hasLivewireComponentsByPath(?string $namespace = null, ?string $path = null): self {
        $namespace ??= $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->livewireComponentsPaths, $namespace);

        $this->livewireComponentsPaths[$namespace] = $this->verifyRelativeDir($path ?? static::livewireComponentsDefaultPath);

        return $this;
    }
}
