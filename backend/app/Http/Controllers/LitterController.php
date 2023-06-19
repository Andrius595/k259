<?php

namespace App\Http\Controllers;

use App\Http\Requests\Litter\CleanLitterRequest;
use App\Http\Requests\Litter\ListLitterRequest;
use App\Http\Requests\Litter\StoreLitterRequest;
use App\Http\Requests\Litter\UpdateLitterRequest;
use App\Models\Litter;
use Illuminate\Http\JsonResponse;
use Location\Coordinate;
use Location\Distance\Haversine;

class LitterController extends Controller
{
    /**
     * Returns all litter.
     */
    public function index(ListLitterRequest $request): JsonResponse
    {
        $query = Litter::where('is_cleaned', $request->get('showCleaned'));

        $user = auth('sanctum')->user();
        if ($user && $request->get('showMine')) {
            $query->where('user_id', $user->id);
        }

        $litter = $query->paginate($request->get('perPage', 15));

        return $this->successResponse($litter);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLitterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $image = $request->file('image');
        if ($image) {
            $imagePath = $image->store('litter', 'public');
            $data['image_path'] = $imagePath;
        }

        $litter = Litter::create($data);

        $litter->trashTypes()->attach($data['trash_types']);

        $litter->load('user', 'trashTypes');

        return $this->successResponse($litter);
    }

    /**
     * Display the specified resource.
     */
    public function show(Litter $litter): JsonResponse
    {
        $litter->load('user', 'trashTypes');

        return $this->successResponse($litter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLitterRequest $request, Litter $litter): JsonResponse
    {
        $data = $request->validated();
        // TODO delete old image
        $image = $request->file('image');
        if ($image) {
            $imagePath = $image->store('litter', 'public');
            $data['image_path'] = $imagePath;
        }

        if (!$litter->is_cleaned && $data['is_cleaned']) {
            $data['cleaner_id'] = auth()->user()?->id;
        }

        $litter->trashTypes()->sync($data['trash_types']);
        $updated = $litter->update($data);

        if ($updated) {
            $litter->load('user', 'trashTypes');

            return $this->successResponse($litter);
        }

        return $this->errorResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Litter $litter): JsonResponse
    {
        $deleted = $litter->delete();

        if ($deleted) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function markLitterAsCleaned(CleanLitterRequest $request, Litter $litter): JsonResponse
    {
        if ($litter->is_cleaned) {
            return $this->errorResponse('Šiuklė jau išvalyta.');
        }


        $userLocation = new Coordinate($request->latitude, $request->longitude);
        $litterLocation = new Coordinate($litter->latitude, $litter->longitude);
        $distance = $userLocation->getDistance($litterLocation, new Haversine());

        if ($distance > 500) {
            return $this->errorResponse('Negalite surinkti šiukšlių, nes esate per toli nuo jų.');
        }

        // TODO delete old image
        $image = $request->file('cleaned_image');
        $imagePath = $image->store('litter_cleaned', 'public');

        $updated = $litter->update([
            'is_cleaned' => true,
            'cleaner_id' => auth()->user()?->id,
            'cleaned_image_path' => $imagePath,
        ]);

        if ($updated) {
            $litter->load('user', 'trashTypes');

            return $this->successResponse($litter);
        }

        return $this->errorResponse();
    }
}
