<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Connexion</title>
  <meta charset="utf-8" />
  <meta name="author" content="RAJAONARISON Clairmont" />
  <meta lang="fr" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/style.css" />
  <script type="text/javascript" src="<?= base_url()?>assets/js/jQuery.js" ></script>
</head>
<body>
<div class="container-fluid" id="container">
<h3 style="text-align:center;color:rgba(255 , 0 , 0 , .5);"><?= $this->session->flashdata("Error");?></h3>
  <form class="form-horizontal" method="post" action="<?= base_url()?>authentification/validation">
      <div class="form-group">
          <h1>Connexion</h1>
          <label for="pseudo" class="col-sm-4 control-label">Nom d'utilisateur</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Nom d'utilisateur">
            <span class="text-danger"><?php echo form_error('pseudo')?></span>
          </div>
        </div>
        <div class="form-group">
          <label for="mdp" class="col-sm-4 control-label">Mot de passe</label>
          <div class="col-sm-6">
            <input type="password" class="form-control" name="password" id="mdp" placeholder="Password">
            <span class="text-danger"><?php echo form_error('password')?></span>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-8">
            <div class="checkbox">
              <label>
                <input type="checkbox">Se souvenir de moi
              </label>
            </div>
          </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-8">
            <button type="submit" class="btn btn-primary">SE CONNECTER&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-log-in"></span></button>
          </div>
        </div>
  </form>

</div>
</body>
</html>
