<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Décision de Congé</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            color: #000;
            margin: 40px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            margin-bottom: 30px;
        }
        .header-table td {
            vertical-align: middle;
            padding: 8px;
        }
        .ref { text-align: left; font-size: 12px; }
        .date { text-align: right; font-size: 12px; }
        h1 {
            text-align: center;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 30px 0 5px;
            text-decoration: underline;
        }
        .subtitle {
            text-align: center;
            font-size: 13px;
            margin-bottom: 30px;
        }
        .section {
            text-align: justify;
            padding: 0 20px;
            line-height: 1.8;
        }
        .section p {
            margin: 10px 0;
        }
        .article-title {
            text-decoration: underline;
            font-weight: bold;
        }
        .divider {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            margin: 25px 0;
            letter-spacing: 3px;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
            padding-right: 40px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="ref">Réf. : ........................</td>
            <td class="date">Le : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
        </tr>
    </table>

    <h1>Décision de Congé</h1>
    <p class="subtitle">Direction des Ressources Humaines</p>

    <div class="section">

        <p>Vu la demande de congé de type <b>{{ $data->Libelle }}</b> présentée par l'intéressé(e) ;</p>

        <p>Vu l'avis favorable émis à cette demande ;</p>

        <p>Vu la Carte d'Identité Nationale n° <b>{{ $data->CIN }}</b> ;</p>

        <p>Vu le statut du personnel en vigueur ;</p>

    </div>

    <div class="divider">DÉCIDE</div>

    <div class="section">

        <p>
            <span class="article-title">ARTICLE PREMIER :</span>
            À compter du <b>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data->DateDébut)->format('d/m/Y') }}</b>,
            un congé de type <b>{{ $data->Libelle }}</b> d'une durée de <b>{{ $data->nbJour }}</b> jour(s)
            est accordé à <b>M. / Mme. {{ $data->Nom }} {{ $data->Prénom }}</b>.
        </p>

        <p>
            <span class="article-title">ARTICLE DEUX :</span>
            Le présent congé prendra fin             le
            <b>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data->DateDébut)->addDays($data->nbJour - 1)->format('d/m/Y') }}</b>
            inclus.
        </p>

        <p>
            <span class="article-title">ARTICLE TROIS :</span>
            L'intéressé(e) est tenu(e) de reprendre son poste à l'expiration du congé susvisé.
            Toute prolongation devra faire l'objet d'une nouvelle demande dûment justifiée.
        </p>

    </div>

    <div class="signature">
        <p>Le Responsable des Ressources Humaines</p>
        <br><br><br>
        <p>Signature et cachet</p>
    </div>

</body>
</html>
