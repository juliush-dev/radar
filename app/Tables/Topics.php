<?php

namespace App\Tables;

use App\Models\Topic;
use App\Models\User;
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
    public function __construct()
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
            ->selectFilter('user_id', User::all()->pluck('name', 'id')->all(), 'author')
            ->selectFilter('is_public', [true => 'Public', false => 'Not public'], 'visibility')
            ->selectFilter('is_update', [true => 'Update', false => 'Topic'], 'type')
            ->column('title')
            ->column('subject.title', 'subject')
            ->column('learningMaterials', 'LMs')
            ->column('author.name', 'author')
            ->column('public', canBeHidden: false)
            ->column('topicToUpdate.title', 'Update of')
            ->column('action')
            ->paginate(15);
    }
}
