<?php

namespace App\Http\Controllers;

use App\Models\ManagementTrainee;
use Illuminate\Http\Request;

class MtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managementTrainees = ManagementTrainee::all();
        return view('mt.index', compact('managementTrainees'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ManagementTrainee $managementTrainee)
    {
        return view('mt.show', compact('managementTrainee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManagementTrainee $managementTrainee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ManagementTrainee $managementTrainee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManagementTrainee $managementTrainee)
    {
        //
    }
}
