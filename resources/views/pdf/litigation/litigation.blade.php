@extends('pdf.layout')
@section('content')
<div class="container">
    <div class="header">
        <div class="left">
            <h1>Fiche de suivi</h1>
            <p class="subtitle bold">{{ $litigation->name }}</p>
            <p class="subtitle italic underline">{{ $litigation->reference }}</p>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="Logo">
        </div>
    </div>

    <h2>Détail du dossier</h2>
    <table class="data-table">
        {{-- <thead>
            <tr>
                <th>Désignation</th>
                <th>Valeur</th>
            </tr>
        </thead> --}}
        <tbody>
            @foreach ($details as $key => $item)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $item }}</td>
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
