<?php

namespace App\Tables;

use App\Enums\ModificationRequestState;
use App\Enums\ModificationType;
use App\Enums\Visibility;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        $publicCondition =
            function ($query) {
                $query->where('visibility', Visibility::Public->value)
                    ->whereHas(
                        'modificationRequests',
                        function (Builder $query) {
                            $query->latest('created_at')->whereIn(
                                'modification_type',
                                [
                                    ModificationType::Update->value,
                                    ModificationType::Create->value,
                                ]
                            )->where(
                                function ($query) {
                                    $query->where(
                                        'modification_request_state',
                                        ModificationRequestState::Approved->value
                                    );
                                    if (Auth::check()) {
                                        $query->orWhere(
                                            function ($query) {
                                                $query->where(
                                                    'modification_request_state',
                                                    ModificationRequestState::Pending->value
                                                )->where('contributor_id', Auth::user()->id);
                                            }
                                        );
                                    }
                                }
                            );
                        }
                    );
            };

        $publicTopics = Topic::whereHas(
            'contribution',
            $publicCondition,
        )->get();
        return $publicTopics;
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
            ->withGlobalSearch(columns: ['id'])
            ->column('id', sortable: true);

        // ->searchInput()
        // ->selectFilter()
        // ->withGlobalSearch()

        // ->bulkAction()
        // ->export()
    }
}
