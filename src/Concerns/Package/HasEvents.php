<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasEvents
{
    public array $eventListenersByClass = [];
    public array $eventListenersAnonymous = [];
    public array $eventListenersQueueable = [];

    public function hasEventListenersByClass(string $eventClass, array $listener): self
    {
        $this->verifyClassNames(__FUNCTION__, $eventClass, $listener[0]);
        $this->eventListenersByClass[] = [$eventClass, $listener];

        return $this;
    }

    public function hasEventListenersAnonymous(array $closure): self
    {
        $this->eventListenersAnonymous[] = $closure;

        return $this;
    }

    public function hasEventListenersQueueableAnonymous(array $closure): self
    {
        $this->eventListenersQueueable[] = $closure;

        return $this;
    }
}
