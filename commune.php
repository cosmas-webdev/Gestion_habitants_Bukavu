<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- la variable $title recupèrera le titre de la page encours -->
  <title>Mairie</title>
<!-- Favicons -->
  <link href="./../img/favicon.png" rel="icon">
  <link href="./../img/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">



  <!-- Bootstrap core CSS POUR LE DROP DOWN-->
  <link href="./lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->

  <link href="load.css" rel="stylesheet">
  <!-- FIN POUR LE TEMOIN D'OCCUPATION-->
  <script src="https://www.gstatic.com/charts/loader.js"></script>

  <!-- AFFICHE LE GRAPHIQUE GENERAL -->

</head>

<body id="page-top">

   <div id="wrapper">

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
         <!-- Breadcrumbs-->
        <ol class="breadcrumb cache">
          <li class="breadcrumb-item">
            <a href="" >Accueil</a>
          </li>
          <li class="breadcrumb-item active"> Liste des Communes</li>


        </ol>
         <!-- Breadcrumbs-->
        <div class="row">

           <div class="col-md-2">
            <img src="" class="img-rounded" width="120px">
          </div>
          <div class="col-md-10 text-center">
            <h3 style=""></h3>
            <div class="float-right cache">
                <!--  AJOUTER LE DROP DOWN POUR LE FILTRE -->
                <?php  include 'dropdown.php'; ?>
              <button type="button" class="btn btn-default btn-sm print" id="apercusCommune"><i class="fa fa-print"></i> Imprimer</button>
              <button class="btn btn-default btn-sm exportCommunes" id="exportCommunes" type="button"><i class="fa fa-download"></i> Exporter en Excel</button>
              <button class="btn btn-default btn-sm exportCommunes" id="exportCommunes" type="button">
                <i class="fa fa-edit"></i> Paramètre </button>

            </div>
          </div>

         </div>
         <br>

        <!-- DataTables Example -->

       <div class="mb-3">

          <div class="card-bod">

                    <?php
                    include ('connex.php');
                    $req=$bd-> query ("SELECT*FROM commune");
                    $resultats=$req->fetchALL(PDO::FETCH_ASSOC);

                   ?>

                        <table class="table table-bordered table-striped table-condensed table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Désignations</th>
                                    <th>Bourgoumestre</th>
                                    <th>PW</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                   <?php
                                   $counter = 1;
                                   foreach($resultats as $res) {
                                   ?>
                                   <tr>
                                    <td><?php echo $counter++; ?></th>
                                    <th><?php echo $res['designationc']?></th>
                                    <th><?php echo $res['bourgmestre']?></th>
                                    <th><?php echo $res['pwCommune']?></th>
                                    <th><?php echo $res['idmairie']?></th>

                                   <th> </th>
                                  </tr>
                                  <?php }?>
                            </tbody>
                        </table>
<p>AJOUTER UNE COMMUNE</p>
                             <div class="mb-3">
                                <form action="" method="POST">

                                    <div>
                                      <label>Désignation de la commune </label>
                                       <input type="texte" name="designationc">
                                   </div>
                                   <div>
                                    <label>Nom du bourgoumestre</label>
                                       <input type="texte" name="bourgmestre">
                                   </div>
                                   <div>
                                    <label>Mot de passe</label>
                                       <input type="texte" name="pwCommune">
                                   </div>
                                   <div>
                                    <label>Selectionne la mairie concerné</label>
                                       <select name="idmairie" id="idmairie" class="idmairie" required>
                        <option value="">-- Choisir --</option>
                        <?php
                        $req1=$bd->query("SELECT*FROM mairie");
                        $resultats1=$req1->fetchALL(PDO::FETCH_ASSOC);
                        foreach ($resultats1 as $ave) {
                        ?>
                        <option value="<?php echo $ave['idmairie']; ?>">
                            <?php echo $ave['designationm']; ?>
                        </option>
                        <?php }?>
                    </select>
                </div>
<div>
                                      <button type="submit" name="enregistrer" ><i class="fa fa-save"> </i></button>
                                      </div>
                    <p></p>

 <!--FIN ZONE DE LISTE DEROULANTE POUR FILTRER -->
                        <div id="graphiqueCommune" ></div>
                        <div id="graphiqueHFCommune1"></div>

                        <div id="graphiqueNatEtr"></div>

             </div>
            <!-- /content-panel -->


  			 </div>
   		</div>

      <!-- Sticky Footer contient les scripts de gestion du tableau-->
      <?php include('footerList.php'); ?>
    <script type="text/javascript">
         function addData(idquartier){
        //$('#province').html('');
        //$('#diocese').html('<option>Select Diocèse</option>');
        $.ajax({
          type:'post',
          url: 'graphiqueQuartier.php',
          data : { idquartier : idquartier},
          success : function(data){
            $("#wrapper").html(response);
          }

        })
      }

    </script>
    /script>
    <?php
    if(isset($_POST['enregistrer'])){// si on appuie sur le boutton enregistrer
        $designationc=$_POST['designationc'];
        $bourgmestre=$_POST['bourgmestre'];
        $pwCommune=$_POST['pwCommune'];
        $idmairie=$_POST['idmairie'];
        $db=mysqli_connect("127.0.0.1","root","","mydb");
        //$req;

    if ($db->query('INSERT INTO commune(designationc,bourgmestre,pwCommune,idmairie)
        VALUES("'.$designationc.'","'.$bourgmestre.'","'.$pwCommune.'","'.$idmairie.'")')) {
        echo"Enregistrer avec succès";
         echo"<meta http-equiv='refresh' content='0;url=Avenue'>";
    } else {
        echo"Echec d'enregistrement";
    }
    }
