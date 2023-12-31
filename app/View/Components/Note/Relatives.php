<?php

namespace App\View\Components\Note;

use App\Models\Category;
use App\Models\Note;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Relatives extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?Category $category = null,
        public Note $note
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.note.relatives');
    }
}
