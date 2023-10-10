<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SkillsFilter extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $types,
        public $groups,
        public $fields,
        public $years,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.skills-filter');
    }
}
