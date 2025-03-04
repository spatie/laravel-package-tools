<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use function Illuminate\Events\queueable;
use Illuminate\Support\Facades\Event;

trait ProcessEvents
{
    /**
     * The subscriber classes to register.
     * https://laravel.com/docs/events#registering-event-subscribers
     **/
    protected $subscribe = [];

    protected function bootPackageEvents(): self
    {
        return $this
            ->bootPackageEventsByClass()
            ->bootPackageEventsByName()
            ->bootPackageEventsAnonymous()
            ->bootPackageEventsQueueable()
            ->bootPackageEventsWildcardsByClass()
            ->bootPackageEventsWildcardsAnonymous()
            ->bootPackageEventsSubscribers();
    }

    protected function bootPackageEventsByClass(): self
    {
        return $this->listenByName($this->package->eventListenersByClass);
    }

    protected function bootPackageEventsByName(): self
    {
        return $this->listenByName($this->package->eventListenersByName);
    }

    protected function bootPackageEventsAnonymous(): self
    {
        return $this->listenByName($this->package->eventListenersAnonymous);
    }

    protected function bootPackageEventsWildcardsByClass(): self
    {
        return $this->listenByName($this->package->eventListenersWildcardsByClass);
    }

    protected function bootPackageEventsWildcardsAnonymous(): self
    {
        return $this->listenByName($this->package->eventListenersWildcardsAnonymous);
    }

    protected function listenByName(array $listeners): self
    {
        if (empty($listeners)) {
            return $this;
        }

        foreach ($listeners as $listener) {
            Event::listen(...(array) $listener);
        }

        return $this;
    }

    protected function bootPackageEventsQueueable(): self
    {
        if (empty($this->package->eventListenersQueueable)) {
            return $this;
        }

        foreach ($this->package->eventListenersQueueable as $listener) {
            Event::listen(queueable($listener));
        }

        return $this;
    }

    protected function bootPackageEventsSubscribers(): self
    {
        if (empty($this->package->eventSubscribers)) {
            return $this;
        }

        foreach ($this->package->eventSubscribers as $subscriber) {
            Event::subscribe($subscriber);
        }

        return $this;
    }
}
