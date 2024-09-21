<?php
namespace App\Repositories\Litigation;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use Illuminate\Support\Str;
use App\Http\Resources\Litigation\LitigationResource;
use App\Http\Resources\Litigation\LitigationSettingResource;
use App\Models\Litigation\Litigation;
use App\Models\Litigation\LitigationDocument;
use App\Models\Litigation\LitigationLawyer;
use App\Models\Litigation\LitigationParty;
use App\Models\Litigation\LitigationSetting;
use App\Models\Litigation\LitigationStep;
use App\Models\Litigation\LitigationTask;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LitigationRepository {
    use GeneratePdfTrait;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private LitigationSetting $setting_model,
        private Litigation $litigation_model,
    ) {}

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
                ->when($request->type == 'provisioned', function($qry) {
                    $qry->whereNotNull('added_amount')
                    ->where('has_provisions', false);
                })
                ->when($request->type == 'not_provisioned', function($qry) {
                    $qry->whereNull('added_amount')
                        ->where('has_provisions', true);
                })
                ->orderByDesc('created_at')
                ->paginate();


        return LitigationResource::collection($query);
    }

    /**
     * provisions stats
     */
    public function provisionStats() {
        // $total = $this->litigation_model->count();
        // $provisioned = $this->litigation_model->whereNotNull('added_amount')->count();
        // $not_provisioned = $this->litigation_model->whereNull('added_amount')->count();
        //sum amounts
        $query =DB::select("
            SELECT
                SUM(estimated_amount) AS sum_estimated_amount,
                (
                    SELECT SUM(CAST(JSON_UNQUOTE(JSON_EXTRACT(added_amount, CONCAT('$[', numbers.n, '].amount'))) AS DECIMAL(10,2)))
                    FROM litigations,
                    (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) numbers
                    WHERE JSON_UNQUOTE(JSON_EXTRACT(added_amount, CONCAT('$[', numbers.n, ']'))) IS NOT NULL
                ) AS sum_added_amount,
                SUM(remaining_amount) AS sum_remaining_amount
            FROM litigations;
        ");

        return [
            // 'total' => $total,
            // 'provisioned' => $provisioned,
            // 'not_provisioned' => $not_provisioned,
            'sum_estimated_amount' => (double) $query[0]->sum_estimated_amount,
            'sum_added_amount' => (double) $query[0]->sum_added_amount,
            'sum_remaining_amount' => (double) $query[0]->sum_remaining_amount,
        ];
    }

    public function add($request) : JsonResource {
        $files = $request->documents;

        $litigation = $this->litigation_model->create([
            'name' => $request->name,
            'reference' => generateReference('CT', $this->litigation_model),
            'case_number' => $request->case_number,
            'nature_id' => $request->nature_id,
            'jurisdiction_id' => $request->jurisdiction_id,
            'jurisdiction_location' => $request->jurisdiction_location,
            'email' => $request->email,
            'phone' => $request->phone,
            'created_by' => auth()->id(),
            'has_provisions' => $request->has_provisions,
        ]);
        foreach ($request->parties as $key => $party) {
            $party_model = LitigationParty::findOrFail($party['party_id']);
            $party_type = $this->setting_model->find($party['type_id']);
            $party_model->litigations()->attach($litigation, ['category' => $party['category'], 'type' => $party_type?->name]);
        }

        $this->saveDocuments($files, $litigation);

        $this->saveTasks($litigation);
        $this->updateTaskState($litigation);

        return new LitigationResource($litigation);
    }

    public function saveTasks($litigation) {
        $steps = LitigationStep::all();

        foreach ($steps as $key => $step) {
            $task = new LitigationTask();
            $task->code = $step->code;
            $task->title = $step->title;
            $task->rank = $step->rank;
            $task->type = $step->type;
            $task->max_deadline = $step->code == 'created' ? now() : null;
            $task->created_by = auth()->id();

            $task->taskable()->associate($litigation);
            $task->save();
        }

    }

    public function edit($id, $request) : JsonResource {
        $litigation = $this->litigation_model->findOrFail($id);

        $litigation->update([
            'name' => $request->name,
            'case_number' => $request->case_number,
            'nature_id' => $request->nature_id,
            'jurisdiction_id' => $request->jurisdiction_id,
            'jurisdiction_location' => $request->jurisdiction_location,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        foreach ($request->parties as $key => $party) {
            $party_model = LitigationParty::findOrFail($party['party_id']);
            $party_type = $this->setting_model->find($party['type_id']);
            $party_model->litigations()->sync($litigation, ['category' => $party['category'], 'type' => $party_type?->name]);
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
            $user->litigations()->sync($litigation);
        }
        // save assigned lawyers
        if ($request->lawyers && count($request->lawyers) > 0 ){
            foreach ($request->lawyers as $key => $lawyer_id) {
                LitigationLawyer::find($lawyer_id)->litigations()->sync($litigation);
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
     * @param  Request $request
     * @return ResourceCollection
     */
    public function getResources($request) : ResourceCollection {
        $res = $this->setting_model->whereType($request->type)->get();

        return LitigationSettingResource::collection($res);
    }

    /**
     * add new nature/jurisdiction
     *
     * @param  mixed $request
     * @param  mixed $type
     * @return void
     */
    public function addResource($request) : JsonResource {
        $resource = $this->setting_model->create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'default' => false,
            'created_by' => auth()->id(),
        ]);

        return new LitigationSettingResource($resource);
    }

    public function updateTaskState($litigation) {
        $currentTask = $litigation->next_task;

        if ($currentTask) {
            $currentTask->status = true;
            if ($currentTask->completed_at == null)
                $currentTask->completed_at = Carbon::now();
            $currentTask->save();
        }

        $nextTask = $litigation->next_task;
        if ($nextTask) {
            $data = $this->setDeadline($litigation);

            if ($data == [])
                return false;

            $nextTask->update($data);
        }
    }

    public function setDeadline($guarantee) {
        $nextTask = $guarantee->next_task;
        $defaultTask = LitigationStep::where('code', $nextTask->code)->first();

        $minDelay = $defaultTask->min_delay;
        $maxDelay = $defaultTask->max_delay;
        // dd($minDelay, $maxDelay);
        $data = array();
        //date by hypothec state
        // $operationDate = $this->getOperationDateByState($guarantee);
        $operationDate = $guarantee->current_task->completed_at ?? null;
        if ($operationDate == null)
            return $data;

        $operationDate = substr($operationDate, 0, 10);
        $formatted_date = Carbon::createFromFormat('Y-m-d', $operationDate);

        if ($minDelay && $maxDelay) {
            $data['min_deadline'] = $formatted_date->copy()->addDays($minDelay);
            $data['max_deadline'] = $formatted_date->copy()->addDays($maxDelay);
            return $data;
        }elseif ($minDelay) {
            $data['min_deadline'] = $formatted_date->addDays($minDelay);
            return $data;
        }elseif ($maxDelay) {
            $data['max_deadline'] = $formatted_date->addDays($maxDelay);
            return $data;
        }
        return $data;
    }

    public function saveDocuments($files, $litigation) {
        if (count($files)<=0)
            return false;

        foreach ($files as $key => $file) {

            $file_path = storeFile($file['file'], 'litigation');

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

    public function generatePdf($id) {
        $litigation = $this->findById($id);

        $filename = Str::slug($litigation->name). '_'.date('YmdHis') . '.pdf';

        $pdf =  $this->generateFromView( 'pdf.litigation.litigation',  [
            'litigation' => $litigation,
            'details' => $this->getDetails($litigation)
        ],
        $filename);

        return $pdf;
    }

    public function getDetails($litigation) {
        $details = [
            'N° de dossier' => $litigation->case_number ?? null,
            'Intitulé' => $litigation->name ?? null,
            'Matière' => $litigation->nature?->name,
            'Juridiction' => $litigation->jurisdiction?->name,
            'Lieu de la juridiction' => $litigation->jurisdiction_location ?? null,
            'Provisions à constituer' => (double) $litigation->estimated_amount,
            'Provisions constituées' => collect($litigation->added_amount)->sum('amount'),
            'Provisions reprises' => (double) $litigation->remaining_amount,
        ];

        return $details;
    }
}
