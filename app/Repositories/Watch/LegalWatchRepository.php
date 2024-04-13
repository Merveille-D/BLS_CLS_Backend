<?php
namespace App\Repositories\Watch;

use App\Enums\Watch\WatchType;
use App\Http\Resources\Watch\LegalWatchResource;
use App\Mail\Watch\LegalWatchEmail;
use App\Models\Watch\LegalWatch;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LegalWatchRepository
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private LegalWatch $watch_model,
    ) {}

    /**
     * getList
     *
     * @param  mixed $request
     * @return ResourceCollection
     */
    public function getList($request) : ResourceCollection {
        $search = $request->search;
        $type = $request->type;
        $query = $this->watch_model
                ->when(!blank($type) && $type == 'mixte', function($qry) use($type) {
                    $qry->whereIn('type',  [WatchType::LEGISLATION, WatchType::REGULATION]);
                })
                ->when(!blank($type) && $type != 'mixte', function($qry) use($type) {
                    $qry->whereType($type);
                })
                ->when(!blank($search), function($qry) use($search) {
                    $qry->where('name', 'like', '%'.$search.'%');
                })
                ->paginate();


        return LegalWatchResource::collection($query);
    }
    /**
     * add
     *
     * @param  mixed $request
     * @return JsonResource
     */
    public function add($request) : JsonResource {
        $legal_watch = $this->watch_model->create($request->all());
        if ($legal_watch && !blank($legal_watch->mail_addresses) && count($legal_watch->mail_addresses) >=1) {
            $this->sendMessage($legal_watch);
        }
        return new LegalWatchResource($legal_watch);
    }

    public function sendMessage($legal_watch) {
        try {
            foreach ($legal_watch->mail_addresses as $email) {
                Mail::to($email)->send(new LegalWatchEmail($legal_watch));
            }
            $legal_watch->is_sent = true;
            $legal_watch->save();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}
