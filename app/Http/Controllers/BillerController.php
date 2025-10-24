<?php

namespace App\Http\Controllers;

use App\Models\Biller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BillerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('billers/index');
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
    public function show(Biller $biller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Biller $biller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Biller $biller)
    {
        //
    }
}
