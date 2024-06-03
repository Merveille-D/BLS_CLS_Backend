@extends('pdf.layout')
@section('content')
<div class="container">
    <div class="header">
        <div class="left">
            <h1>{{$title}}</h1>
            <p class="subtitle bold">{{$management_committee->libelle}}</p>
            <p class="subtitle italic underline">{{ $management_committee->session_reference }}</p>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="Logo">
        </div>
    </div>

    <h2>Planification</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Réalisation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td height="50px" >{{ $task->libelle }}</td>
                    <td>{{ $task->status ? 'Fait' : 'Non Fait'  }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer" id="footer">
        <span class="pagenum"></span>
    </div>
</div>
@endsection
