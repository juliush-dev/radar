<?php

namespace App\View\Components\Forms;

use App\Services\RadarQuery;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Skill extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?RadarQuery $rq,
        public $actionLabel = 'save',
        public $skill = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.skill');
    }
}
