<?php
$idMenage = isset($_GET['idMenage']) ? $_GET['idMenage'] : null;
include('connex.php');

// Requête pour les statistiques du ménage
$reqStats = $bd->prepare("SELECT
            COUNT(*) AS totalMembres,
            SUM(CASE WHEN sexe='M' THEN 1 ELSE 0 END) AS nbHomme,
            SUM(CASE WHEN sexe='F' THEN 1 ELSE 0 END) AS nbFemme
         FROM membre
         WHERE idMenage = :idMenage
         ")
         ;
$reqStats->execute([':idMenage' => $idMenage]);
$stats = $reqStats->fetch(PDO::FETCH_ASSOC);

// Requête pour les détails du ménage
$reqMenage = $bd->prepare("SELECT * FROM menage WHERE idMenage = :idMenage");
$reqMenage->execute([':idMenage' => $idMenage]);
$menage = $reqMenage->fetch();

// Traitement du formulaire d'ajout
if(isset($_POST['enregistrer'])){
    try {
        // Préparation de la requête d'INSERTION (pas de SELECT)
        $reqInsert = $bd->prepare("INSERT INTO membre
                                 (noms, sexe, nationalite, etat_civil, territoire, village, idMenage)
                                 VALUES
                                 (:noms, :sexe, :nationalite, :etat_civil, :territoire, :village, :idMenage)");

        // Exécution avec les paramètres
        $reqInsert->execute([
            ':noms' => $_POST['noms'],
            ':sexe' => $_POST['sexe'],
            ':nationalite' => $_POST['nationalite'],
            ':etat_civil' => $_POST['etat_civil'],
            ':territoire' => $_POST['territoire'],
            ':village' => $_POST['village'],
            ':idMenage' => $idMenage
        ]);

        // Rafraîchir la page après l'ajout
        header("Location: Membre.php?idMenage=$idMenage");
        exit();
    } catch(PDOException $e) {
        $error_message = "Erreur lors de l'enregistrement: ".$e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Mairie - Ménage <?= htmlspecialchars($idMenage) ?></title>
  <link href="../img/favicon.png" rel="icon">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Accueil</a></li>
          <li class="breadcrumb-item active">Ménage <?= htmlspecialchars($menage['nomResponsable'] ?? '') ?></li>
        </ol>

        <!-- Affichage des erreurs -->
        <?php if(isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <!-- Statistiques du ménage -->
        <div class="row mb-4">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5>Statistiques du Ménage</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="stat-card bg-primary text-white p-3 rounded">
                      <h6>Total Membres</h6>
                      <h3><?= $stats['totalMembres'] ?? 0 ?></h3>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="stat-card bg-info text-white p-3 rounded">
                      <h6>Hommes</h6>
                      <h3><?= $stats['nbHomme'] ?? 0 ?></h3>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="stat-card bg-danger text-white p-3 rounded">
                      <h6>Femmes</h6>
                      <h3><?= $stats['nbFemme'] ?? 0 ?></h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Liste des membres -->
        <div class="card mb-3">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <h5>Liste des membres</h5>
              <a href="MembreAjout.php?idMenage=<?= $idMenage ?>" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Ajouter un membre
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                  <tr>
                    <th>Numéro</th>
                    <th>Noms</th>
                    <th>Sexe</th>
                    <th>Nationalité</th>
                    <th>Etat-civil</th>
                    <th>Territoire</th>
                    <th>Village</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
$reqMembres = $bd->prepare("SELECT idMembre, noms, sexe, nationalite, etat_civil, territoire, village FROM membre WHERE idMenage = :idMenage");
$reqMembres->execute([':idMenage' => $idMenage]);
$membres = $reqMembres->fetchAll(PDO::FETCH_ASSOC);

$counter = 1;
foreach($membres as $membre):
?>
<tr>
    <td><?= $counter++ ?></td>
    <td><?= htmlspecialchars($membre['noms']) ?></td>
    <td><?= htmlspecialchars($membre['sexe']) ?></td>
    <td><?= htmlspecialchars($membre['nationalite']) ?></td>
    <td><?= htmlspecialchars($membre['etat_civil']) ?></td>
    <td><?= htmlspecialchars($membre['territoire']) ?></td>
    <td><?= htmlspecialchars($membre['village']) ?></td>
    <td>
        <a href="MembreEdit.php?id=<?= $membre['idMembre'] ?>" class="btn btn-sm btn-primary">
            <i class="fa fa-edit"></i>
        </a>
    </td>
</tr>
<?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Formulaire d'ajout de membre -->
        <div class="card">
          <div class="card-header">
            <h5>Ajouter un nouveau membre</h5>
          </div>
          <div class="card-body">
            <form method="POST">
              <input type="hidden" name="idMenage" value="<?= $idMenage ?>">
              <div class="row">
                <div class="col-md-4 form-group">
                  <label>Noms et Postnoms</label>
                  <input type="text" name="noms" class="form-control" required>
                </div>
                <div class="col-md-2 form-group">
                  <label>Sexe</label>
                  <select name="sexe" class="form-control" required>
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                  </select>
                </div>
                <div class="col-md-3 form-group">
                  <label>Nationalité</label>
                  <input type="text" name="nationalite" class="form-control" required>
                </div>
                <div class="col-md-3 form-group">
                  <label>Etat-civil</label>
                  <select name="etat_civil" class="form-control" required>
                    <option value="Célibataire">Célibataire</option>
                    <option value="Marié(e)">Marié(e)</option>
                    <option value="Veuf(ve)">Veuf(ve)</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 form-group">
                  <label>Territoire</label>
                  <input type="text" name="territoire" class="form-control" required>
                </div>
                <div class="col-md-4 form-group">
                  <label>Village</label>
                  <input type="text" name="village" class="form-control" required>
                </div>
                <div class="col-md-4 form-group">
                  <label>&nbsp;</label>
                  <button type="submit" name="enregistrer" class="btn btn-primary btn-block">
                    <i class="fa fa-save"></i> Enregistrer
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        }
      });
    });
  </script>
</body>
</html>
<?php
    if(isset($_POST['enregistrer'])){// si on appuie sur le boutton enregistrer
        $noms=$_POST['noms'];
        $sexe=$_POST['sexe'];
        $nationalite=$_POST['nationalite'];
        $etat_civil=$_POST['etat_civil'];
        $territoire=$_POST['territoire'];
        $village=$_POST['village'];
        $idMenage=$_POST['idMenage'];
        $db=mysqli_connect("127.0.0.1","root","","mydb");
        //$req;

    if ($db->query('INSERT INTO membre(noms,sexe,nationalite,etat_civil,territoire,village,idMenage)
        VALUES("'.$noms.'","'.$sexe.'","'.$nationalite.'","'.$etat_civil.'","'.$territoire.'","'.$village.'","'.$idMenage.'")')) {
        echo"Enregistrer avec succès";
         echo"<meta http-equiv='refresh' content='0;url=membre'>";
    } else {
        echo"Echec d'enregistrement";
    }
    }
