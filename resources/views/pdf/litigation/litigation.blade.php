<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif de Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            width: 60px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .header .subtitle {
            margin: 5px 0;
        }
        .info-table, .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td, .data-table th, .data-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ccc;
        }
        .data-table th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
        }
        .highlight {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <img src="{{ public_path('images/bls-logo.png') }}" alt="Logo">
            </div>
            <div>
                <h1>Récapitulatif de Paiement</h1>
                <p class="subtitle">Portail National des services publics</p>
                <p class="subtitle">PS00140-220929-l8nf6wcc</p>
                <p class="subtitle">jeudi 29 septembre 2022</p>
            </div>
        </div>
        <table class="info-table">
            <tr>
                <td>
                    <strong>SOUDÉ THÉODORE</strong><br>
                    raoulgbadou@gmail.com<br>
                    Référence abonné: 330501530258FA<br>
                    Propriétaire du compteur: SOUDÉ THÉODORE
                </td>
                <td>
                    <strong>Référence Paiement</strong><br>
                    59303011
                </td>
                <td>
                    <strong>Agrégrateur</strong><br>
                    fedapay
                </td>
            </tr>
        </table>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Valeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Période</td>
                    <td>Juillet 2022</td>
                </tr>
                <tr>
                    <td>Numéro de facture</td>
                    <td>FE631171209589</td>
                </tr>
                <tr>
                    <td>Montant payé (SBEE)</td>
                    <td>803 FCFA</td>
                </tr>
                <tr>
                    <td>Numéro de Règlement</td>
                    <td>126685</td>
                </tr>
                <tr>
                    <td>Moyen de paiement</td>
                    <td>fedapay</td>
                </tr>
                <tr>
                    <td>Frais de transaction (fedapay)</td>
                    <td>0 FCFA</td>
                </tr>
                <tr>
                    <td>Source de paiement</td>
                    <td>MTN</td>
                </tr>
                <tr>
                    <td>Numéro transaction (MTN)</td>
                    <td>3487552449</td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            Montant Net payé <span class="highlight">803 FCFA</span>
        </div>
        <div class="footer">
            Arrêté le présent reçu à la somme de: 803 FCFA
        </div>
    </div>
</body>
</html>
