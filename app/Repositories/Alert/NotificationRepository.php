<?php

namespace App\Repositories\Alert;

use App\Http\Resources\Alert\NotificationResource;
use App\Models\Alert\Alert;
use App\Models\Alert\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationRepository
{
    public function __construct(private Alert $alert, private Notification $notification) {}

    public function getList($request) : ResourceCollection {
        $search = $request->search;
        $user_id = $request->user_id ?? User::first()->id;
        $query = $this->notification
                ->when(!blank($search), function($qry) use($search) {
                    $qry->where('title', 'like', '%'.$search.'%');
                })
                ->wherenotifiableId($user_id)
                ->paginate();

        return NotificationResource::collection($query);
    }

    public function findById($id) : JsonResource {
        return new NotificationResource($this->notification->findOrfail($id));
    }

    public function markAsRead($id) : JsonResource {
        $notification = $this->notification->findOrfail($id);
        $notification->update(['read_at' => now()]);
        return new NotificationResource($notification);
    }
}
