<?php

namespace App\View\Components\Checkpoint;

use App\Models\CheckpointKnowledge;
use App\Models\UserCheckpointSession;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Knowledge extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?UserCheckpointSession $session = null,
        public ?array $knowledge = null,
        public ?int $index = null,
        public String $context = 'preview',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkpoint.knowledge');
    }
}
