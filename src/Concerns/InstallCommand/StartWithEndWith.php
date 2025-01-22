<?php

namespace Spatie\LaravelPackageTools\Concerns\InstallCommand;

use Closure;

trait StartWithEndWith
{
    public ?Closure $startWith = null;
    public ?Closure $endWith = null;

    public function startWith($callable): self
    {
        $this->startWith = $callable;

        return $this;
    }

    public function endWith($callable): self
    {
        $this->endWith = $callable;

        return $this;
    }

    protected function processStartWith(): self
    {
        if ($this->startWith) {
            ($this->startWith)($this);
        }

        return $this;
    }

    protected function processEndWith(): self
    {
        if ($this->endWith) {
            ($this->endWith)($this);
        }

        return $this;
    }
}
