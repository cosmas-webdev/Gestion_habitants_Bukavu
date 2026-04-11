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
          <li class="breadcrumb-item active"> Liste des quartiers</li>


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
                    $req=$bd-> query ("SELECT * FROM `quartier` INNER JOIN commune ON quartier.idcommune=commune.idcommune;");
                    $resultats=$req->fetchALL(PDO::FETCH_ASSOC);

                   ?>

                        <table class="table table-bordered table-striped table-condensed table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Désignations</th>
                                    <th>ChefQuartier</th>
                                    <th>PW</th>
                                    <th>Commune</th>

                                </tr>
                            </thead>
                            <tbody>
                                   <?php
                                   $counter = 1;
                                   foreach($resultats as $res) {
                                   ?>
                                   <tr>
                                    <td><?php echo $counter++; ?></th>
                                    <th><?php echo $res['DesignationQ']?></th>
                                    <th><?php echo $res['chefQuartier']?></th>
                                     <th><?php echo $res['pwQ']?></th>
                                     <th><?php echo $res['designationc']?></th>
                                   <th> </th>
                                  </tr>
                                  <?php }?>
                            </tbody>
                        </table>
                             <p>AJOUTER UN QUARTIER</p>
                             <div class="mb-3">
                                <form action="" method="POST">

                                    <div>
                                      <label>Désignation du quartier  </label>
                                       <input type="texte" name="DesignationQ">
                                   </div>
                                   <div>
                                    <label>Nom du Chef de quartier</label>
                                       <input type="texte" name="chefQuartier">
                                   </div>
                                   <div>
                                    <label>Mot de passe</label>
                                       <input type="texte" name="pwQ">
                                   </div>
                                   <div>
                                    <label>Selection la commune</label>
                                       <select name="idcommune">
                                        <option value="1">Ibanda</option>
                                        <option value="2">Kadutu</option>
                                        <option value="3">Bagira</option>
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
    <?php
    if(isset($_POST['enregistrer'])){// si on appuie sur le boutton enregistrer
        $DesignationQ=$_POST['DesignationQ'];
        $chefQuartier=$_POST['chefQuartier'];
        $pwQ=$_POST['pwQ'];
        $idcommune=$_POST['idcommune'];
        $db=mysqli_connect("127.0.0.1","root","","mydb");
        //$req;

    if ($db->query('INSERT INTO quartier (DesignationQ,chefQuartier,pwQ,idcommune)
        VALUES("'.$DesignationQ.'","'.$chefQuartier.'","'.$pwQ.'","'.$idcommune.'")')) {
        echo"Enregistrer avec succès";
         echo"<meta http-equiv='refresh' content='0;url=quartier'>";
    } else {
        echo"Echec d'enregistrement";
    }
    }


    ?>
