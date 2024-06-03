@extends('pdf.layout')
@section('content')
<div class="container">

    <div class="header">
        <div class="left">
            <img src="{{ $bankLogo }}" alt="Bank Logo">
        </div>
        <div class="center" style="margin-top: 10px;">
            <h1>Fiche de suivi </h1>
            <p class="subtitle bold">{{$management_committee->libelle}}</p>
            <p class="subtitle italic underline">{{ $management_committee->session_reference }}</p>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="BLS Logo">
        </div>
    </div>

    <h2>Détails du dossier</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Date de tenue</th>
                <th>{{$management_committee->session_date}}</th>
            </tr>
            <tr>
                <th>Libellé</th>
                <th>{{($management_committee->status == "pending") ? "En cours" : "Terminé"}}</th>
            </tr>
        </thead>
    </table>

    <h2>Planification</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr  class="{{ $task->status ?: 'gray italic'}}">
                    <td>{{ $task->libelle }}</td>
                    <td>{{ $task->deadline }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <div class="footer" id="footer">
        <span class="pagenum"></span>
    </div>
</div>
@endsection
