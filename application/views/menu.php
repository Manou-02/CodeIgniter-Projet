<style type="text/css">
  .tog{
    color: rgba(144,255,235,.75);
  }
  .carousel-caption {
  font-family : 'Arial';
  font-size : 30px;
}

</style>
<nav class="navbar navbar-inverse navbar-fixed-top" style="font-weight:bold;margin:0px 0px">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#" style="font-family:'comic sans MS';background-color:darkgrey;color:rgba(0,0,0,.25)"><strong>GestionApp v1.0</strong></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?=base_url()?>authentification/"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Acceuil<span class="sr-only"></span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu principal<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>client/"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Client&nbsp;&nbsp;<span class="badge" id="client"></span></a></li>
            <li><a href="<?=base_url()?>fournisseur/"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Fournisseur&nbsp;&nbsp;<span class="badge" id="fournisseur"></span></a></li>
            <li><a href="<?=base_url()?>produit/"><span class="glyphicon glyphicon-leaf"></span>&nbsp;&nbsp;Produit&nbsp;&nbsp;<span class="badge" id="produit"></span></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?=base_url()?>commande/acceuil"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Commande</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?=base_url()?>commande/fournisseur"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Commander auprès d'un fournisseur</a></li>
            <li><a href="<?=base_url()?>commande/client"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Commande de client</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" id="search">
        </div>
        <button type="submit" class="btn btn-primary" id="btn-search">Search</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;<?=$this->session->pseudo?>&nbsp;&nbsp;<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <!--<li><a href="<?= base_url()?>authentification/delete">Supprimer ce compte&nbsp;&nbsp;<span class="glyphicon glyphicon-trash"></sapn></a></li>-->
            <li><a href="<?= base_url()?>authentification/logout">Se déconnecter&nbsp;&nbsp;<span class="glyphicon glyphicon-off"></sapn></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div id="result" style="background-color:rgba(100, 100 , 100 , 0.75);font-size:16px;margin-top:0px;text-align:center"></div>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="margin-bottom:40px;">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
   <!--
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="<?=base_url()?>assets/images/img1.jpg" alt="Image" style="height: 500px;width:100%">
      <div class="carousel-caption">
        <h1>N'attendez plus demain pour prendre votre décision !</h1>
      </div>
    </div>
    <div class="item">
      <img src="<?=base_url()?>assets/images/img2.jpg" alt="Image" style="height: 500px;width:100%">
      <div class="carousel-caption">
        <h1>Vivez à fond avec nous !</h1>
      </div>
    </div>
    <div class="item">
      <img src="<?=base_url()?>assets/images/img3.jpg" alt="Image" style="height: 500px;width:100%">
      <div class="carousel-caption">
        <h1>Fort comme vous</h1>
      </div>
    </div>
  </div>
-->
  <!-- Controls -->
  
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<script type="text/javascript" src="<?=base_url()?>assets/js/compte.js"></script>