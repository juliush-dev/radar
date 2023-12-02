<?php

namespace App\Tables;

use App\Models\Note;
use App\Services\RadarQuery;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class Notes extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct(private RadarQuery $rq)
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return $request->user()->is_admin;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Note::query();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->selectFilter('user_id', $this->rq->users()->pluck('name', 'id')->all(), 'author')
            ->selectFilter('is_public', [true => 'Public', false => 'Not public'], 'visibility')
            ->column('title', canBeHidden: false)
            ->column('topic.title', 'Topic')
            ->column('author.name', 'author')
            ->column('public')
            ->column('action', canBeHidden: false)
            ->paginate(15);
    }
}
