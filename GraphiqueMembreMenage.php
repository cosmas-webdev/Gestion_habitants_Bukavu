<?php
// GraphiqueMembreMenage.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('connex.php');

// Requête statistique genre
$req = "
    SELECT
        SUM(CASE WHEN sexe = 'M' THEN 1 ELSE 0 END) AS hommes,
        SUM(CASE WHEN sexe = 'F' THEN 1 ELSE 0 END) AS femmes
    FROM membre";
$res = $bd->prepare($req);
$res->execute();
$ligne = $res->fetch();

$hommes = $ligne['hommes'] ?? 0;
$femmes = $ligne['femmes'] ?? 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Graphiques - Statistiques Membres</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
        background: #f0f2f5;
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        min-height: 100vh;
        color: #053168;
    }
    .nav-links {
        display: flex;
        gap: 16px;
        justify-content: center;
        margin: 38px 0 0 0;
    }
    .btn-retour {
        display: inline-block;
        background: #1877f2;
        color: #fff;
        border: none;
        border-radius: 7px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 1.05em;
        box-shadow: 0 2px 8px 0 rgba(24, 119, 242, .10);
        text-decoration: none;
        transition: background 0.18s, transform 0.12s;
        letter-spacing: .01em;
    }
    .btn-retour:hover, .btn-retour:focus {
        background: #166fe4;
        color: #fff;
        transform: translateY(-2px) scale(1.04);
        text-decoration: none;
    }
    .container {
        display: flex;
        align-items: flex-start;
        gap: 38px;
        padding: 40px 0;
        justify-content: center;
        max-width: 960px;
        margin: 0 auto;
    }
    .stats-container {
        background: #fff;
        padding: 30px 28px 24px 28px;
        border-radius: 13px;
        box-shadow: 0 4px 22px rgba(24,119,242,0.10);
        min-width: 230px;
        max-width: 270px;
        border: 1px solid #e4eaf1;
        font-size: 1.12em;
        color: #233c60;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-top: 16px;
    }
    .stats-container div {
        margin: 0 0 16px 0;
        padding-bottom: 7px;
        border-bottom: 1px solid #e7ebf7;
        width: 100%;
    }
    .stats-container div:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .stats-container strong {
        color: #1877f2;
        letter-spacing: .01em;
        font-weight: 700;
    }
    .graph-container {
        flex-grow: 1;
        max-width: 470px;
        background: #fff;
        border-radius: 13px;
        box-shadow: 0 4px 22px rgba(24,119,242,0.09);
        padding: 34px 22px 22px 22px;
        border: 1px solid #e4eaf1;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 10px;
        min-width: 270px;
    }
    .graph-container canvas {
        display: block;
        margin: 0 auto;
        width: 100% !important;
        max-width: 370px;
        height: auto !important;
        background: #fff;
        border-radius: 13px;
    }
    .title-block {
        text-align: center;
        margin: 36px 0 12px 0;
        color: #1877f2;
        font-size: 1.62em;
        font-weight: 900;
        letter-spacing: .01em;
        text-shadow: 0 2px 8px #e8f0fe7a;
    }
    @media (max-width: 950px) {
        .container {
            flex-direction: column;
            align-items: center;
            padding: 28px 4vw;
            gap: 28px;
        }
        .graph-container, .stats-container {
            width: 100%;
            min-width: 0;
            max-width: 510px;
        }
    }
    @media (max-width: 600px) {
        .graph-container, .stats-container { padding: 20px 6vw; }
        .title-block { font-size: 1.21em; }
        .container { gap: 16px; padding: 12vw 0 2vw 0; }
        .graph-container canvas {
            max-width: 99vw;
            min-width: 220px;
        }
    }
    </style>
</head>
<body>
    <div class="title-block">Statistiques des membres par Sexe</div>
    <div class="nav-links">
        <a href="Statistiques.php" class="btn-retour">Retour au menu principal</a>
        <a href="index.php" class="btn-retour">Accueil</a>
    </div>
    <div class="container">
        <div class="stats-container">
            <div><strong>Hommes&nbsp;:</strong> <?= $hommes ?></div>
            <div><strong>Femmes&nbsp;:</strong> <?= $femmes ?></div>
            <div><strong>Total&nbsp;:</strong> <?= $hommes + $femmes ?></div>
        </div>
        <div class="graph-container">
            <!-- Largeur/hauteur explicites pour lisibilité -->
            <canvas id="myChart" width="370" height="370"></canvas>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    'Hommes',
                    'Femmes'
                ],
                datasets: [{
                    data: [
                        <?= $hommes ?>,
                        <?= $femmes ?>
                    ],
                    backgroundColor: [
                        'rgba(24, 119, 242, 0.81)',   // Facebook blue
                        'rgba(242, 92, 144, 0.79)'    // Nice pink
                    ],
                    borderColor: [
                        '#1877f2cc',
                        '#f25c90cc'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#23272f',
                            font: { size: 16, weight: 'bold' },
                            padding: 24
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
