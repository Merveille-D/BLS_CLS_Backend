@extends('pdf.layout')
@section('content')
<div class="container">
    <x-pdf-header :data="$litigation" :bankLogo="$bankLogo" :blsLogo="$base64Image" />
    <h2>Détail du dossier</h2>
    <x-pdf-details :details="$details" />

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
