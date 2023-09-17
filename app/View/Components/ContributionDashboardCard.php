<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContributionDashboardCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = '',
        public string $label = '',
        public string $iconPath = '',
        public int $total = 0,
        public int $published = 0,
        public int $approved = 0,
        public int $pending = 0,
        public int $rejected = 0,
        public bool $hideAction = false,

    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.contribution-dashboard-card');
    }
}
