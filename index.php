<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        background: #f0f2f5;
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .wrap-flex {
        display: flex;
        gap: 48px;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 870px;
    }
    .side-card {
        background: #fff;
        border-radius: 14px;
        color: #1877f2;
        padding: 42px 32px 32px 32px;
        min-width: 260px;
        max-width: 310px;
        box-shadow: 0 4px 22px 0 rgba(0,0,0,.12);
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        border: 1px solid #d1d9e6;
        font-size: 1.02em;
    }
    .side-card .grp {
        color: #053168;
        font-size: 1.11em;
        margin-bottom: 18px;
        font-weight: bold;
        letter-spacing: .01em;
    }
    .side-card .noms {
        color: #444950;
        font-size: 1.08em;
        font-weight: normal;
        line-height: 1.6;
    }
    .center-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 4px 22px 0 rgba(0, 0, 0, .13);
        padding: 50px 48px 40px 48px;
        max-width: 380px;
        text-align: center;
        border: 1px solid #d1d9e6;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .center-card h1 {
        margin-bottom: 28px;
        font-size: 1.6em;
        color: #053168;
        font-weight: 700;
        line-height: 1.25;
    }
    .center-card a.button {
        display: inline-block;
        margin-top: 10px;
        padding: 14px 0;
        background: #1877f2;
        color: #fff;
        font-weight: 700;
        border: none;
        border-radius: 6px;
        font-size: 1.14em;
        width: 94%;
        box-shadow: 0 2px 8px 0 rgba(24, 119, 242, .11);
        transition: background .2s, transform .1s;
        text-align: center;
        text-decoration: none;
        letter-spacing: .01em;
        cursor: pointer;
    }
    .center-card a.button:hover {
        background: #166fe4;
        transform: translateY(-2px) scale(1.03);
        text-decoration: none;
    }
    @media (max-width: 900px) {
        .wrap-flex {
            flex-direction: column;
            gap: 32px;
            padding: 0 4vw;
        }
        .side-card { align-items: center; text-align: center; }
    }
    @media (max-width: 550px) {
        .center-card { padding: 34px 7vw 22px 7vw; }
        .side-card { padding: 22px 4vw 15px 4vw;}
        .wrap-flex { gap: 18px; }
    }
    </style>
</head>
<body>
    <div class="wrap-flex">
        <div class="side-card">
            <div class="grp">TP du Labo Informatique – Groupe 2</div>
            <div class="noms">
                1. Cosmas MUSAFIRI MUGONGO<br>
                2. CIZUNGU BAMBA Pacifique<br>
                <small style="color:#9bb2df; font-size:.98em;">Tous étudiants en L2 IGRH/ISPF.</small>
            </div>
        </div>
        <div class="center-card">
            <h1>Bienvenue sur notre travail pratique<br>cher enseignant.</h1>
            <a href="Login.php" class="button">Se connecter</a>
        </div>
    </div>
</body>
</html>
