<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use ProtoneMedia\Splade\AbstractTable;

class Contributions extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = '',
        public string $label = '',
        public string $actionLabel = '',
        public string $tableClass = '',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.contributions');
    }
}
