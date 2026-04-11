<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Statistiques</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        background: #f0f2f5;
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        min-height: 100vh;
        color: #05254d;
    }
    .dashboard {
        max-width: 870px;
        margin: 48px auto 0 auto;
        box-sizing: border-box;
    }
    .dashboard-header {
        background: #1877f2;
        color: #fff;
        padding: 2.5rem 2.5rem 1.1rem 2.5rem;
        border-radius: 15px 15px 0 0;
        box-shadow: 0 4px 18px 0 rgba(24, 119, 242, 0.07), 0 2px 7px 0 rgba(135,155,200,0.04);
        text-align: left;
        position: relative;
    }
    .dashboard-header h1 {
        margin: 0;
        font-size: 2.2rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: #fff;
        text-shadow: 0 2px 6px #e4eefd77;
    }
    .dashboard-content {
        background: #fff;
        border-radius: 0 0 15px 15px;
        box-shadow: 0 4px 28px rgba(24, 119, 242, .10);
        padding: 2.3rem 2.5rem 2.5rem 2.5rem;
        display: flex;
        gap: 2.4rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
        padding: 2.2rem 1.6rem 1.5rem 1.6rem;
        min-width: 230px;
        max-width: 275px;
        text-align: center;
        transition: box-shadow 0.2s, transform 0.13s;
        border: 1px solid #e4eaf1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .card:hover {
        box-shadow: 0 6px 20px rgba(24, 119, 242, .13);
        transform: translateY(-3px) scale(1.025);
        border-color: #1877f244;
    }
    .card-title {
        font-size: 1.13rem;
        color: #1877f2;
        margin-bottom: 1.1rem;
        font-weight: 700;
        letter-spacing: .01em;
    }
    .card-link {
        display: inline-block;
        margin-top: .3rem;
        padding: .95rem 1.5rem;
        background: #1877f2;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 700;
        font-size: 1em;
        letter-spacing: .01em;
        box-shadow: 0 2px 8px 0 rgba(24, 119, 242, .07);
        transition: background 0.18s, transform .09s;
    }
    .card-link:hover {
        background: #166fe4;
        transform: scale(1.025) translateY(-2px);
        text-decoration: none;
    }
    .logout-section {
        text-align: center;
        margin: 22px 0 0 0;
    }
    .logout-link {
        display: inline-block;
        color: #1877f2;
        text-decoration: none;
        font-weight: 600;
        padding: 0.85rem 2.6rem;
        border-radius: 8px;
        background: #e6eefc;
        font-size: 1.07em;
        box-shadow: 0 2px 10px 0 #1877f219;
        border: 1px solid #c7daf8;
        transition: background .18s, color .16s, transform .11s;
    }
    .logout-link:hover {
        background: #d2e3fb;
        color: #144b95;
        transform: translateY(-2px) scale(1.025);
        text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .dashboard {
            margin: 22px 2vw 0 2vw;
        }
        .dashboard-header,
        .dashboard-content {
            padding-left: 1.2rem;
            padding-right: 1.2rem;
        }
        .dashboard-content {
            gap: 1.4rem;
            padding-bottom: 1.2rem;
        }
    }
    @media (max-width: 650px) {
        .dashboard-content {
            flex-direction: column;
            gap: 18px;
            padding: 1.3rem 0.6rem;
        }
        .dashboard-header {
            padding: 1.5rem 1rem .55rem 1rem;
        }
        .dashboard {
            margin: 10vw 2vw 0 2vw;
        }
    }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="dashboard-header">
            <h1>Tableau de bord</h1>
        </div>

        <div class="dashboard-content">
            <div class="card">
                <div class="card-title">Statistiques des membres</div>
                <a href="GraphiqueMembreMenage.php" class="card-link">Voir le graphique</a>
            </div>
            <div class="card">
                <div class="card-title">Statistiques par zone</div>
                <a href="SessionGraphiquesParZone.php" class="card-link">Voir le graphique</a>
            </div>
        </div>

        <div class="logout-section">
            <a href="Logout.php" class="logout-link">Déconnexion</a>
        </div>
    </div>
</body>
</html>
