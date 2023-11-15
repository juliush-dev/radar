<?php

namespace App\View\Components\Checkpoint;

use App\Models\QuestionsCube as ModelsQuestionsCube;
use App\Models\UserCheckpointSession;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class QuestionsCube extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ModelsQuestionsCube $questionsCube,
        public ?UserCheckpointSession $session = null,
        public ?Collection $reviewQuestions = null,
        public String $context = 'preview'
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkpoint.questions-cube');
    }
}
