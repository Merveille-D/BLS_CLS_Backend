@props(['bankLogo', 'blsLogo', 'data'])

<div class="header">
    <div class="left">
        <img src="{{ $bankLogo }}" alt="Bank Logo">
    </div>
    <div class="center" style="margin-top: 10px;">
        <h1>Fiche de suivi </h1>
        <p class="subtitle bold">{{ $data->name }}</p>
        <p class="subtitle italic underline">{{ $data->reference }}</p>
        <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
    </div>
    <div class="right">
        <img src="{{ $blsLogo }}" alt="BLS Logo">
    </div>
</div>