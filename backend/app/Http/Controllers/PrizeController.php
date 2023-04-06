<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrizeRequest;
use App\Http\Requests\UpdatePrizeRequest;
use App\Models\Prize;
use Illuminate\Http\JsonResponse;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $prizes = Prize::with('prizeCodes')
            ->whereHas('prizeCodes', static function ($query) {
                $query->where('is_redeemed', false);
            })->get();

        return $this->successResponse($prizes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrizeRequest $request): JsonResponse
    {
        $prize = Prize::create($request->validated());

        $prize->prizeCodes()->createMany($request->prize_codes);

        $prize->load('prizeCodes');

        return $this->successResponse($prize);
    }

    /**
     * Display the specified resource.
     */
    public function show(Prize $prize): JsonResponse
    {
        $prize->load('prizeCodes');

        return $this->successResponse($prize);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrizeRequest $request, Prize $prize): JsonResponse
    {
        $prize->update($request->validated());

        $prize->prizeCodes()->delete();
        $prize->prizeCodes()->createMany($request->prize_codes);

        $prize->load('prizeCodes');

        return $this->successResponse($prize);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prize $prize): JsonResponse
    {
        $prize->prizeCodes()->delete();
        $prize->delete();

        return $this->successResponse();
    }
}
