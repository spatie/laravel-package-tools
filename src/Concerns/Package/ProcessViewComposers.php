<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Illuminate\Support\Facades\View;

trait ProcessViewComposers
{
    protected function bootViewComposers()
    {
        if (empty($this->package->viewComposers)) {
            return;
        }

        foreach ($this->package->viewComposers as $viewName => $viewComposer) {
            View::composer($viewName, $viewComposer);
        }
    }
}
