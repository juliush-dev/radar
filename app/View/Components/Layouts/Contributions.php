<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Contributions extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = '',
        public string $label = '',
        public string $actionIcon = '',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.contributions');
    }
}
