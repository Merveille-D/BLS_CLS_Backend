<!DOCTYPE html>
<html>
<head>
    <title>Veille Juridique {{ $legalWatch->reference }}</title>
</head>
<body>
    <h2>Veille Juridique {{ $legalWatch->reference }}</h2>
    <div>
        <h2>Description</h2>
        <p>
            {{ $legalWatch->mail_content }}
        </p>
        <br><br>
        <p>Cordialement!</p>
    </div>
</body>
</html>

