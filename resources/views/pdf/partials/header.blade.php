<div class="header">
    <div class="left">
        <img src="{{ $bankLogo }}" alt="Bank Logo">
    </div>
    <div class="center" style="margin-top: 10px;">
        <h1>Fiche de suivi </h1>
        <p class="subtitle bold">{{ $litigation->name }}</p>
        <p class="subtitle italic underline">{{ $litigation->reference }}</p>
        <p class="subtitle gray">{{ date('d-m-Y H:i') }}</p>
    </div>
    <div class="right">
        <img src="{{ $base64Image }}" alt="BLS Logo">
    </div>
</div>
