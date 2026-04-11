<?php
include('connex.php');

if (isset($_POST['idAvenue'])) {
    $idAvenue = $_POST['idAvenue'];
    $b = 'sans NP';

    $req = $bd->prepare("
        SELECT
            avenue.Designation,
            quartier.DesignationQ,
            commune.designationC,
            menage.idMenage
        FROM avenue
        INNER JOIN quartier ON avenue.idQuartier = quartier.idQuartier
        INNER JOIN commune ON quartier.idcommune = commune.idcommune
        LEFT JOIN menage ON avenue.idAvenue = menage.idAvenue
        WHERE avenue.idAvenue = ?
        ORDER BY menage.idMenage DESC
        LIMIT 1
    ");

    $req->execute([$idAvenue]);

    if ($ligne = $req->fetch()) {
        $designationAvenue = $ligne['Designation'];
        $designationQuartier = $ligne['DesignationQ'];
        $designationCommune = $ligne['designationC'];
        $idme = $ligne['idMenage'];

        $avn = substr($designationAvenue, 0, 2);
        $qrt = substr($designationQuartier, 0, 2);
        $com = substr($designationCommune, 0, 2);
        $nouveauId = $idme + 1;
        $code = strtoupper("$com-$qrt-$avn/$nouveauId");

        echo $code;
    } else {
        $req1 = $bd->prepare("
            SELECT
                avenue.Designation,
                quartier.DesignationQ,
                commune.designationC
            FROM avenue
            INNER JOIN quartier ON avenue.idQuartier = quartier.idQuartier
            INNER JOIN commune ON quartier.idcommune = commune.idcommune
            WHERE avenue.idAvenue = ?
        ");

        $req1->execute([$idAvenue]);

        if ($ligne = $req1->fetch()) {
            $designationAvenue = $ligne['Designation'];
            $designationQuartier = $ligne['DesignationQ'];
            $designationCommune = $ligne['designationC'];

            $avn = substr($designationAvenue, 0, 2);
            $qrt = substr($designationQuartier, 0, 2);
            $com = substr($designationCommune, 0, 2);
            $code = strtoupper("$com-$qrt-$avn/1");

            echo $code;
        } else {
            echo $b;
        }
    }
}
?>
