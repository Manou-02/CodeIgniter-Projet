<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Client</title>
  <meta charset="utf-8" />
  <meta name="author" content="RAJAONARISON Clairmont" />
  <meta lang="fr" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/Chart/Chart.css" />
</head>
<style type="text/css">
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
  #update{
  display: none;
  width: 500px;
  text-align: center;
  margin:10px auto;
}
</style>
<body>
<div class="container">
	<div class="list-group">
    <h1 style="color: brown;text-align: center" >SECTION CLIENT</h1>
        <div class="list-group-item" style="margin-bottom :20px;">
          <h1 class="list-group-item-heading" style="text-align: center;color:#717375">Résumé :</h1>
          <p class="list-group-item-text" style="font-size: 20px;">Notre clientèle actuel est au nombre de <strong class="client" style="color: blue"></strong>. Plus nous aurons beaucoup de client plus on a la chance d'augmenter notre chiffre d'affaire. La section chiffre d'affaire en bas montre les dépenses effectués par chaque client auprès de notre magasin. Chaque client est répertorié par son nom, son code client et son adresse, trié par code client.</p>
          <p class="list-group-item-text" style="font-size: 20px;">Garder en tête aussi que la diversité de nos produits encouragent les clients à s'approvisionner chez nous. Pour accéder a la section produit, cliquez <a href="<?=base_url()?>produit/">ici</a></p>
        </div>
    </div>
    <div class="panel panel-success" style="font-size: 18px">
		<div class="panel-heading">Chiffre d'affaire pour chaque client</div>
		<div class="panel-body">
		    <p>Le chiffre d'affaire répresente lequel des clients a le plus contribué à notre magasin. Ceci est un element important par exemple si on decide de faire une petite remise pour les clients ayant dépassées une certaine chiffre.</p>
		</div>
		<table class="table"></table>

	</div>
	<div class="jumbotron" style="height: 500px;margin-bottom: 10px;padding-bottom: 10px;">
	  <h3>Chiffre d'affaire en graphique</h3>
	  <div style="width: 640px;height: 480px;"><canvas id="myChart"></canvas><a class="btn btn-primary btn-fr" href="<?=base_url()?>commande/client" role="button">En savoir plus</a></div>
	</div>
	<div class="jumbotron">
	  <h3>Liste des clients</h3>
      <h5 style="text-align: center;" class="alert"></h5>
	  <div id="tableau"></div>
	  <nav style="text-align: center;">
            <ul class="pagination">
              
            </ul>
          <ul class="pager">
           <li><button class="btn btn-info" id="add">Ajouter un client maintenant <span class="glyphicon glyphicon-upload" aria-hidden="true"></span></button></li>
            <li><a href="pdf" class="download">Télecharger <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a></li>
          </ul>
      </nav>

<!--Modal section update-->
<div class="bg-update" class="alert alert-info alert-dismissible" role="alert" id="update" style="text-indent: 15px;height: 360px">
        
        </div>

      <!-- Modal section -->
        
          <div class="bg-modal" class="alert alert-info alert-dismissible" role="alert" style="text-indent: 15px;height: 360px">
        <button type="button" class="close closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="gb-content">
                <form action="addClient" method="POST" id="myForm">
                    <label for="nom">Nom du client</label>
                    <input required="req" type="text" class='form-control' id="nom" name="nom">
                    <label for="adresse">Adresse :</label>
                    <input required="req" id='adresse' class='form-control' type="text" name="adresse">
                    <button class="btn btn-success" id="save">SAUVEGARDER <span class="glyphicon glyphicon-save"></span></button>
                </form>
            </div>
        </div>
	</div>
	
</div>
</body>
<script type="text/javascript" src="<?= base_url()?>assets/js/jQuery.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/bootstrap.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/client.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/Chart/Chart.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/Chart.js" ></script>
<script type="text/javascript">
		var chart = document.getElementById("myChart");
		var data = {
				labels : [<?=$data['nom']?>],
		        datasets: [
		        {
		            label: 'Chiffre d\'affaire ',
		            data: [<?= $data['chiffre']?>],
		            backgroundColor: [<?=$data['bgcolor']?>],
		            borderWidth: 1
		        }]
    };
  create(chart , 'doughnut' , data);

  setInterval(function(){
  	create(chart , 'doughnut' , data)} , 5000);


</script>
</html>
