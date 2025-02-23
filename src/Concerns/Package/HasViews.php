<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasViews
{
    public bool $hasViews = false;
    protected ?string $viewNamespace = null;
    protected string $viewsPath = '/../resources/views';

    public function hasViews(?string $namespace = null): self
    {
        $this->hasViews = true;
        $this->viewNamespace = $namespace;

        $this->viewsPath = $this->verifyDirOrNull($this->viewsPath);

        return $this;
    }

    public function viewNamespace(): string
    {
        return $this->viewNamespace ?? $this->shortName();
    }

    public function viewsPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->viewsPath, $directory);
    }

    public function setViewsPath(string $path): self
    {
        $this->viewsPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }
}
