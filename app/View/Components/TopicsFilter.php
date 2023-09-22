<?php

namespace App\View\Components;

use App\Services\EnumTransformer;
use App\Services\RadarQuery;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopicsFilter extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $subjects,
        public $years,
        public $fields,
        public $skills,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.topics-filter');
    }
}
