<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavigationLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $resource = '',
        public string $action = '',
        public mixed $actionArgs = null,
        public string $label = '',
        public string $icon = '',
        public string $openAs = '',
        public string $type = '',
        public bool $post = false
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.navigation-link');
    }
}
