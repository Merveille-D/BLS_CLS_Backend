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
        $is_read = $request->is_read;
        $user_id = $request->user_id ?? User::first()->id;
        $query = $this->notification
                ->when(request('type') !== null, function($query) {
                    $query->where('type', request('type'));
                })
                ->when(!blank($search), function($qry) use($search) {
                    $qry->where('title', 'like', '%'.$search.'%');
                })
                ->when($is_read == 'true', function($qry) {
                    $qry->whereNotNull('read_at');
                })
                ->when($is_read == 'false', function($qry) {
                    $qry->whereNull('read_at');
                })
                ->wherenotifiableId($user_id)
                ->paginate();

        return NotificationResource::collection($query);
    }

    public function findById($id) : JsonResource {
        $notif = $this->notification->findOrfail($id);
        // $notif->update(['read_at' => now()]);
        return new NotificationResource($notif);
    }

    public function markAsRead($id) : JsonResource {
        $notification = $this->notification->findOrfail($id);
        $notification->update(['read_at' => now()]);
        return new NotificationResource($notification);
    }

    public function remindMeLater($id, $request) {
        $notification = $this->notification->findOrfail($id);
        $alert = $notification->alert;

        $new_alert = $alert->replicate()->fill([
            'trigger_at' => now()->addDays($request->days ? $request->days : 3),
        ]);
        $new_alert->save();
        $notification->markAsRead();

        return new NotificationResource($notification);
    }
}
