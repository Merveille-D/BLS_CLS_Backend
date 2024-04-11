<?php
namespace App\Repositories\Watch;

use App\Http\Resources\Watch\LegalWatchResource;
use App\Models\Watch\LegalWatch;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
                ->when(!blank($type), function($qry) use($type) {
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

        return new LegalWatchResource($legal_watch);
    }
}
