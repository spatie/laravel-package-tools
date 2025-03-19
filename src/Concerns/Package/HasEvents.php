<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Illuminate\Support\Str;

trait HasEvents
{
    public array $eventListenersByClass = [];
    public array $eventListenersByName = [];
    public array $eventListenersAnonymous = [];
    public array $eventListenersQueueable = [];
    public array $eventListenersWildcardsAnonymous = [];
    public array $eventListenersWildcardsByClass = [];
    public array $eventSubscribers = [];

    public function hasEventListenerByClasses(string $eventClass, string $listenerClass, ?string $listenerMethod = null): self
    {
        $listener = $this->parseListenerClass(__FUNCTION__, $eventClass, $listenerClass, $listenerMethod, "handle");

        $this->eventListenersByClass[] = [$this->verifyClassNames(__FUNCTION__, $eventClass), $listener];

        return $this;
    }

    public function hasEventListenerByName(string $name, string $listenerClass, ?string $listenerMethod = null): self
    {
        $listener = $this->parseListenerClass(__FUNCTION__, $name, $listenerClass, $listenerMethod, "handle");

        $this->eventListenersByName[] = [$name, $listener];

        return $this;
    }

    public function hasEventListenerAnonymous(callable $closure): self
    {
        $this->eventListenersAnonymous[] = $closure;

        return $this;
    }

    public function hasEventListenerQueueableAnonymous(callable $closure): self
    {
        $this->eventListenersQueueable[] = $closure;

        return $this;
    }

    public function hasEventListenerWildcardAnonymous(string $wildcard, callable $closure): self
    {
        $this->eventListenersWildcardsAnonymous[] = [$wildcard, $closure];

        return $this;
    }

    public function hasEventListenerWildcardByClass(string $wildcard, string $listenerClass, ?string $listenerMethod = null): self
    {
        $listener = $this->parseListenerClass(__FUNCTION__, $wildcard, $listenerClass, $listenerMethod, "handleWildcard");

        $this->eventListenersWildcardsByClass[] = [$wildcard, $listener];

        return $this;
    }

    public function hasEventSubscribers(...$subscriberClassNames): self
    {
        $this->eventSubscribers = array_unique(array_merge(
            $this->eventSubscribers,
            $this->verifyClassNames(__FUNCTION__, collect($subscriberClassNames)->flatten()->toArray())
        ));

        return $this;
    }

    private function parseListenerClass(
        string $method,
        string $event,
        string $listenerClass,
        ?string $listenerMethod,
        string $defaultMethod
    ): array|string {
        if (Str::contains($listenerClass, '@')) {
            $listener = $listenerClass;
            $this->verifyClassNames($method, explode('@', $listenerClass, 2)[0]);
        } else {
            $this->verifyClassNames($method, $listenerClass);
            $listener = [$listenerClass, $this->verifyClassMethod($method, $listenerClass, $listenerMethod ?? $defaultMethod)];
        }

        return $listener;
    }
}
