<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Inscription</title>
  <meta charset="utf-8" />
  <meta name="author" content="RAJAONARISON Clairmont" />
  <meta lang="fr" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/style.css" />
  <script type="text/javascript" src="<?= base_url()?>assets/js/jQuery.js" ></script>
</head>
<body>
<div class="container-fluid" id="container">
<form class="form-horizontal" method="post" action="<?= base_url()?>authentification/registration" id="myForm">
      <div class="form-group">
          <h1>Inscription</h1>
          <h4 class="state" style="color: rgba(250 , 120 , 120 , 1);"></h4>
          <label for="nom" class="col-sm-4 control-label">Nom</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="nom" name="nom" placeholder="6 caractères minimum">
            <span class="text-danger"><?php echo form_error('nom')?></span>
          </div>
        </div>
        
        
        <div class="form-group">
          <label for="user" class="col-sm-4 control-label">Nom d'utilisateur</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="user" id="user" placeholder="6 caractères minimum">
            <span class="text-danger"><?php echo form_error('pseudo')?></span>
          </div>
        </div>
        <div class="form-group">
          <label for="mail" class="col-sm-4 control-label">Adresse électronique</label>
          <div class="col-sm-6">
            <input type="mail" class="form-control" name="email" id="mail" placeholder="Mail">
            <span class="text-danger"><?php echo form_error('e-mail')?></span>
          </div>
        </div>

        <div class="form-group">
                  <label for="mdp" class="col-sm-4 control-label">Mot de passe</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="6 caractères minimum">
                    <span class="text-danger"><?php echo form_error('password')?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="confirm" class="col-sm-4 control-label">Confirmez votre mot de passe</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" name="confirm" id="confirm" placeholder="6 caractères minimum">
                    <span class="text-danger"><?php echo form_error('confirm')?></span>
                  </div>
                </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-8">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="contract">J'ai lu et j'accepte les termes de contrat de confidentialité
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-8">
            <button type="submit" class="btn btn-primary">S'INSCRIRE</button>
          </div>
        </div>
  </form>

</div>
<script type="text/javascript">

  function register(){

    var data = document.getElementById('myForm');
    data.addEventListener('submit' , function(e){
          e.preventDefault();
          var form = new FormData(data);
          XHR = new XMLHttpRequest();
          XHR.open("POST" , '<?= base_url()?>authentification/registration');
          XHR.onreadystatechange = function(){

            if(XHR.status == 200 && XHR.readyState == 4)
            {
              var html = XHR.responseText;
            }
            var etat = document.querySelector(".state");
            etat.innerHTML = html;
          }
          XHR.send(form);
    })

  };

  register();
</script>
</body>
</html>
