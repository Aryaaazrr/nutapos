<?php

namespace App\Http\Controllers\Api\Revenue;

use App\Http\Controllers\Controller;
use App\Http\Requests\Revenue\RevenueRequest;
use App\Http\Resources\Revenue\RevenueResource;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RevenueRequest $request)
    {
        $validated = $request->validated();

        $hargaBeli = $validated['harga_sebelum_markup'];
        $markupPersen = $validated['markup_persen'];
        $sharePersen = $validated['share_persen'];

        $hargaJual = $hargaBeli + ($hargaBeli * $markupPersen / 100);

        $shareOjol = $hargaJual * ($sharePersen / 100);

        $netResto = $hargaJual - $shareOjol;

        return new RevenueResource([
            'net_untuk_resto' => round($netResto, 2),
            'share_untuk_ojol' => round($shareOjol, 2),
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