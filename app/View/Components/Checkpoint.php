<?php

namespace App\View\Components;

use App\Models\Checkpoint as ModelCheckpoint;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkpoint extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ModelCheckpoint $checkpoint)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkpoint');
    }

    static function wrapTokensInText(string $textA): string
    {
        $textA = str_replace("\r\n", "<br>", $textA);
        $regex = '/\[(.*?)\]/';
        $textB = preg_replace_callback($regex, function ($match) {
            $token = $match[1];
            $wrappedToken = '<span class="bg-violet-500 px-1 rounded text-white">' . $token . '</span>';
            return $wrappedToken;
        }, $textA);
        return $textB;
    }
}
