@extends('pdf.layout')
@section('content')
<div class="container">
    <x-pdf-header :data="$legal_watch" :bankLogo="$bankLogo" :blsLogo="$base64Image" title="Veille juridique"/>
    <h2>Détails</h2>
    <x-pdf-details :details="$details" />

    <h2>Resumé</h2>
    <p>{{ $legal_watch->summary }}</p>

    <h2>Innovations</h2>
    <p>{{ $legal_watch->innovation }}</p>

    <div class="footer" id="footer">
        <span class="pagenum"></span>
    </div>
</div>
@endsection
