<?php

namespace App\Repositories\ManagementCommittee;

use App\Concerns\Traits\PDF\GeneratePdfTrait;
use App\Models\Gourvernance\ExecutiveCommittee;
use App\Models\Gourvernance\ExecutiveManagement\Directors\Director;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DirectorRepository
{
    use GeneratePdfTrait;

    public function __construct(private Director $director) {}

    /**
     * @param  Request  $request
     * @return Director
     */
    public function add($request)
    {

        $director = $this->director->create($request->all());

        $director->mandates()->create([
            'appointment_date' => $request['appointment_date'],
            'expiry_date' => Carbon::parse($request['appointment_date'])->addYears(5),
            'renewal_date' => Carbon::parse($request['appointment_date'])->addYears(5)->addDay(1),
        ]);

        return $director;
    }

    /**
     * @param  Request  $request
     * @return Director
     */
    public function update(Director $director, $request)
    {

        $director->update($request);

        return $director;
    }

    public function toggle($director, $request)
    {
        $existingRecord = ExecutiveCommittee::where('committee_id', $request['committee_id'])
            ->where('committable_id', $director->id)
            ->first();

        if ($existingRecord) {
            $existingRecord->delete();
        } else {

            $executive_committee = new ExecutiveCommittee;
            $executive_committee->committee_id = $request['committee_id'];
            $director->executiveCommittees()->save($executive_committee);
        }
    }

    public function renewMandate($request)
    {

        $director = Director::find($request['director_id']);

        $director->mandates()->create([
            'appointment_date' => $request['appointment_date'],
            'expiry_date' => Carbon::parse($request['appointment_date'])->addYears(5),
            'renewal_date' => Carbon::parse($request['appointment_date'])->addYears(5)->addDay(1),
        ]);

        return $director;
    }

    public function generatePdf()
    {

        $directors = Director::all();

        $filename = Str::slug('Liste des Directeurs _' . date('YmdHis') . '.pdf');

        $pdf = $this->generateFromView('pdf.management_committee.directors', [
            'directors' => $directors,
        ], $filename);

        return $pdf;
    }
}
