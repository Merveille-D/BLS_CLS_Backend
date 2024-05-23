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
            font-size: 14px;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .right {
            right: 0;
        }
        .left {
            left: 0;
        }

        .gray {
            color: #6d6d6d;
        }
        .bold {
            font-weight: bold;
            font-size: 14px;
        }
        .italic {
            font-style: italic;
        }
        .underline {
            text-decoration: underline;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            display: inline-block;
            position: relative;
            width: 100%;
            height: 100px;
            /* text-align: center; */
            margin-bottom: 30px;
        }

        .header div {
            display: inline-block;
            position: absolute;
        }
        .header img {
            width: 140px;
            padding: 0.67rem 0;
        }
        .header h1 {
            font-size: 42px;
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
        .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }
        .footer {
            bottom: 0px;
        }
        .pagenum:before {
            content: counter(page);
        }
        h2 {
            color: green;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
