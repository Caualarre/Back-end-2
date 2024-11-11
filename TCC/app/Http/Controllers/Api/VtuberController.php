<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VtuberResource;
use App\Models\Vtuber;
use Illuminate\Http\Request;
use App\Http\Resources\VtuberCollection;

class VtuberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd (Vtuber::all());
        return response()->json(Vtuber::all());

        // return new VtuberCollection(Vtuber::all());

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
    public function show(Vtuber $vtuber)
    {
        return new VtuberResource($vtuber);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vtuber $vtuber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vtuber $vtuber)
    {
        //
    }
}

