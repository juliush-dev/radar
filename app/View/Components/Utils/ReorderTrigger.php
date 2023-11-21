<?php

namespace App\View\Components\Utils;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReorderTrigger extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public String $showCancel,
        public String $onCancel,
        public String $showReference,
        public String $onReference,
        public String $position,
        public String $showReorderPosition,
        public String $onReorderBefore,
        public String $onReorderAfter,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.utils.reorder-trigger');
    }
}
