<?php

namespace App\Http\Controllers;

use App\Http\Requests\Litter\StoreLitterRequest;
use App\Http\Requests\Litter\UpdateLitterRequest;
use App\Models\Litter;
use Illuminate\Http\JsonResponse;

class LitterController extends Controller
{
    /**
     * Returns all litter.
     */
    public function index(): JsonResponse
    {
        $litter = Litter::all();

        return $this->successResponse($litter);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLitterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $image = $request->file('image');
        $imagePath = $image->store('litter', 'public');
        $data['image_path'] = $imagePath;

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

    public function markLitterAsCleaned(Litter $litter): JsonResponse
    {
        $updated = $litter->update([
            'is_cleaned' => true
        ]);

        if ($updated) {
            $litter->load('user', 'trashTypes');

            return $this->successResponse($litter);
        }

        return $this->errorResponse();
    }
}
