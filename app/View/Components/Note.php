<?php

namespace App\View\Components;

use App\Models\Note as ModelsNote;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use ProtoneMedia\Splade\Components\WithVue;

class Note extends Component
{
    use WithVue;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $note,
        public $editable = true,
        public $relatable = null,
        public $referencing = null,
    ) {
        //
    }

    public function getRelatable()
    {
        $this->relatable =  ModelsNote::whereNot('id', $this->note->id)
            ->where(\App\Services\RadarQuery::publicOrAuthor())
            ->get()
            ->map(fn ($note) => ['title' => $note->extractTitle(), 'id' => $this->note->id]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.note');
    }
}
