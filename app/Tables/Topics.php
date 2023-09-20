<?php

namespace App\Tables;

use App\Models\Skill;
use App\Models\Topic;
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
    public function __construct(private RadarQuery $cq)
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
        return Topic::all();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
    }
}
