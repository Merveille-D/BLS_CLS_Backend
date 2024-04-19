<?php
namespace App\Repositories\Litigation;

use Illuminate\Support\Str;
use App\Http\Resources\Litigation\LitigationResource;
use App\Http\Resources\Litigation\LitigationSettingResource;
use App\Models\Litigation\Litigation;
use App\Models\Litigation\LitigationDocument;
use App\Models\Litigation\LitigationLawyer;
use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LitigationRepository {
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private LitigationSetting $setting_model,
        private Litigation $litigation_model,
    ) {
    }

    /**
     * getByIdWithDocuments
     *
     * @param  mixed $id
     * @return JsonResource
     */
    public function findById($id) : JsonResource {
        $litigation = $this->litigation_model->findOrFail($id);

        return new LitigationResource($litigation);
    }
    public function getByIdWithDocuments($id) : JsonResource {
        $litigation = $this->litigation_model->with('documents')->findOrFail($id);

        return new LitigationResource($litigation);
    }

    public function getList($request) : ResourceCollection {
        $search = $request->search;
        $is_archived = $request->is_archived;
        $query = $this->litigation_model
                ->when(!blank($search), function($qry) use($search) {
                    $qry->where('name', 'like', '%'.$search.'%');
                })
                ->when(!blank($is_archived), function($qry) use($is_archived) {
                    $archive = $is_archived == 'yes' ? true : false;
                    $qry->where('is_archived', $archive);
                })
                ->paginate();


        return LitigationResource::collection($query);
    }

    public function add($request) : JsonResource {
        $files = $request->documents;

        $litigation = $this->litigation_model->create([
            'name' => $request->name,
            'reference' => $request->reference,
            'nature_id' => $request->nature_id,
            'jurisdiction_id' => $request->jurisdiction_id,
            'jurisdiction_location' => $request->jurisdiction_location,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        foreach ($request->parties as $key => $party) {
            $party = LitigationParty::find($party['party_id']);
            $party->litigations()->attach($litigation, ['category' => $party['category'], 'type' => $party['type']]);
        }

        $this->saveDocuments($files, $litigation);

        return new LitigationResource($litigation);
    }

    public function edit($id, $request) : JsonResource {
        $litigation = $this->litigation_model->findOrFail($id);

        $litigation->update([
            'name' => $request->name,
            'reference' => $request->reference,
            'nature_id' => $request->nature_id,
            'jurisdiction_id' => $request->jurisdiction_id,
            'jurisdiction_location' => $request->jurisdiction_location,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        foreach ($request->parties as $key => $party) {
            $party = LitigationParty::findOrFail($party['party_id']);
            $party->litigations()->sync($litigation, ['category' => $party['category'], 'type' => $party['type']]);
        }

        if ($request->documents && count($request->documents) > 0) {
            $this->saveDocuments($request->documents, $litigation);
        }

        return new LitigationResource($litigation);
    }

    public function assign($id, $request) {
        $litigation = $this->litigation_model->findOrFail($id);
        // save assigned users
        foreach ($request->users as $key => $user_id) {
            $user = User::find($user_id);
            $user->litigations()->attach($litigation);
        }
        // save assigned lawyers
        if ($request->lawyers && count($request->lawyers) > 0 ){
            foreach ($request->lawyers as $key => $lawyer_id) {
                LitigationLawyer::find($lawyer_id)->litigations()->attach($litigation) ;
            }
        }

        return new LitigationResource($litigation);
    }

    public function updateAmount($id, $request) : JsonResource {
        $litigation = $this->findById($id);
        $litigation->update([
            'estimated_amount' => $request->estimated_amount,
            'added_amount' => $this->manageAddedAmount($request, $litigation),
            'remaining_amount' => $request->remaining_amount,
        ]);

        return new LitigationResource($litigation);
    }

    public function manageAddedAmount($request, $litigation) {
        $existingAddedAmount = $litigation->added_amount ?? [];
        $existingAddedAmount[] = ['amount' => $request->added_amount, 'date' => now()];

        return $existingAddedAmount;
    }

    public function archive($id) : JsonResource {
        $litigation = $this->findById($id);
        $litigation->update([
            'is_archived' => !$litigation->is_archived,
        ]);

        return new LitigationResource($litigation);
    }

    /**
     * getResources
     *
     * @param  mixed $type
     * @return ResourceCollection
     */
    public function getResources($type) : ResourceCollection {
        $query = $this->queryByType($type);


        return LitigationSettingResource::collection($query);
    }

    /**
     * queryByType
     *
     * @return Returntype
     */
    public function queryByType($type) {
        return $this->setting_model->whereType($type)->paginate();
    }

    /**
     * add new nature/jurisdiction
     *
     * @param  mixed $request
     * @param  mixed $type
     * @return void
     */
    public function addResource($request, $type) : JsonResource {
        $resource = $this->setting_model->create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $type,
        ]);

        return new LitigationSettingResource($resource);
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
