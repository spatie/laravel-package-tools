<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Components;

use Illuminate\View\Component;

class PathTestComponent extends Component
{
    public $message;

    /**
     * Create the component instance.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return '<div>' . $this->message . '</div>';
    }
}
