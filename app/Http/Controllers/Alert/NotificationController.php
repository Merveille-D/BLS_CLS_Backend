<?php

namespace App\Http\Controllers\Alert;

use App\Http\Controllers\Controller;
use App\Repositories\Alert\NotificationRepository;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        private NotificationRepository $notificationRepo
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return api_response(true, 'Liste des notifications', $data = $this->notificationRepo->getList(request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return api_response(true, 'Notification recuperée', $data = $this->notificationRepo->findById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $this->notificationRepo->markAsRead($id);

            return api_response($success = true, 'Marquée comme lue avec succès', $data);
        } catch (\Throwable $th) {
            return api_error($success = false, 'Une erreur s\'est produite lors de l\'operation', ['server' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
