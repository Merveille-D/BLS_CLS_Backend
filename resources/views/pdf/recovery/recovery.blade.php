@extends('pdf.layout')
@section('content')
<div class="container">
    <div class="header">
        <div class="left">
            <h1>Fiche de suivi</h1>
            <p class="subtitle bold">{{ $model->name }}</p>
            <p class="subtitle italic underline">{{ $model->reference }}</p>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="Logo">
        </div>
    </div>

    <h2>Détail du recouvrement</h2>
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

    @if (!blank($model->tasks))
    <h2>Planification</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Libellé</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($model->tasks as $key => $task)
                <tr  class="{{ $task->status ?: 'gray italic'}}">
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->completed_at }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    @endif

    <div class="footer" id="footer">
        <span class="pagenum"></span>
    </div>
</div>
@endsection
