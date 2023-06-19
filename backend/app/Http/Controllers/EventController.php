<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\ListEventRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function index(ListEventRequest $request): JsonResponse
    {
        $user = auth('sanctum')->user();

        $query = Event::query();

        if ($user && $request->get('showJoined')) {
            $query->whereHas('joinedUsers', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } elseif ($user && !$request->get('showJoined')) {
            $query->whereDoesntHave('joinedUsers', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }


        if ($request->get('showUpcoming')) {
            $query->where('starting_at', '>', now());
        } else {
            $query->where('starting_at', '<=', now());
        }

        $events = $query->paginate($request->get('perPage', 15));

        return $this->successResponse($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $image = $request->file('image');
        if ($image) {
            $imagePath = $image->store('event', 'public');
            $data['image_path'] = $imagePath;
        }

        $event = Event::create($data);

        $event->load('user');

        return $this->successResponse($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): JsonResponse
    {
        $event->load('user', 'joinedUsers');

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
        if ($image) {
            $imagePath = $image->store('event', 'public');
            $data['image_path'] = $imagePath;
        }


        $updated = $event->update($data);

        if ($updated) {
            $event->load('user');

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
            $event->load('user');

            return $this->successResponse($event);
        }

        return $this->errorResponse();
    }

    public function joinEvent(Event $event): JsonResponse
    {
        if ($event->has_user_joined) {
            return $this->errorResponse('You have already joined this event');
        }

        $event->joinedUsers()->attach(auth()->user()->id);

        $event->load('user');

        return $this->successResponse($event);
    }
}
