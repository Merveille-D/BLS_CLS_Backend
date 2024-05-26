@extends('pdf.layout')
@section('content')
<div class="container">
    <div class="header">
        <div class="left">
            <h1>Liste de présence</h1>
            <p class="subtitle bold">CONSEIL DE DIRECTION</p>
            <p class="subtitle italic underline">AG-01</p>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="Logo">
        </div>
    </div>

    <h2>Actionnaires</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nom & Prénoms</th>
                <th>Qualité</th>
                <th>Poste</th>
                <th>Emargement</th>
                <th>Observation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($directors as $director)
                <tr>
                    <td height="50px" >{{ $director->name }}</td>
                    <td>{{ $director->quality  }}</td>
                    <td>{{ $director->poste  }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer" id="footer">
        <span class="pagenum"></span>
    </div>
</div>
@endsection
