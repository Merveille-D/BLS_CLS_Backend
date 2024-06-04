<?php
namespace App\Repositories\Watch;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Enums\Watch\WatchType;
use App\Http\Resources\Watch\LegalWatchResource;
use App\Mail\Watch\LegalWatchEmail;
use App\Models\Watch\LegalWatch;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LegalWatchRepository
{
    use GeneratePdfTrait;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private LegalWatch $watch_model,
    ) {}

    /**
     * get legal watches list
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
     * add new legal watch resource
     *
     * @param  mixed $request
     * @return JsonResource
     */
    public function add($request) : JsonResource {
        $legal_watch = $this->watch_model->create(array_merge($request->all(),
                        [
                            'created_by' => auth()->id(),
                            'reference' => generateReference('VJ', $this->watch_model)
                        ]));

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

    public function generatePdf($id) {
        $legal_watch = $this->watch_model->find($id);

        $filename = Str::slug($legal_watch->name). '_'.date('YmdHis') . '.pdf';

        $pdf =  $this->generateFromView( 'pdf.legal_watch.legal_watch',  [
            'legal_watch' => $legal_watch,
            'details' => $this->getDetails($legal_watch)
        ],
        $filename);

        return $pdf;
    }

    public function getDetails($legal_watch) {
        $details = [
            'Référence' => $legal_watch->reference ?? null,
            'Intitulé' => $legal_watch->name ?? null,
            'Type' => WatchType::TYPES_VALUES[$legal_watch->type] ?? null,
        ];
        if ($legal_watch->type == WatchType::LEGAL) {
            $details['Date de l\'événement'] = $legal_watch->event_date ?? null;
            $details['Juridiction'] = $legal_watch->jurisdiction?->name ?? null;
            $details['Lieu de la juridiction'] = $legal_watch->jurisdiction_location ?? null;
        } else {
            $details['Date de prise d\'effet'] = $legal_watch->effective_date ?? null;
            $details['Matière'] = $legal_watch->nature?->name ?? null;
            $details['Référence de l\'affaire'] = $legal_watch->case_number ?? null;
        }

        return $details;
    }
}
