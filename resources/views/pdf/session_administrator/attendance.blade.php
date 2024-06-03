@extends('pdf.layout')
@section('content')
<div class="container">
    <div class="header">
        <div class="left">
            <h1>Liste de présence</h1>
            <p class="subtitle bold">{{$session_administrator->libelle}} {{ $meeting_type }}</p>
            <p class="subtitle italic underline">{{ $session_administrator->session_reference }}</p>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="Logo">
        </div>
    </div>

    <h2>Administrateurs</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nom & Prénoms</th>
                <th>Qualité</th>
                <th>Nombre de parts</th>
                <th>Poste</th>
                <th>Emargement</th>
                <th>Observation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($administrators as $administrator)
                <tr>
                    <td height="50px" >{{ $administrator->name }}</td>
                    <td>{{ $administrator->grade  }}</td>
                    <td>{{ $administrator->shares  }}</td>
                    <td>{{ $administrator->function  }}</td>
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
