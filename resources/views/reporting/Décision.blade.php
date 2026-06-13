<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Décision</title>
</head>
<body style="font-family: 'Courier New', Courier, monospace">
    <center>Royaume du maroc</center>
    <table style="width: 100%">
        <thead>
            <tr>
                <th style="text-align: left;
                width: 33.33%;">D.A.F/D.A/S.G.A/N° : ...............</th>
                <th style="width: 33.33%;"><img src="{{ url('/') }}/assets/img/logo/logo_ests.png"
                    width="80" height="70" /></th>
                <th style="text-align: center;
                width: 33.33%;">RABAT LE :</th>
            </tr>
        </thead>
    </table>
    <center>
        <h2><b>DECISION</b></h2>
        <h2><b>LE DIRECTEUR GENERALE DE L'ECOLE</b></h2>
        <h2><b>SUPERIEURE DE TECHNOLOGIE DE SALE</b></h2>
    </center>
    <div style="text-align: justify;text-justify: inter-word;padding:20px;">
    <p>Vu le Dahir n°1-94-433 du 18 Chaabane 1415 ( 20 Janvier 1995 ) portant
        promulgation de loi n°37-94 portant ratification du décret-loi n°2-94-498
        du 16 Rabii II 1415 ( 23 Septembre 1994) portant création de L'ECOLE SUPERIEURE DE TECHNOLOGIE DE SALE ;
        </p>
    <p>Vu le Décret n°2-12-662 du 13 Joumada I 1434( 25 mars 2013 ) modifiant et
        complétant le décret n°2-94-763 du 21 Joumada II 1415( 25 novembre 1994 )
        pris pour l'application du Décret-loi n°2-94-498 du 16 Rabii II 1415( 23
        septembre 1994)portant création de L'ECOLE SUPERIEURE DE TECHNOLOGIE DE SALE ;
        </p>
    <p>Vu le statut du personnel ;<br><br>
        Vu la demande de congé <b>{{$data->Libelle}}</b> présentée par l'intéressé(e) ;<br><br>
        Vu l'avis favorable émis à cette demande ;<br><br>
        Vu la Carte d'identité nationale n° <b>{{$data->CIN}}</b></p>
    </div>
    <center>
        <b>DECIDE</b>
    </center>
    <div style="text-align: justify;text-justify: inter-word;padding:20px;">
        <p><span style="text-decoration: underline;"><b>ARTICLE PREMIER :</b></span> A compter du <b>{{(Carbon\Carbon::createFromFormat('Y-m-d', $data->DateDébut))->format('d/m/Y')}}</b>, un congé <b>{{$data->Libelle}}</b> de(<b>{{$data->nbJour}}</b>) jours, à passer au Maroc ou à l'Etranger, est accordé à <b>M. {{$data->Nom}} {{$data->Prénom}}</b>.
            </p>
            <p><span style="text-decoration: underline;"><b>ARTICLE DEUX :</b></span> Le présent congé prendra fin le <b>{{(Carbon\Carbon::createFromFormat('Y-m-d', $data->DateDébut))->addDays($data->nbJour)->format('d/m/Y')}}</b> inclus.
            </p>
        </div>
</body>
</html>
