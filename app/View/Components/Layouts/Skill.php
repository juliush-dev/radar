<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Skill extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public \App\Models\Skill $skill, public bool $expanded = false)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.skill');
    }
}
