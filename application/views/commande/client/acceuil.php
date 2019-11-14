<?php
defined('BASEPATH') OR exit('No direct script access allowed');


?>
<!DOCTYPE html>
<html>
<head>
  <title>Commande Client</title>
  <meta charset="utf-8" />
  <meta name="author" content="RAJAONARISON Clairmont" />
  <meta lang="fr" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/Chart/Chart.css" />
</head>
<style>
    #tab td , #tab th{
        text-align:center;
    }
</style>
<div class="container">
	<div class="list-group">
    <h1 style="color: brown;text-align: center" >SECTION COMMANDE CLIENT</h1>
        <div class="list-group-item" style="margin-bottom :20px;">
          <h1 class="list-group-item-heading" style="text-align: center;color:#717375">Passer une commande :</h1>
          <div class="alert alert-info alert-dismissible" role="alert" style="text-indent: 15px;">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>Ici, vous pouvez enregistrer une vente ou commande d'un client directement. Vous pouvez aussi lister la liste des ventes classées par produit ou par date, et bien plus encore, vous pouvez les exorter 
            au <strong>format PDF</strong>    
            pour réaliser par exemple des rapports.</p>
            
        </div>
        </div>
    </div>
    <div>
        <form action="commander" method="POST" id="form">
        <table class="table table-bordered"  style="text-align:center" id="tab">
            <tr>
                <th>Client</th>
                <th>Produit à commander</th>
                <th>Quantité</th>
                <th>Ajouter</th>
            </tr>
            <tr>
                <td><input type="text"  style="width:70%" name="client" required></td>
                <td>
                    <select style="width:70%" class="select-produit" name="selected" required></select>
                </td>
                <td><input type="number" min="0" name="qte" required></td>
                <td><a href="#" class='ajouter'><span class="glyphicon glyphicon-plus"></span></a></td>
            </tr>    
        </table>
        <div style="text-align:center;">
            <button class="btn btn-default" class="commander">COMMANDER et REDIGER LA FACTURE <span class="glyphicon glyphicon-console" aria-hidden="true"></span></button></td>
        </div>
        </form>
    </div>
        <h3 style="text-align: center;"><?= $this->session->insert?></h3>
    <div style="border: 2px solid black;padding: 10px;" >
<?php


        if(isset($facture)){ 
           
            function separateur($ds)
            {
                $chiffre = '';
                $count = strlen($ds);
                $i = 0;
                    if($count % 3 == 0)
                        do{
                                $chiffre .= substr($ds, $i , 3).".";
                                $count -= 3;
                                $i += 3;
                            }
                            while($count > 0);
                    
                    else if($count % 3 == 2)
                        {
                            $chiffre .= substr($ds, $i , 2).".";
                            $i+= 2;
                            do{
                                $chiffre .= substr($ds, $i , 3).".";
                                $count -= 3;
                                $i += 3;
                            }
                            while($count > 0);
                        }
                    else if($count % 3 == 1)
                        {
                            $chiffre .= substr($ds, $i , 1).".";
                            $i = 1;
                            do{
                                $chiffre .= substr($ds, $i , 3).".";
                                $count -= 3;
                                $i += 3;
                            }
                            while($count > 0);
                                
            }
        echo rtrim($chiffre , ".");
}
    ?>

<table style="width:800px;margin-top: 35px;">
    <tr>
            <th style="width:90%">Client : <span style="font-weight: normal;"><?=$facture[0]->nomCli?></span></th>
            <th style="text-align: right;">Magasin :</th>
    </tr>
    <tr>
        <td>Adresse : <?=$facture[0]->adresse?></td>
    </tr>
</table>
<table style="margin-top: 100px;width: 100%">
    <tr>
        <th style="width:75%">Facture N° : <?=$facture[0]->numfact?></th>
        <th style="width: 25%">Date : <span style="font-weight: normal;"><?=$facture[0]->dates?></span></th>
    </tr>
</table>
<table style="text-align: center" class="table table-bordered">
    <tr>
        <td  style="border-bottom:1px solid #ddd;padding-bottom: 10px" colspan="4">Déscription des achats :</td>
    </tr>
    <tr>
        <th style="text-align: center;">Produit</th>
        <th style="text-align: center;">PU (Ar)</th>
        <th style="text-align: center;">Quantité (Kg)</th>
        <th style="text-align: center;">Montant (Ar)</th>
    </tr>
<?php

$Montant = 0;
$row = 0;
    
    foreach ($facture as $key) { ?>
    <tr>
        <td><?= $key->design ?></td>
        <td><?= separateur($key->PU)?></td>
        <td><?= separateur($key->qteCom)?></td>
        <td><?= separateur($key->total)?></td>
    </tr>

<?php

$Montant += $key->total;
$row++;
}
    $lettre = new Lettre();
    $m = $lettre->nombre($Montant);
?>
    <tr>
        <td style="border:1px solid #ddd">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </td>
        <td style="border:1px solid #ddd"></td>
        <td style="border:1px solid #ddd"></td>
        <td style="border:1px solid #ddd"></td>
    </tr>
    <tr>
        <td></td>
        <td style="border-right: 1px solid #ddd"></td>
        <td style="border:1px solid #ddd">Total</td>
        <td style="border:1px solid #ddd"><?= separateur($Montant) ?>Ar</td>
    </tr>
</table>

<table style="margin-top: 25px">
    <tr>
        <td colspan="5">Arrêté à la somme de : <strong> ********* <em><?= strtoupper($m) ;?></em> ********* </strong></td>
    </tr>
</table>
<div style="text-align: center;margin-top: 50px;"><a href="factureClient/<?= $row ?>">TELECHARGER LA FACTURE <span class="glyphicon glyphicon-cloud-download"></span></a></div>
        <?php
            
         }
