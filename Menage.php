<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Mairie</title>
  <link href="./../img/favicon.png" rel="icon">
  <link href="./../img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="./lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="load.css" rel="stylesheet">
  <script src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body id="page-top">

   <div id="wrapper">

    <div id="content-wrapper">

      <div class="container-fluid">

        <ol class="breadcrumb cache">
          <li class="breadcrumb-item">
            <a href="" >Accueil</a>
          </li>
          <li class="breadcrumb-item active"> Liste des ménages</li>
        </ol>

        <div class="row">
           <div class="col-md-2">
            <img src="" class="img-rounded" width="120px">
          </div>
          <div class="col-md-10 text-center">
            <h3 style=""></h3>
            <div class="float-right cache">
                <?php include 'dropdown.php'; ?>
              <button type="button" class="btn btn-default btn-sm print" id="apercusCommune"><i class="fa fa-print"></i> Imprimer</button>
              <button class="btn btn-default btn-sm exportCommunes" id="exportCommunes" type="button"><i class="fa fa-download"></i> Exporter en Excel</button>
              <button class="btn btn-default btn-sm exportCommunes" id="exportCommunes" type="button">
                <i class="fa fa-edit"></i> Paramètre </button>
            </div>
          </div>
         </div>
         <br>

        <div class="mb-3">
          <div class="card-bod">

            <?php
            include ('connex.php');
            $req=$bd->query("SELECT*FROM menage INNER JOIN avenue ON menage.idAvenue=avenue.idAvenue;");
            $resultats=$req->fetchALL(PDO::FETCH_ASSOC);
            ?>

            <table class="table table-bordered table-striped table-condensed table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>Numéro</th>
<th>Responsable du menage</th>
<th>Numero Police</th>
<th>Avenue</th>
<th>Nombre</th>
<th>#</th>
</tr>
</thead>
<tbody>
<?php
$counter = 1;
foreach($resultats as $res) {
    $reqstats = $bd->prepare("
        SELECT
            COUNT(*) AS totalMembres
        FROM membre
        WHERE idMenage = :idmenage
    ");
    $reqid = $res['idMenage'];
    $reqstats->execute(['idmenage' => $reqid]);
    $nombres = $reqstats->fetch(PDO::FETCH_ASSOC);
?>
<tr>
    <td><?php echo $counter++; ?></td>
    <td><?php echo $res['nomResponsable']?></td>
    <td><?php echo $res['nombreMembre']?></td>
    <td><?php echo $res['Designation']?></td>
    <td><?= $nombres['totalMembres'] ?? 0 ?></td>
    <td><a href="./MembreAjout.php?idMenage=<?= $res['idMenage'] ?>">➕ Ajouter</a></td>
</tr>

                    <?php }?>
                </tbody>
            </table>

            <p>AJOUTER UN MENAGE</p>

            <form method="POST" action="">
                <div>
                    <label>Selectionnez l'avenue</label>
                    <select name="idAvenue" id="idAvenue" class="idAvenue" required>
                        <option value="">-- Choisir --</option>
                        <?php
                        $req1=$bd->query("SELECT*FROM avenue");
                        $resultats1=$req1->fetchALL(PDO::FETCH_ASSOC);
                        foreach ($resultats1 as $ave) {
                        ?>
                        <option value="<?php echo $ave['idAvenue']; ?>">
                            <?php echo $ave['Designation']; ?>
                        </option>
                        <?php }?>
                    </select>
                </div>
                <div>
                    <label>Responsable du menage</label>
                    <input type="text" name="nomResponsable" required>
                </div>
                <div>
    <label>Numero Police</label>
    <input type="text" name="nombreMembre" id="nombreMembre" readonly>
</div>

                <div>
                    <button type="submit" name="enregistrer"><i class="fa fa-save"></i> Enregistrer</button>
                </div>
            </form>

            <div id="graphiqueCommune"></div>
            <div id="graphiqueHFCommune1"></div>
            <div id="graphiqueNatEtr"></div>

          </div>
        </div>
      </div>
    </div>

    <?php include('footerList.php'); ?>
<script type="text/javascript">

    function addData(idquartier){
        $.ajax({
            type:'post',
            url: 'graphiqueQuartier.php',
            data : { idquartier : idquartier},
            success : function(data){
                $("#wrapper").html(response);
            }
        })
    }

    // génération du numéro de police
    $(document).ready(function() {
        $('#idAvenue').on('change', function() {
            var idAvenue = $(this).val();

            if(idAvenue) {
                $.ajax({
                    url: 'add_np.php',
                    type: 'POST',
                    data: { idAvenue: idAvenue },
                    success: function(response) {
                        $('#nombreMembre').val(response);
                    },
                    error: function() {
                        alert("Erreur de connexion ");
                    }
                });
            }
        });
    });
</script>

    <?php
if(isset($_POST['enregistrer'])){
    $nomResponsable=$_POST['nomResponsable'];
    $nombreMembre=$_POST['nombreMembre'];
    $idAvenue=$_POST['idAvenue'];
    $db=mysqli_connect("127.0.0.1","root","","mydb");
    //$req;

    if ($db->query('INSERT INTO Menage(nomResponsable,nombreMembre,idAvenue)
        VALUES("'.$nomResponsable.'","'.$nombreMembre.'","'.$idAvenue.'")')) {
        echo"Enregistrer avec succès";
         echo"<meta http-equiv='refresh' content='0;url=Menage'>";
    } else {
        echo"Echec d'enregistrement";
    }
}
?>
