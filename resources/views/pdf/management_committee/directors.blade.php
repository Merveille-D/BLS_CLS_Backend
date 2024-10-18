@extends('pdf.layout')
@section('content')
<div class="container">
    <div class="header">
        <div class="left">
            <h1>Liste des directeurs</h1>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="Logo">
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Nom & Prénoms</th>
                <th>Date de naissance</th>
                <th>Lieu de naissance</th>
                <th>Nationalité</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($directors as $director)
                <tr>
                    <td height="50px" >{{ $director->name }}</td>
                    <td>{{ $director->birthdate  }}</td>
                    <td>{{ $director->birthplace  }}</td>   
                    <td>{{ $director->nationality  }}</td>
                    <td>{{ $director->address  }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer" id="footer">
        <span class="pagenum"></span>
    </div>
</div>
@endsection
