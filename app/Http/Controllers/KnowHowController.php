<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKnowHowRequest;
use App\Http\Requests\UpdateKnowHowRequest;
use App\Models\KnowHow;

class KnowHowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('know-how.index', ['skills' => KnowHow::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKnowHowRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(KnowHow $knowHow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KnowHow $knowHow)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKnowHowRequest $request, KnowHow $knowHow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KnowHow $knowHow)
    {
        //
    }
}
