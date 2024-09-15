<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat d'Actions</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
        }

        .outer-border {
            border: 18px solid green;
            padding: 4px;
            /* display: flex; */
            /* justify-content: center;
            align-items: center; */
            height: 100vh;
        }

        .certificate-container {
            background-color: #fff;
            border: 3px solid green;
            padding: 50px;
            text-align: center;
            height: 85%;
            /* width: 90%; */
            margin: 0 auto;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
            text-align: center;
        }

        .certificate-info {
            text-align: left;
            float: left;
            width: 50%;
            font-size: 14px;
        }

        .share-info {
            text-align: right;
            float: right;
            width: 50%;
            font-size: 14px;
        }

        .clearfix {
            clear: both;
        }

        .logo {
            text-align: center;
            margin: 20px 0;
        }

        .logo img {
            width: 132px;
        }

        h1 {
            font-size: 28px;
            color: green;
            margin: 20px 0;
        }

        .company-info, .certificate-content {
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
        }

        .done_at {
            text-align: right;
            margin-top: 20px;
        }

        .signature-section {
            width: 100%;
            text-align: center;
            margin-top: 40px;
        }

        .signature-block {
            display: inline-block;
            width: 35%;
            margin: 0 5%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin: 10px 0;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="outer-border">
        <div class="certificate-container">
            <div class="header">
                <div class="certificate-info">
                    <p>Certificat d'actions : <span>[N° DU CERTIFICAT]</span></p>
                </div>
                <div class="share-info">
                    <p>Nombre d'actions : <span>[NOMBRE]</span></p>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="logo">
                {{-- <img src="{{ asset('afrikskills-logo.webp') }}" alt="Logo de la Société"> --}}
            </div>

            <h1>CERTIFICAT D'ACTIONS</h1>

            <div class="company-info">
                <p><strong>[NOM DE LA SOCIÉTÉ]</strong></p>
                <p>[ADRESSE DE LA SOCIÉTÉ]</p>
            </div>

            <div class="certificate-content">
                <p>
                    Nous soussigné, certifions que <strong>M. [NOM DE L’ACTIONNAIRE]</strong>, domicilié à
                    <strong>[ADRESSE DE L’ACTIONNAIRE]</strong> est titulaire de
                    <strong>[NOMBRE D’ACTIONS EN TOUTES LETTRES]</strong> action(s) dans le capital
                    de la société.
                </p>
            </div>

            <div class="certificate-content">
                <p>En foi de quoi, nous délivrons le présent certificat pour servir et valoir ce que de droit.</p>
            </div>

            <div class="done_at">
                Fait à ........................... le .. / .. / ....
            </div>

            <div class="signature-section">
                <div class="signature-block">
                    <p>Administrateur</p>
                    <div class="signature-line"></div>
                </div>
                <div class="signature-block">
                    <p>Président du conseil</p>
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
