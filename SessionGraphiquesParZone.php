<?php
session_start();
include('connex.php');

// Configuration des niveaux disponibles
$niveaux = [
    'commune' => [
        'titre' => 'Communes',
        'table' => 'commune',
        'designation' => 'designationc',
        'join' => 'INNER JOIN quartier ON avenue.idQuartier = quartier.idquartier
                   INNER JOIN commune ON quartier.idcommune = commune.idcommune',
        'group' => 'commune.designationc',
        'color' => '#1877f2', // Facebook blue
        'parent_table' => null,
        'parent_designation' => null
    ],
    'quartier' => [
        'titre' => 'Quartiers',
        'table' => 'quartier',
        'designation' => 'DesignationQ',
        'join' => 'INNER JOIN quartier ON avenue.idQuartier = quartier.idquartier
                   INNER JOIN commune ON quartier.idcommune = commune.idcommune',
        'group' => 'quartier.DesignationQ, commune.designationc',
        'color' => '#2ecc71',
        'parent_table' => 'commune',
        'parent_designation' => 'designationc'
    ],
    'avenue' => [
        'titre' => 'Avenues',
        'table' => 'avenue',
        'designation' => 'Designation',
        'join' => 'INNER JOIN quartier ON avenue.idQuartier = quartier.idquartier',
        'group' => 'avenue.Designation, quartier.DesignationQ',
        'color' => '#e74c3c',
        'parent_table' => 'quartier',
        'parent_designation' => 'DesignationQ'
    ]
];

// Récupérer le niveau demandé (par défaut: commune)
$niveau = $_GET['niveau'] ?? 'commune';
if (!array_key_exists($niveau, $niveaux)) {
    $niveau = 'commune';
}

// Vérifier si les données sont en session
$session_key = 'data_' . $niveau;
if (!isset($_SESSION[$session_key])) {
    // Construire la requête dynamiquement
    $config = $niveaux[$niveau];

    $req = "SELECT {$config['table']}.{$config['designation']} AS nom, COUNT(menage.idMenage) AS nb_menages";
    if ($niveau === 'avenue') {
        // Inclure le parent (quartier)
        $req .= ", quartier.DesignationQ AS parent_nom";
    } elseif ($niveau === 'quartier') {
        // Inclure le parent (commune)
        $req .= ", commune.designationc AS parent_nom";
    }

    $req .= " FROM menage
              INNER JOIN avenue ON menage.idAvenue = avenue.idAvenue
              {$config['join']}
              GROUP BY {$config['group']}";

    $req .= " ORDER BY nb_menages DESC";

    try {
        $res = $bd->prepare($req);
        $res->execute();
        $_SESSION[$session_key] = $res->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur SQL: " . $e->getMessage() . "<br>Requête: " . $req);
    }
}

