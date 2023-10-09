<?php

namespace App\Tables;

use App\Models\LearningMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class LearningMaterials extends AbstractTable
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
        return LearningMaterial::query();
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
            ->column('title')
            ->column('topic')
            ->column('public', canBeHidden: false)
            ->column('author.name', 'Author')
            ->column('action')
            ->paginate(15);
    }
}
