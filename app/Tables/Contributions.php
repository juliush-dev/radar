<?php

namespace App\Tables;

use App\Models\Contribution;
use App\Models\LearningMaterial;
use App\Models\Skill;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class Contributions extends AbstractTable
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
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Contribution::where(
            'contributor_id',
            Auth::user()->id,
        )->get();
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
            ->withGlobalSearch(columns: ['title'])
            ->column('title')
            ->column('visibility')
            ->column('contribution_type', 'Type')
            ->column('modificationRequests.modification_type', 'request')
            ->column('modificationRequests.modification_request_state', 'state')
            ->rowModal(function (Contribution $contribution) {
                $route = match ($contribution->contribution_type) {
                    Skill::class => route('skill.show', Skill::find($contribution->contribution_id)),
                    Topic::class => route('topic.show', Topic::find($contribution->contribution_id)),
                    Subject::class => route('contribution.subject.show', Subject::find($contribution->contribution_id)),
                    default => route('contribution.learning-material.show', LearningMaterial::find($contribution->contribution_id)),
                };
                return $route;
            });
    }
}
