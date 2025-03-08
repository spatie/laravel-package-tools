<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasLivewire
{
    private static string $livewireComponentsDefaultPath = '/Livewire';
    private static string $livewireViewsDefaultPath = '../resources/views/livewire';

    public array $livewirePaths = [];

    public function hasLivewire(
        ?string $namespace = null,
        ?string $livewireViewsPath = null,
        ?string $livewireComponentsPath = null
    ): self {
        $namespace = $namespace ?? $this->shortName();
        $this->verifyUniqueKey(__FUNCTION__, 'namespace', $this->inertiaComponentsPaths, $namespace);

        $this->livewirePaths[$namespace] = [
            $this->verifyRelativeDir($livewireViewsPath ?? static::livewireViewsDefaultPath),
            $this->verifyRelativeDirOrNull($livewireComponentsPath ?? static::livewireComponentsDefaultPath),
        ];

        return $this;
    }
}
