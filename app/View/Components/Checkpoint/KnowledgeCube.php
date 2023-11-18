<?php

namespace App\View\Components\Checkpoint;

use App\Models\KnowledgeCube as ModelsKnowledgeCube;
use App\Models\UserCheckpointSession;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class KnowledgeCube extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ModelsKnowledgeCube $knowledgeCube,
        public ?UserCheckpointSession $session = null,
        public ?Collection $reviewKnowledge = null,
        public String $context = 'preview',
        public ?String $id = null
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkpoint.knowledge-cube');
    }
}
