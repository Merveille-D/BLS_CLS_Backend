@extends('pdf.layout')
@section('content')
<div class="container">

    <div class="header">
        <div class="left">
            <img src="{{ $bankLogo }}" alt="Bank Logo">
        </div>
        <div class="center" style="margin-top: 10px;">
            <h1>Fiche de suivi </h1>
            <p class="subtitle bold">{{$data['title']}}</p>
            <p class="subtitle italic underline">{{ $data['incident_reference'] }}</p>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="BLS Logo">
        </div>
    </div>

    <h2>Détail du dossier</h2>
    <x-pdf-details :details="$details" />

    <h2>Planification</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['tasks'] as $task)
                <tr  class="{{ $task->status ?: 'gray italic'}}">
                    <td>{{ $task->title }}</td>
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
