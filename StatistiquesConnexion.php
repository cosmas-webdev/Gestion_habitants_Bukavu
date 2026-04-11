<?php
session_start();
require 'connex.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

// Récupération des infos utilisateur
$user_id = $_SESSION['user_id'];
try {
    $req = $bd->prepare("SELECT email FROM utilisateurs WHERE idUtilisateur = ?");
    $req->execute([$user_id]);
    $user = $req->fetch();
} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Statistiques</title>
    <style>
        body {
            background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            min-height: 100vh;
        }
        .dashboard {
            max-width: 900px;
            margin: 40px auto;
            padding: 0;
        }
        .dashboard-header {
            background: #3498db;
            color: white;
            padding: 2rem 2.5rem 1rem 2.5rem;
            border-radius: 18px 18px 0 0;
            box-shadow: 0 4px 16px rgba(44, 62, 80, 0.08);
            text-align: left;
        }
        .dashboard-header h1 {
            margin: 0;
            font-size: 2.2rem;
            letter-spacing: 1px;
        }
        .dashboard-header .user-info {
            margin-top: 0.5rem;
            font-size: 1rem;
            opacity: 0.85;
        }
        .dashboard-content {
            background: white;
            border-radius: 0 0 18px 18px;
            box-shadow: 0 8px 24px rgba(44, 62, 80, 0.08);
            padding: 2rem 2.5rem;
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card {
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
            padding: 1.5rem 1.2rem;
            min-width: 220px;
            max-width: 260px;
            text-align: center;
            transition: box-shadow 0.2s;
        }
        .card:hover {
            box-shadow: 0 4px 16px rgba(44, 62, 80, 0.12);
        }
        .card-title {
            font-size: 1.15rem;
            color: #2980b9;
            margin-bottom: 0.7rem;
            font-weight: 600;
        }
        .card-link {
            display: inline-block;
            margin-top: 0.5rem;
            padding: 0.7rem 1.2rem;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.2s;
        }
        .card-link:hover {
            background: #2980b9;
        }
        .logout-link {
            display: inline-block;
            margin: 2rem auto 0 auto;
            color: #e74c3c;
            text-decoration: none;
            font-weight: 500;
            padding: 0.7rem 1.5rem;
            border-radius: 6px;
            background: #fbeee6;
            transition: background 0.2s;
        }
        .logout-link:hover {
            background: #fad2cf;
        }
        @media (max-width: 700px) {
            .dashboard-content {
                flex-direction: column;
                padding: 1rem;
            }
            .dashboard-header {
                padding: 1.2rem 1rem 0.7rem 1rem;
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
            <div class="card-title">Statistiques Membres</div>
            <a href="GraphiqueMembreMenage.php" class="card-link">Voir le graphique</a>
        </div>
        <div class="card">
            <div class="card-title">Statistiques par Zone</div>
            <a href="SessionGraphiquesParZone.php" class="card-link">Voir le graphique</a>
        </div>
    </div>
</div>


        </div>
        <div style="text-align:center;">
            <a href="Logout.php" class="logout-link">Déconnexion</a>
        </div>
    </div>
</body>
</html>
