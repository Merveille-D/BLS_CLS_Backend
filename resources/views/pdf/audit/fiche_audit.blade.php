@extends('pdf.layout')
@section('content')
<div class="container">

    <div class="header">
        <div class="left">
            <img src="{{ $bankLogo }}" alt="Bank Logo">
        </div>
        <div class="center" style="margin-top: 10px;">
            <h1>Suivi Audit </h1>
            <p class="subtitle bold">{{$data['title']}}</p>
            <p class="subtitle italic underline">{{ $data['audit_reference'] }}</p>
            <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
        </div>
        <div class="right">
            <img src="{{ $base64Image }}" alt="BLS Logo">
        </div>
    </div>

    <h2>Détail de l'audit</h2>
    <x-pdf-details :details="$details" />
    <br>

    <h2>Historique des transfers</h2>
    @foreach ($data['transfers'] as $item )
    <br>
        <h3><span style="color:green">Status :</span> {{$item['notation']['status']}} | <span style="color:green">Evaluateur :</span> {{$item['collaborators'][0]['lastname']}} {{$item['collaborators'][0]['firstname']}} | <span style="color:green">Note globale : {{$item['notation']['note'] ?? '_'}}</span></h3>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Indicateurs</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item['notation']['indicators'] as $item )
                    <tr>
                        <td>{{ $item['audit_performance_indicator']['title'] }}</td>
                        <td>{{ $item['note'] ?? '_'  }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    @endforeach
    <br>

    {{-- First  Audit --}}
    <h3><span style="color:green">Status :</span> {{$data['original_status']}} | <span style="color:green">Evaluateur :</span> {{$data['creator']['lastname']}} {{$data['creator']['firstname']}} | <span style="color:green">Note globale : {{$data['original_note'] ?? '_'}}</span></h3>

    <table class="data-table">
        <thead>
            <tr>
                <th>Indicateurs</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['last_indicators'] as $item )
                <tr>
                    <td>{{ $item['audit_performance_indicator']['title'] }}</td>
                    <td>{{ $item['note'] ?? '8'  }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <div class="footer" id="footer">
        <span class="pagenum"></span>
    </div>
</div>
@endsection