?>
    </div>
</div>

<script type="text/javascript" src="<?= base_url()?>assets/js/jQuery.js" ></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/bootstrap.js" ></script>
<script>
    var static = (function(){
		var myVar = 1;
		return function(value){
			return myVar++;
		}
    })();

    function createElem()
    {
        var XHR = new XMLHttpRequest();
        XHR.open("GET" , "http://localhost/CodeIgniter/produit/getProduitBrut?count=produit");
        XHR.onreadystatechange = function(){
            let select = document.querySelectorAll(".select-produit");
        if(XHR.readyState == 4 && XHR.status == 200){
            const prod = JSON.parse(XHR.responseText);
            for(let i = 0; i < select.length ; i++)
            {
                const html = prod.map(function(produit){
                
                    return `<option value="${produit.design + i}">${produit.design}</option>`}).join("");
                
                select[i].innerHTML = html;
            }
        }
        }
        XHR.send();
    }
    createElem();

    // setInterval(function(){
    //     createElem();
    // } , 10000);
    
    const a = document.querySelector(".ajouter");
	
    var tab = document.querySelector("#tab");
    
    a.addEventListener('click' , function(e){

        e.preventDefault();

        var i = static();
        
        var produit =  document.createElement("select");
        
        var qte =  document.createElement("input");
			qte.type = 'number';
			qte.setAttribute('min' , '0');
            qte.name = "qte"+i;
            
            produit.name = "selected"+i;
            qte.setAttribute('required' , 'required');
            produit.setAttribute('required' , 'required');
            produit.classList.add("select-produit");
            produit.style.width = "70%";
        
        var data0 = document.createElement("td");
        var data1 = document.createElement("td");
        var data2 = document.createElement("td");
        var data3 = document.createElement("td");
        data0.style.border="1px solid #ddd";
        data1.style.border="1px solid #ddd";    
        data2.style.border="1px solid #ddd";
        data3.style.border="1px solid #ddd";
        data0.style.padding="10px";
        data1.style.padding="10px";    
        data2.style.padding="10px";
        data3.style.padding="10px";
        
        data0.innerHTML = "Commande n°"+(i+1);

            data2.appendChild(produit);
            data3.appendChild(qte);
        
        const tr = document.createElement("tr");
            
            tr.appendChild(data0);
            
            tr.appendChild(data2);
            
            tr.appendChild(data3);
            
            tr.appendChild(data1);
        
        tab.appendChild(tr);
        
        createElem();

});

</script>
</body>
</html>