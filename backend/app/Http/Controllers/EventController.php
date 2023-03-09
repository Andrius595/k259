<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use App\Models\Litter;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function index()
    {
        $litter = Litter::all();

        return $this->successResponse($litter);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        $data = $request->validated();

        $image = $request->file('image');
        $imagePath = $image->store('event', 'public');
        $data['image_path'] = $imagePath;

        $event = Event::create($data);

        return $this->successResponse($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): JsonResponse
    {
        return $this->successResponse($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        $data = $request->validated();
        // TODO delete old image
        $image = $request->file('image');
        $imagePath = $image->store('litter', 'public');
        $data['image_path'] = $imagePath;

        $updated = $event->update($data);

        if ($updated) {
            return $this->successResponse($event);
        }

        return $this->errorResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): JsonResponse
    {
        $deleted = $event->delete();

        if ($deleted) {
            return $this->successResponse();
        }

        return $this->errorResponse();
    }

    public function markEventAsEnded(Event $event): JsonResponse
    {
        $updated = $event->update([
            'has_ended' => true
        ]);

        if ($updated) {
            return $this->successResponse($event);
        }

        return $this->errorResponse();
    }
}
