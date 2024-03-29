<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrizeRequest;
use App\Http\Requests\UpdatePrizeRequest;
use App\Mail\PrizeRedeemed;
use App\Models\Prize;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $prizes = Prize::whereHas('prizeCodes', static function ($query) {
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

    public function redeemPrize(Prize $prize): JsonResponse
    {
        $user = auth()->user();

        if ($prize->price > $user->points) {
            return $this->errorResponse('Jūsų turimų taškų nepakanka');
        }

        $prize->load('prizeCodes');

        $availablePrizeCodes = $prize->prizeCodes()->where('is_redeemed', false)->get();
        if ($availablePrizeCodes->isEmpty()) {
            return $this->errorResponse('Šio prizo nebeliko');
        }

        $prizeCode = $availablePrizeCodes->first();

        $updated = $prizeCode->update([
            'is_redeemed' => true,
        ]);

        if (!$updated) {
            return $this->errorResponse('Nepavyko atsiimti prizo', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $user->decrement('points', $prize->price);

        Mail::to(auth()->user())->send(new PrizeRedeemed($prize, $prizeCode));

        return $this->successResponse('Prizas išsiųstas į jūsų el. paštą');
    }
}
