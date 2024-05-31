@extends('pdf.layout')
@section('content')
<div class="container">

    <div class="header">
        <div class="left">
            <img src="{{ $bankLogo }}" alt="Bank Logo">
        </div>
        <div class="center" style="margin-top: 10px;">
            <h1>Fiche de suivi </h1>
            <p class="subtitle bold">{{$general_meeting->libelle}} {{ $meeting_type }}</p>
            <p class="subtitle italic underline">{{ $general_meeting->meeting_reference }}</p>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="BLS Logo">
        </div>
    </div>

    <h2>Détail du dossier</h2>
    <table class="details-table">
        <tbody>
            @foreach ($details as $key => $item)
                <tr>
                    <td>{{ $key }}</td>
                    <td>
                        <div class="text-right">
                            {{ $item }}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Parties</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Partie</th>
                <th>Catégorie</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($litigation->parties as $key => $party)
                <tr>
                    <td>{{ $party->name }}</td>
                    <td>{{ $party->pivot->category  }}</td>
                    <td>{{ $party->pivot->type  }}</td>
                </tr>
            @endforeach

        </tbody>
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
            @foreach ($litigation->tasks as $key => $task)
                <tr  class="{{ $task->status ?: 'gray italic'}}">
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->completed_at }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <div class="footer" id="footer">
        <span class="pagenum"></span>
    </div>
</div>
@endsection
