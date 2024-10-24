<?php

namespace App\Repositories\Contract;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Concerns\Traits\Transfer\AddTransferTrait;
use App\Models\Contract\Contract;
use App\Models\Contract\ContractDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContractRepository
{
    use AddTransferTrait;
    use GeneratePdfTrait;

    public function __construct(private Contract $contract) {}

    /**
     * @param  Request  $request
     * @return Contract
     */
    public function store($request)
    {

        $request = $request->all();
        $request['created_by'] = Auth::user()->id;

        $reference = 'CNT-' . '-' . now()->format('d') . '/' . now()->format('m') . '/' . now()->format('Y');
        $request['contract_reference'] = $reference;

        $request['reference'] = generateReference('CONTRACT', $this->contract);

        $contract = $this->contract->create($request);

        $first_part = $request['first_part'];
        $second_part = $request['second_part'];

        $first_part = array_map(function ($part) {
            return [
                'description' => $part['description'],
                'type' => 'part_1',
                'part_id' => $part['part_id'],
            ];
        }, $first_part);

        $second_part = array_map(function ($part) {
            return [
                'description' => $part['description'],
                'type' => 'part_2',
                'part_id' => $part['part_id'],
            ];
        }, $second_part);

        $contract->contractParts()->createMany(array_merge($first_part, $second_part));

        foreach ($request['contract_documents'] as $item) {

            $fileUpload = new ContractDocument;

            $fileUpload->name = $item['name'];
            $fileUpload->file = uploadFile($item['file'], 'contract_documents');

            $contract->fileUploads()->save($fileUpload);
        }

        return $contract;
    }

    /**
     * @param  Request  $request
     * @return Contract
     */
    public function update(Contract $contract, $request)
    {

        if (isset($request['contract_documents'])) {

            $contract->fileUploads()->delete();

            foreach ($request['contract_documents'] as $item) {

                $fileUpload = new ContractDocument;

                $fileUpload->name = $item['name'];
                $fileUpload->file = uploadFile($item['file'], 'contract_documents');

                $contract->fileUploads()->save($fileUpload);
            }
        }

        if (isset($request['first_part']) && isset($request['second_part'])) {

            $contract->contractParts()->delete();

            $first_part = $request['first_part'];
            $second_part = $request['second_part'];

            $first_part = array_map(function ($part) {
                return [
                    'description' => $part['description'],
                    'type' => 'part_1',
                    'part_id' => $part['part_id'],
                ];
            }, $first_part);

            $second_part = array_map(function ($part) {
                return [
                    'description' => $part['description'],
                    'type' => 'part_2',
                    'part_id' => $part['part_id'],
                ];
            }, $second_part);

            $contract->contractParts()->createMany(array_merge($first_part, $second_part));
        }

        $contract->update($request);

        if (isset($request['forward_title'])) {

            $last_transfer = $contract->transfers()->orderby('created_at', 'desc')->first();
            if ($last_transfer->sender_id === Auth::user()->id) {
                if (($last_transfer->status == true) && isset($request['forward_title'])) {
                    $this->add_transfer($contract, $request['forward_title'], $request['deadline_transfer'], $request['description'], $request['collaborators']);
                }
            }
        }

        return $contract;
    }

    public function generatePdf($request)
    {

        $contract = Contract::find($request['contract_id']);

        $data = $contract->toArray();
        $data['first_part'] = $contract->first_part;
        $data['second_part'] = $contract->second_part;
        $data['creator'] = $contract->creator;
        $data['category'] = $contract->contractCategory->value;
        $data['type_category'] = $contract->contractTypeCategory->value;
        $data['tasks'] = $contract->tasks;

        $filename = Str::slug($contract->title) . '_' . date('YmdHis') . '.pdf';

        $pdf = $this->generateFromView('pdf.contract.fiche_de_suivi', [
            'data' => $data,
            'details' => $this->getDetails($data),
        ], $filename);

        return $pdf;
    }

    public function getDetails($data)
    {
        $details = [
            'N° de dossier' => $data['contract_reference'],
            'Statut actuel' => $data['status'],
            'Intitulé' => $data['title'],
            'Catégorie' => $data['category'],
            'Type de catégorie' => $data['type_category'],
            'Date de signature' => $data['date_signature'],
            'Date de prise d\'effet' => $data['date_effective'],
            'Date d\'expiration' => $data['date_expiration'],
            'Date de renouvellement' => $data['date_renewal'],
            'Créé par' => $data['creator']['firstname'] . '' . $data['creator']['lastname'],
        ];

        return $details;
    }
}
