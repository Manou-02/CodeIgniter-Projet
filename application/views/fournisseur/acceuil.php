<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <title>FOURNISSEUR</title>
  <meta charset="utf-8" />
  <meta name="author" content="RAJAONARISON Clairmont" />
  <meta lang="fr" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/Chart/Chart.css" />
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
  <div class="container">
  <div class="list-group">
    <h1 style="color: brown;text-align: center" >SECTION FOURNISSEUR</h1>
        <div class="list-group-item" style="margin-bottom :20px;">
          <h1 class="list-group-item-heading" style="text-align: center;color:#717375">Résumé :</h1>
          <p class="list-group-item-text" style="font-size: 20px;">Nos fournisseurs actuels sont au nombre de <strong class="client" style="color: blue"></strong>. Les fournisseurs sont des elements importants pour que nos produits soient toujours de premier qualité et que l'on puisse donner à nos clients des produits avec un large gamme de choix.</p>
        </div>
    </div>
  <div class="jumbotron">
    <h3>Liste des fournisseurs</h3>
      <h5 style="text-align: center;" class="alert"></h5>
    <div id="tableau"></div>
    <nav style="text-align: center;">
            <ul class="pagination"> 
            </ul>
          <ul class="pager">
           <li><button class="btn btn-info" id="add">Ajouter un fournisseur maintenant <span class="glyphicon glyphicon-upload" aria-hidden="true"></span></button></li>
            <li><a href="pdf" class="download">Télecharger <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a></li>
          </ul>
      </nav>
      <div class="bg-update" class="alert alert-info alert-dismissible" role="alert" id="update" style="text-indent: 15px;height: 360px"> 
        </div>
      <!-- Modal section -->
        
          <div class="bg-modal" class="alert alert-info alert-dismissible" role="alert" style="text-indent: 15px;height: 360px">
        <button type="button" class="close closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="gb-content">
                <form action="addFournisseur" method="POST" id="myForm">
                    <label for="nom">Nom du fournisseur</label>
                    <input required="req" type="text" class='form-control' id="nom" name="nomFrs">
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
<script type="text/javascript" src="<?= base_url()?>assets/js/fournisseur.js" ></script>
</body>
</html>