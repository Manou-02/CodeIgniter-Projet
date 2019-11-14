<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Commande</title>
  <meta charset="utf-8" />
  <meta name="author" content="RAJAONARISON Clairmont" />
  <meta lang="fr" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/Chart/Chart.css" />
</head>
<body>
	<div class="container">
		<div class="list-group">
    		<h1 style="color: brown;text-align: center" >SECTION COMMANDE</h1>
        <div class="list-group-item" style="margin-bottom :20px;">
        	<p>Ici s'affiche la liste des 10 ventes et réapprovisionnements récements effectués. Cette section affiche uniquement ces informations pour donner un aperçu sur la balance du magasin.</p>
        </div>
    </div>
    <div class="list-group">
    	<h3>Liste des commandes passés par les clients</h3>
		<div class="list-group-item" style="margin-bottom :20px;">
			<table class="table table-bordered" id="clie"></table>
		</div>

    </div>
    <div class="list-group">
    	<h3>Liste des réapprovisionnements passés au fournisseur</h3>
    	<div class="list-group-item" style="margin-bottom :20px;">
    		<table class="table table-bordered" id="fourniss"></table>
    	</div>
    </div>
	</div>
</body>
<script type="text/javascript" src="<?= base_url()?>assets/js/jQuery.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/bootstrap.js" ></script>
<script type="text/javascript">
function clientListe()
{
	let XHR = new XMLHttpRequest();

	XHR.open("GET" , 'vente');

	XHR.onreadystatechange = function(){
		if(XHR.readyState == 4 && XHR.status == 200)
		{
			let response = JSON.parse(XHR.responseText);
			let html = response.map(function(vente){
				return `<tr>
							<td>${vente.nomCli}</td>
							<td>${vente.design}</td>
							<td>${vente.qteCom}</td>
							<td>${vente.dates}</td>
						</tr>`;
			}).join("");

			let content = `<tr>
							<th>Nom du client</th>
							<th>Designation du produit</th>
							<th>Quantité commandée</th>
							<th>Date de la commande</th>
						</tr>
							`;
			content += html;

			let table = document.querySelector('#clie');

			table.innerHTML = content;
		}
	}
	XHR.send();
}

function fournisseurListe()
{
	const XHR = new XMLHttpRequest();

	XHR.open("GET" , 'reapprovisionnement');

	XHR.onreadystatechange = function(){
		if(XHR.readyState == 4 && XHR.status == 200)
		{
			let response = JSON.parse(XHR.responseText);
			const html = response.map(function(vente){
				return `<tr>
					<td>${vente.nomFrs}</td>
					<td>${vente.design}</td>
					<td>${vente.qteAppro}</td>
					<td>${vente.dates}</td>
				</tr>
				`
			}).join("");

			let content = `<tr>
							<th>Nom du fournisseur</th>
							<th>Designation du produit</th>
							<th>Quantité approvisionnée</th>
							<th onclick='alert(10)'>Date de la commande</th>
						</tr>
							`
			content += html;

			let table = document.querySelector('#fourniss');
			table.innerHTML = content;
		}
	}
	XHR.send();
}

clientListe();
fournisseurListe();
setInterval(function(){
	clientListe();
	fournisseurListe();
} , 4000);



</script>
</body>
</html>