$donnees = $_SESSION[$session_key];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques par <?= htmlspecialchars($niveaux[$niveau]['titre']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f2f5;
        margin: 0;
        color: #222f3e;
    }
    .container {
        max-width: 1050px;
        margin: 40px auto 0 auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 6px 32px rgba(24,119,242,0.07);
        padding: 38px 44px 30px 44px;
    }
    .header {
        text-align: center;
        margin-bottom: 32px;
    }
    .header h1 {
        color: #1877f2;
        margin-bottom: 8px;
        font-size: 2.2em;
        font-weight: 900;
        letter-spacing: .01em;
        text-shadow: 0 2px 8px #e8f0fe60;
    }
    .header p {
        color: #325e90;
        font-size: 1.09em;
        margin-top: 0;
        margin-bottom: 7px;
    }
    .nav-tabs {
        display: flex;
        justify-content: center;
        margin-bottom: 26px;
        gap: 10px;
        flex-wrap: wrap;
        background: #eef2f8;
        padding: 13px 0 5px 0;
        border-radius: 7px;
        box-shadow: 0 2px 19px 0 rgba(24,119,242, 0.03);
    }
    .nav-tabs a {
        padding: 11px 34px;
        background: #e2e8f0;
        border-radius: 5px;
        text-decoration: none;
        color: #270d87;
        font-weight: 700;
        font-size: 1.11em;
        transition: all 0.3s;
        border: none;
        letter-spacing: .01em;
    }
    .nav-tabs a.active {
        background: <?= $niveaux[$niveau]['color'] ?>;
        color: #fff;
        box-shadow: 0 2px 11px 0 <?= $niveaux[$niveau]['color'] ?>26;
    }
    .nav-tabs a:hover:not(.active) {
        background: #d6e0f2;
        color: #1877f2;
    }
    .actions-top {
        margin: 0 0 24px 0;
        text-align: center;
        gap: 16px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }
    .btn-retour {
        background: #1877f2;
        color: #fff;
        border: none;
        border-radius: 7px;
        padding: 12px 34px;
        font-weight: 600;
        font-size: 1.09em;
        box-shadow: 0 2px 8px 0 rgba(24,119,242, .10);
        text-decoration: none;
        transition: background .18s, transform .12s;
        letter-spacing: .01em;
        display: inline-block;
        margin-bottom: 10px;
    }
    .btn-retour:hover, .btn-retour:focus {
        background: #166fe4;
        color: #fff;
        transform: translateY(-2px) scale(1.04);
        text-decoration: none;
    }
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(24,119,242,0.06);
        padding: 29px 22px;
        margin-bottom: 30px;
        max-width: 850px;
        margin-left: auto;
        margin-right: auto;
    }
    .card h2 {
        text-align: center;
        color: <?= $niveaux[$niveau]['color'] ?>;
        font-size: 1.37em;
        font-weight: 900;
        margin: 0 0 18px 0;
        letter-spacing: .01em;
    }
    .data-list {
        max-height: 350px;
        overflow-y: auto;
        margin-bottom: 26px;
        padding-right: 8px;
    }
    .data-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 14px 18px;
        margin: 8px 0;
        background: #f9fafb;
        border-left: 4px solid <?= $niveaux[$niveau]['color'] ?>;
        border-radius: 4px;
        transition: box-shadow 0.3s, transform 0.2s;
        font-size: 1em;
    }
    .data-item:hover {
        transform: translateX(7px) scale(1.012);
        box-shadow: 0 3px 7px rgba(24,119,242,0.08);
    }
    .item-name {
        font-weight: 700;
        color: #162d50;
        font-size: 1.01em;
    }
    .item-parent {
        font-size: 0.89em;
        color: #7f8c8d;
        margin-top: 4px;
        font-weight: 500;
    }
    .item-count {
        font-weight: 800;
        color: <?= $niveaux[$niveau]['color'] ?>;
        background: <?= $niveaux[$niveau]['color'] ?>11;
        padding: 4px 16px;
        border-radius: 21px;
        font-size: 1em;
        letter-spacing: .01em;
        min-width: 100px;
        text-align: center;
    }
    .no-data {
        text-align: center;
        font-size: 1.09em;
        color: #c0392b;
        margin: 30px 0;
    }
    canvas {
        width: 100% !important;
        min-height: 350px !important;
        max-height: 520px !important;
        margin-top: 30px;
        background: #fcfcfe;
        border-radius: 12px;
    }
    @media (max-width: 1000px) {
        .container { padding: 12px 2vw 8vw 2vw; }
    }
    @media (max-width: 850px) {
        .card { padding: 13px 3vw; }
    }
    @media (max-width: 700px) {
        .nav-tabs a { padding: 9px 13px; font-size: .95em; }
        .container { padding: 0 0 10vw 0; }
        .card { padding: 12px 2vw; }
    }
    @media (max-width: 600px) {
        .container { max-width: 100vw; border-radius: 0; padding: 0 0 6vw 0; box-shadow: none;}
        .card { border-radius: 0; }
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Statistiques des Ménages</h1>
            <p>Répartition par niveau géographique</p>
        </div>

        <div class="actions-top">
            <a href="Statistiques.php" class="btn-retour">Retour au menu principal</a>
            <a href="index.php" class="btn-retour">Accueil</a>
        </div>

        <div class="nav-tabs">
            <?php foreach ($niveaux as $key => $config): ?>
                <a href="?niveau=<?= htmlspecialchars($key) ?>" class="<?= $key === $niveau ? 'active' : '' ?>">
                    <?= htmlspecialchars($config['titre']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="card">
            <h2>Répartition par <?= htmlspecialchars($niveaux[$niveau]['titre']) ?></h2>
            <div class="data-list">
                <?php if (empty($donnees)): ?>
                    <div class="no-data">Aucune donnée disponible</div>
                <?php else: ?>
                    <?php foreach ($donnees as $item): ?>
                        <div class="data-item">
                            <div>
                                <div class="item-name"><?= htmlspecialchars($item['nom']) ?></div>
                                <?php if (isset($item['parent_nom'])): ?>
                                    <div class="item-parent">
                                        <?= $niveau === 'avenue' ? 'Quartier' : 'Commune' ?> :
                                        <?= htmlspecialchars($item['parent_nom']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="item-count"><?= number_format($item['nb_menages'], 0, ',', ' ') ?> ménages</div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($donnees)): ?>
                <canvas id="dataChart"></canvas>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty($donnees)): ?>
    <script>
        const ctx = document.getElementById('dataChart').getContext('2d');
        const chartData = {
            labels: <?= json_encode(array_column($donnees, 'nom')) ?>,
            datasets: [{
                label: 'Nombre de ménages',
                data: <?= json_encode(array_column($donnees, 'nb_menages')) ?>,
                backgroundColor: '<?= $niveaux[$niveau]['color'] ?>',
                borderColor: '<?= $niveaux[$niveau]['color'] ?>',
                borderWidth: 1
            }]
        };
        new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Répartition des ménages par <?= $niveaux[$niveau]['titre'] ?>',
                        font: { size: 16 }
                    },
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString() + ' ménages';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>
