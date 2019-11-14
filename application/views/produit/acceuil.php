<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Produit</title>
  <meta charset="utf-8" />
  <meta name="author" content="RAJAONARISON Clairmont" />
  <meta lang="fr" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.css" />
</head>
<style type="text/css">
#update{
  display: none;
  width: 500px;
  text-align: center;
  margin:10px auto;
}
  .bg-modal{
    width: 70%;
    height: 65%;
    opacity: .75;
    display:none;
    margin: 0px auto;
    justify-content: center;
    align-items: center;
  }
  .bg-modal input{
    margin: 10px 0px;
  }
  .gb-content{
      width: 400px;
      height: 250px;
      margin: 25px auto 0px auto;
      border-radius: 4px;
      background-color: white;
      opacity: .75;
      text-align: center;
      padding: 15px;
  }
  .closed{
    text-align: right;
    font-size: 40px;
    display: inline-block;
    margin: 0px;
    cursor: pointer;
  }
</style>
<body>
<div class="container-fluid">
  <div class="list-group">
    <h1 style="color: brown;text-align: center" >SECTION PRODUIT</h1>
        <div class="list-group-item" style="margin-bottom :20px;">
          <h1 class="list-group-item-heading" style="text-align: center;color:#717375">Produit dans le magasin :</h1>
          <p class="list-group-item-text">Nous avons actuellement <strong class="client"></strong> produit(s).</p>
        </div>
  <div class="container">

      <h5 style="text-align: center;" class="alert"></h5>
      <div id="tableau"></div>
      <nav style="text-align: center;">
            <ul class="pagination">
             
            </ul>
          <ul class="pager">
           <li><a href="#add" class="download">Ajouter un produit <span class="glyphicon glyphicon-upload" aria-hidden="true"></span></a></li>
            <li><a href="pdf" class="download">Télecharger <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a></li>
          </ul>
      </nav>
      <!--Modal section update-->
<div class="bg-update" class="alert alert-info alert-dismissible" role="alert" id="update" style="text-indent: 15px;height: 360px">
        
        </div>
      <div class="alert alert-info alert-dismissible" role="alert" style="text-indent: 15px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Info !</strong> Par défaut, l'ordre d'affichage est celui de l'insertion dans la chronologie descandant qui est basé sur l'ordre de code du produit. Donc les plus recents seront afficher en premier. Vous pouvez cependant afficher les resultats de manière descandant ou ascendant en fonction d'une colonne. Cliquez sur la colonne correspondante pour une affichage descandante et double clique pour l'ascendante.
      </div>
          <div class="alert alert-info" role="alert"><strong style="color: blue">Simple clique: </strong>affichage descendante</br><strong style="color: blue">Double clique: </strong>affichage ascendante</div>

    </div>
    </div>
    <div class="list-group" style="line-height: 25px;background-color: grey;margin: 0px auto;width: 900px">
        <div class="list-group-item" style="width: 750px;margin: 0px auto">
          <h1 class="list-group-item-heading" style="text-align: center;color:#717375">Ajout d'un nouveau produit :</h1>
          <p><span class="glyphicon glyphicon-star"></span><strong>Tips :</strong></p>
          <p class="list-group-item-text">Garder en tête le fait que plus on a des produits diversifiés, plus les clients passeront des nouveaux commandes.</p>
          <p>Enregistrez un nouveau produit, faites-en une demande d'approvisionnement auprès d'un fournisseur pour avoir suffisament de stock quand les clients vont passer les commandes.</p>
          <p>Vous n'avez besoin que de deux choses, le <strong>designation</strong> et le <strong>prix unitaire</strong> du produit à ajouter.</p>
          <p><button class="btn btn-info" id="add">Ajouter un produit maintenant</button></p>
        </div>
<!-- Modal section ajout-->
        
          <div class="bg-modal" class="alert alert-info alert-dismissible" role="alert" style="text-indent: 15px;height: 360px">
        <button type="button" class="close closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="gb-content">
                <form action="addProduit" method="POST" id="myForm">
                    <label for="design">Designation du produit</label>
                    <input required="req" type="text" class='form-control' id="design" name="design">
                    <label for="prix">Prix unitaire (Ar) :</label>
                    <input required="req" id='prix' class='form-control' min='0' type="number" name="prix">
                    <button class="btn btn-success" id="save">SAUVEGARDER <span class="glyphicon glyphicon-save"></span></button>
                </form>
            </div>
        </div>
    </div>
    <div class="media"> 
  <div class="media-body" style="background-color: white">
    <h3 class="media-heading" style="text-align: center;">Produit le plus commandé</h3>
    <p style="text-align: center;padding: 10px;margin: 10px;background-color: rgba(0,0,150,.25);cursor: pointer;">Cette section montre le nombre de commande passé pour chaque produit. Cela réflete donc quel produit est le plus demandé par les clients et qu'il faut qu'on augmente le réapprovisionnement afin ne pas être en rupture de stock pour un produit qui satisfait nos clients.<br><em style="color: rgb(200,75,75)">Les cercles interieurs répresentent les nombres des commandes passés alors que ceux à l'exterieur sont ceux de la quantité.</em></p>
  </div>
  <div class="media-body">
      <canvas id="myChart"></canvas>
  </div>
</div>
</div>
<?php
$design = $most['design'] ;
$number = $most['com'];
$qte = $most['qte'];
$bg = $most['bg'];
$bg1 = $most['bg1'];
?>
<script type="text/javascript" src="<?= base_url()?>assets/js/jQuery.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/bootstrap.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/produit.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/Chart.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/Chart/Chart.js" ></script>

<script type="text/javascript">
  var chart = document.getElementById("myChart");

var data = {
        labels : [<?=$design?>],
        datasets: [{
            label: 'Somme des quantités commandés',
            data: [<?= $qte?>],
        backgroundColor: [<?= $bg?>],
        borderWidth: 1
        } , 
        {
            label: 'Nombre de commandes passé ',
            data: [<?= $number?>],
            backgroundColor: [<?=$bg?>],
            borderWidth: 1
        }]
    };

  create(chart , 'pie' , data);
/*
    'Bar',
    'Bubble',
    'Doughnut',
    'Line',
    'PolarArea',
    'Radar',
    'Scatter'
*/
</script>
</body>
</html>
