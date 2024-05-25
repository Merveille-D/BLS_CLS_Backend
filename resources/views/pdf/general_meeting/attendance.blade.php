@extends('pdf.layout')
@section('content')
<div class="container">
    <div class="header">
        <div class="left">
            <h1>Liste de présence</h1>
            <p class="subtitle bold">ASSEMBLÉE GÉNERALE ORDINAIRE</p>
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
                <th>Emargement</th>
                <th>Observation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shareholders as $shareholder)
                <tr>
                    <td height="50px" >{{ $shareholder->name }}</td>
                    <td>{{ $shareholder->percentage  }}</td>
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
