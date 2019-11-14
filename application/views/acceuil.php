<?php
defined('BASEPATH') OR exit('No direct script access allowed');


?>
<!DOCTYPE html>
<html>
<head>
  <title>Acceuil</title>
  <meta charset="utf-8" />
  <meta name="author" content="RAJAONARISON Clairmont" />
  <meta lang="fr" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/Chart/Chart.css" />
</head>
<?php include('menu.php'); ?>
<div class="container-fluid">
  <div class="list-group">
  <div class="list-group-item" style="margin-bottom :20px;">
    <h1 class="list-group-item-heading">Resumé de l'état actuel:</h1>
    <p class="list-group-item-text"></p>
  </div>
  <div class="container">
  <div id="dada"></div>
  <h2>Extrait des produits</h2>
  <div id="tableau"></div>
  <nav>
  <ul class="pager">
    <li><a href="<?=base_url()?>produit/" class="download">Voir toute la liste <span class="glyphicon glyphicon-open-file" aria-hidden="true"></span></a></li>

  </ul>
</nav>
<div class="list-group">
  <div class="list-group-item" style="margin-bottom :20px;">
    <p class="list-group-item-text">Nous avons en tout <strong class="countProduit"></strong> dans notre magasin, qui servent à approvisionnés nos clients. Il faut cependant garder un oeil sur la diversité de nos produits pour satisfaire les demandes de ces derniers.</p>
    <p>&nbsp;</p>
    <p class="list-group-item-text">Nous avons aussi <strong class="countCli"></strong> dans notre magasin, qui sont là pour pouvoir s'approvisionner chez nous en matière de produit. Nos clients sont les maîtres alors offrons-leur des sevices digne de ce nom pour les satisfaire au maximum.</p>
    <p>&nbsp;</p>
    <p class="list-group-item-text">Côté fournisseur, on a <strong style="color: red" id="fourni"></strong> au total qui assure la réapprovisionnement de notre magasin. Nous pouvons passer des demandes auprès d'eux dans la section <em style="color: rgba(10,10,200,.75)"> commande auprès d'un fournisseur</em>.</p>
  </div>
  <div class="list-group-item" style="margin-bottom :20px;">
    <h5 style="color: rgba(50,150,200,.9);">Produit en rupture de stock :</h5>
    <table class="table table-bordered">
      <thead>
        <tr>
          <td style="color:#147518;font-weight: bold;">Code du produit</td>
          <td style="color:#147518;font-weight: bold;">Designation du produit</td>
          <td style="color:#147518;font-weight: bold;">Stock</td>
        </tr>
      </thead>
      <tbody>
        
        <?php if(isset($provision)){
          foreach($provision AS $value){
        ?>
        <tr>
          <td>P<?=$value->codePro?></td>
          <td><?=$value->Design?></td>
          <td style="color:red"><?=$value->stock?></td>
        </tr>
        <?php }
        }else{ ?>
            <tr>
              <td colspan="3" style="color:green;text-align: center">Aucun produit n'est en rupture de stock pour le moment</td>
            </tr>
        <?php }?>
        
      </tbody>
    </table>

    <h4 style="text-align: center;"><a href="<?=base_url()?>commande/fournisseur" class="reapprovisionner">Passer une demande de réapprovisionnement dès maintenant</a></h4>
  </div>
  <div>
    <h3>Extrait des chiffres d'affaire</h3>
    <table class="table" id="table"></table>
  </div>
</div>
<div class="media">
  <div class="media-body">
    <h3 class="media-heading" style="text-align: center;color: rgba(200,50,50,.95);">Stock des produits en magasin</h3>

    <p style="font-size: 14px;text-indent: 25px;">Histogramme sur le stock en magasin. Cette histogramme répresente les stocks en magasin de chaque produit. Nous avons donc un histogramme qui réflete le produit occupant le plus de place dans notre stock</p>
  </div>
  <div class="media-right">
      <canvas style="width: 640px;height: 480px" id="myChart1"></canvas>
</div>
</div>
<div class="media">
  <div class="media-left">
      <canvas style="width: 640px;height: 480px" id="myChart2"></canvas>
  </div>
  <div class="media-body">
    <h3 class="media-heading" style="text-align: center;color: rgba(200,50,50,.95);">Echange</h3>
    <p style="font-size: 14px;text-indent: 25px;">Ceci répresente l'ensemble des échanges effectués pour chaque produit: la réapprovisionnement et la vente. Ceci montre donc la balance de notre depense et entrée d'argent. Nous pouvons aussi voir directement quel produit est le plus demandé par nos clients.</p>
  </div>
</div>
</div>
</div>
</div>
<?php
  $data = $chart['data'];
  $backgroundColor = $chart['bgcolor'];
  $label = $chart['label'];

  $design = $exchange['design'];
  $vente = $exchange['com'];
  $appro = $exchange['appro'];
  
?>
<script type="text/javascript" src="<?= base_url()?>assets/js/jQuery.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/bootstrap.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/search.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/ajax.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/Chart/Chart.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/Chart.js" ></script>
<script type="text/javascript">
  var ctx = document.getElementById('myChart1').getContext('2d');
var ctx2 = document.getElementById('myChart2').getContext('2d');

var data = {
        labels : [<?=$label?>],
        datasets: [{
            label: 'Stock en magasin (Kg) ',
            data: [<?=$data?>],
      backgroundColor: 'rgba(0,0,0,.15)',
      borderColor: [<?= $backgroundColor ?>],
            borderWidth: 3
        }]
    };

var data2 = {
        labels : [<?= $design?>],
        datasets: [{
            label: 'Vente (Kg) ',
            data: [<?= $vente ?>],
      backgroundColor: 'rgba(0,0,0,.5)',
            borderWidth: 2
        },{
            label: 'Réapprovisionnement (Kg)',
            data: [<?= $appro ?>],
      backgroundColor: 'rgba(0,0,100,.5)',
            borderWidth: 2
        }]
    };
create(ctx , 'line' , data);
create(ctx2 , 'bar', data2);
//Si on veut avoir une double graphique, il faut la mettre dans le dataset

setInterval(function(){
create(ctx , 'line' , data);
create(ctx2 , 'bar',data2);
} , 10000);
</script>
</body>
</html>