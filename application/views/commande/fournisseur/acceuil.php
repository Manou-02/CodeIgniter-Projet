<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Commande Fournisseur</title>
  <meta charset="utf-8" />
  <meta name="author" content="RAJAONARISON Clairmont" />
  <meta lang="fr" />
  <link rel="stylesheet" href="<?= base_url()?>assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?= base_url()?>assets/Chart/Chart.css" />
</head>
<body>
<div class="container">
	<div class="list-group">
    <h1 style="color: brown;text-align: center" >SECTION REAPPROVISIONNEMENT</h1>
        <div class="list-group-item" style="margin-bottom :20px;"></div>
        <div>
        <h3><?= $this->session->reappro ?></h3>
        <form action="reapprovisionner" method="POST" id="form">
        <table class="table table-bordered"  style="text-align:center" id="tab">
            <tr>
                <th style="text-align: center;">Fournisseur</th>
                <th style="text-align: center;">Produit à commander</th>
                <th style="text-align: center;">Quantité</th>
                <th style="text-align: center;">Ajouter</th>
            </tr>
            <tr>
                <td><input type="text"  style="width:70%" name="Fournisseur" required></td>
                <td>
                    <select style="width:70%" class="select-produit" name="selected" required></select>
                </td>
                <td><input type="number" min="0" name="qte" required></td>
                <td><a href="#" class='ajouter'><span class="glyphicon glyphicon-plus"></span></a></td>
            </tr>    
        </table>
        <div style="text-align:center;">
            <button class="btn btn-default" class="commander">COMMANDER <span class="glyphicon glyphicon-console" aria-hidden="true"></span></button></td>
        </div>
        </form>
    </div>
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