<?php

namespace App\Tables;

use App\Models\Topic;
use App\Models\User;
use App\Services\RadarQuery;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class Topics extends AbstractTable
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
        return Topic::query();
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
            ->selectFilter('is_update', [true => 'Update', false => 'Topic'], 'type')
            ->selectFilter('subject_id', $this->rq->subjects(true)->pluck('title', 'id')->all(), 'subject')
            ->column('title', canBeHidden: false)
            ->column('subject.title', 'subject', canBeHidden: false)
            ->column('learningMaterials', 'LMs')
            ->column('author.name', 'author')
            ->column('public')
            ->column('topicToUpdate.title', 'Update of', canBeHidden: false)
            ->column('action', canBeHidden: false)
            ->paginate(15);
    }
}
