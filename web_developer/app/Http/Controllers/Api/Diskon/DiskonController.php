<?php

namespace App\Http\Controllers\Api\Diskon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Diskon\DiskonRequest;
use App\Http\Resources\Diskon\DiskonResource;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DiskonRequest $request)
    {
        $validated = $request->validated();

        $total = $validated['total_sebelum_diskon'];
        $discounts = $validated['discounts'];

        $totalDiskon = 0;
        $hargaSetelahDiskon = $total;

        foreach ($discounts as $diskon) {
            $diskonRp = $hargaSetelahDiskon * ($diskon['diskon'] / 100);
            $totalDiskon += $diskonRp;
            $hargaSetelahDiskon -= $diskonRp;
        }

        return new DiskonResource([
            'total_diskon' => round($totalDiskon, 2),
            'total_harga_setelah_diskon' => round($hargaSetelahDiskon, 2),
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