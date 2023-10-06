<?php

namespace App\View\Components\Forms;

use App\Services\RadarQuery;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Topic extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?RadarQuery $rq)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.topic');
    }
}
