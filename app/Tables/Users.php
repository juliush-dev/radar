<?php

namespace App\Tables;

use App\Models\User;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class Users extends AbstractTable
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
        return User::query();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table->defaultColumnCanBeHidden(false);
        $table
            ->selectFilter('id', User::all()->pluck('name', 'id')->all(), 'User')
            ->selectFilter('blocked', [true => 'Blocked', false => 'Granted'], 'access')
            ->column('name')
            ->column('email')
            ->column('blocked')
            ->column('created_at', canBeHidden: true)
            ->column('email_verified_at', canBeHidden: true)
            ->column('action')
            ->paginate(15);
    }
}
