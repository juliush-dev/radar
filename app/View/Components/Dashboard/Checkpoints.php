<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkpoints extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $checkpoints)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.checkpoints');
    }
}
