<?php

namespace App\Http\Controllers\Api\Pajak;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pajak\PajakRequest;
use App\Http\Resources\Pajak\PajakResource;
use Illuminate\Http\Request;

class PajakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PajakRequest $request)
    {
        $validated = $request->validated();

        $total = $validated['total'];
        $persen_pajak = $validated['persen_pajak'];

        $net_sales = $total / (1 + ($persen_pajak / 100));
        $pajak_rp = $total - $net_sales;

        return new PajakResource([
            'net_sales' => round($net_sales, 2),
            'pajak_rp' => round($pajak_rp, 2),
        ], 200);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}