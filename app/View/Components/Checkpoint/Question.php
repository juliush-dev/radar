<?php

namespace App\View\Components\Checkpoint;

use App\Models\CheckpointQuestionAnswerSet;
use App\Models\UserCheckpointSession;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Question extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?UserCheckpointSession $session = null,
        public ?array $question = null,
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
        return view('components.checkpoint.question');
    }
}
