<?php
namespace App\Repositories\Litigation;

use Illuminate\Support\Str;
use App\Http\Resources\Litigation\LitigationResource as LitigationLitigationResource;
use App\Http\Resources\Litigation\LitigationResourceResource;
use App\Models\Litigation\Litigation;
use App\Models\Litigation\LitigationDocument;
use App\Models\Litigation\LitigationResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LitigationRepository {
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private LitigationResource $resource_model,
        private Litigation $litigation_model,
    ) {
    }


    public function getList($request) : ResourceCollection {
        $search = $request->search;
        $query = $this->litigation_model
                ->when(!blank($search), function($qry) use($search) {
                    $qry->where('name', 'like', '%'.$search.'%');
                })
                ->paginate();


        return LitigationLitigationResource::collection($query);
    }

    public function add($request) : JsonResource {
        $files = $request->documents;

        $litigation = $this->litigation_model->create([
            'name' => $request->name,
            'reference' => generateReference('LG'),
            'nature_id' => $request->nature_id,
            'party_id' => $request->party_id,
            'jurisdiction_id' => $request->jurisdiction_id,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $this->saveDocuments($files, $litigation);

        return new LitigationLitigationResource($litigation);
    }

    /**
     * getResources
     *
     * @param  mixed $type
     * @return ResourceCollection
     */
    public function getResources($type) : ResourceCollection {
        $query = $this->queryByType($type);


        return LitigationResourceResource::collection($query);
    }

    /**
     * queryByType
     *
     * @return Returntype
     */
    public function queryByType($type) {
        return $this->resource_model->whereType($type)->paginate();
    }

    /**
     * add new nature/jurisdiction
     *
     * @param  mixed $request
     * @param  mixed $type
     * @return void
     */
    public function addResource($request, $type) : JsonResource {
        $resource = $this->resource_model->create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $type,
        ]);

        return new LitigationResourceResource($resource);
    }

    public function saveDocuments($files, $litigation) {
        if (count($files)<=0)
            return false;

        foreach ($files as $key => $file) {

            $file_path = $this->storeFile($file['file']);

            $doc = new LitigationDocument();
            // $doc->state = $litigation->state;
            $doc->file_name = $file['name'];
            $doc->file_path = $file_path;

            $litigation->documents()->save($doc);
        }

        $check_files = ($litigation->documents()->whereState($litigation->state)->get());

        if ($check_files->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function storeFile($file) {
        if($file) {
            $sanitized_file_name = date('Y-m-d_His-').Str::random(6).auth()->id().'-'.sanitize_file_name($file->getClientOriginalName());
            $path = $file->storeAs('litigation', $sanitized_file_name);
            return $path;
        }
    }
}
