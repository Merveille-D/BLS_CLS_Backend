<?php

namespace App\Models\Shareholder;

use App\Concerns\Traits\Alert\Alertable;
use App\Concerns\Traits\Transfer\Transferable;
use App\Models\Scopes\CountryScope;
use App\Models\User;
// use App\Observers\TaskIncidentObserver;
// use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CountryScope::class])]
// #[ObservedBy([TaskIncidentObserver::class])]
class TaskActionTransfer extends Model
{
    use HasFactory, HasUuids, Alertable, Transferable;

    /**
     * Les attributs qui doivent être castés vers des types natifs.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    protected $fillable = [
        'title',
        'deadline',
        'code',
        'created_by',
        'action_transfer_id',
        'status',
        'date',
        'completed_by',
    ];

    const TASKS = [
        'atd_1' => [
            'title' => 'Demande d\'agrément au CA',
            'rules' => [
                'date' => ['required', 'date'],
                'documents' => ['required', 'array'],
                'documents.*.name' => ['required', 'string'],
                'documents.*.file' => ['required', 'file']
            ],
            "delay" => 10,
            "form" => [
                'fields' => [
                    [
                        'type' => 'date',
                        'name' => 'date',
                        'label' => 'Date de blocage',
                    ],
                    [
                        'type' => 'documents',
                        'name' => 'documents',
                        'label' => 'Joindre le courrier d\'information au client',
                    ],

                ],
                'form_title' => 'Information de demande d\'agrément au CA'
            ],
        ],
        'atd_2' => [
            'title' => 'Demande d\'agrément au CA',
            'rules' => [
                'date' => ['required', 'date'],
                'documents' => ['required', 'array'],
                'documents.*.name' => ['required', 'string'],
                'documents.*.file' => ['required', 'file'],
                'asked_agrement' => ['required', 'in:yes,no'],
            ],
            "delay" => 10,
            "form" => [
                'fields' => [
                    [
                        'type' => 'date',
                        'name' => 'date',
                        'label' => 'Date de blocage',
                    ],
                    [
                        'type' => 'documents',
                        'name' => 'documents',
                        'label' => 'Joindre le courrier d\'information au client',
                    ],
                    [
                        'type' => 'radio',
                        'name' => 'asked_agrement',
                        'label' => 'Avez vous reçu de Main levée ?',
                    ],
                    [
                        'type' => 'documents',
                        'name' => 'documents',
                        'label' => 'Joindre le courrier de main levée',
                    ],
                ],
                'form_title' => 'Information de demande d\'agrément au CA'
            ],
        ],

    ];

    public function fileUploads()
    {
        return $this->morphMany(ActionTransferDocument::class, 'uploadable');
    }

    public function actionTransfer()
    {
        return $this->belongsTo(ActionTransfer::class);
    }

    public function getFolderAttribute() {
        // return $this->actionTransfer->owner->name;
    }

    public function getFormAttribute() {

        $next_task = searchElementIndice(self::TASKS, $this->code);

        $form = $next_task['form'];
        return $form;
    }

    public function getValidationAttribute() {

        return [
            'method' => 'POST',
            // 'action' => env('APP_URL') . '/api/complete_task_incidents?type=' . $this->code . '&task_incident_id=' . $this->id,
            'form' => $this->form,
        ];
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

}

