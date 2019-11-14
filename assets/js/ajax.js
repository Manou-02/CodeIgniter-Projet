function getProduit(order , mode = 0)
{
  switch(order)
  {
    case 1 : order = 'codePro'; break;
    case 2 : order = 'Design'; break;
    case 3 : order = 'PU'; break;
    case 4 : order = 'stock'; break;
    default :  break;
  }
  if(mode != 0)
    mode = 'ASC';
else mode='DESC';
//Si c'est 1, on veut une affichage ascendante
//On traite directement la requete sous forme de chaine de caractere
  var XHR = new XMLHttpRequest();
  var resultat = document.getElementById("tableau");
    XHR.open("GET" , "http://localhost/CodeIgniter/Produit/listeProduit?task=list&order="+order+"&mode="+mode);
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
          var result = XHR.responseText;
          resultat.innerHTML = result;
          resultat.scrollTop = resultat.scrollHeight;
      }
    
};
XHR.send();
}
function getCountProduit()
{   var XHR = new XMLHttpRequest();
	XHR.open("GET" , "http://localhost/CodeIgniter/Produit/getCountProd?count=produit");
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
      	var str = document.querySelector(".countProduit");
      	response = parseInt(XHR.responseText)
      	if(response > 1)
      	   str.innerHTML = response + " produits";
      	else
      	   str.innerHTML = response + " produit";
      	str.style.color = 'red';
     	}
	}
	XHR.send();
}
function getCountFrs()
{
  var XHR = new XMLHttpRequest();
  XHR.open("GET" , "http://localhost/CodeIgniter/fournisseur/getCountFrs?count=fournisseur");
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
        fournisseur = document.querySelector('#fourni');
        response = parseInt(XHR.responseText);
        if(response > 1)
          fournisseur.innerHTML = response+" fournisseurs";
        else
          fournisseur.innerHTML = response+" fournisseur";
    }

  }
      XHR.send();
}

function getCountCli()
{   var XHR = new XMLHttpRequest();
  XHR.open("GET" , "http://localhost/CodeIgniter/Client/getCountCli?count=client");
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
        var str = document.querySelector(".countCli");
        response = parseInt(XHR.responseText)
        if(response > 1)
           str.innerHTML = response + " clients";
        else
           str.innerHTML = response + " client";
        str.style.color = 'red';
      }
  }
  XHR.send();
}

getProduit('codePro');

getCountProduit()

getCountCli()

getCountFrs();

function supprimerProduit(codePro)
{
  alert("Veuillez vous rendre dans la section produit pour pouvoir supprimer ce produit");
}
function editProduit(codePro){
  alert("Veuillez vous rendre dans la section produit pour pouvoir modifier ce produit");
}

function chiffreAffaire(cible)
{
  var XHR = new XMLHttpRequest();
  XHR.open("GET" , "http://localhost/CodeIgniter/client/chiffreAffaire");
  XHR.onreadystatechange = function(){
    if(XHR.readyState == 4 && XHR.status == 200)
    {
      var response = JSON.parse(XHR.responseText);
      var html = response.map(function(reponse){
    return `<tr>
            <td>C${reponse.codeCli}</td>
            <td>${reponse.nomcli}</td>
            <td>${reponse.chiffre} Ar</td>
          </tr>`
  }).join("");
      var table = `<tr>
          <th>Code du client</th>
          <th>Nom du client</th>
          <th>Chiffre d'affaire</th>
          </tr>`;
          table += html;
          cible.innerHTML = table;
    }
  }
  XHR.send();
}
var cible = document.getElementById("table");

chiffreAffaire(cible);

setInterval(function(){
  getCountProduit();
  getCountCli();
  getCountFrs();
  getProduit('codePro');
  chiffreAffaire(cible);
} , 5000)





//============================================ 

var search = document.querySelector("#search");
var resultat = document.querySelector("#dada");
search.addEventListener("keyup" , function(){
  if(search.value == ""){
    resultat.innerHTML = "";
  }
  else
  {

    var XHR = new XMLHttpRequest();

    XHR.open("GET" , "search?query=" + search.value);

    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
          var result = XHR.responseText;
        const html = "<h4>Résultat de votre recherche :</h4><table class='table table-bordered' style='width:60%;margin-left:10px;padding:5px;'>"+result+"</table>";
        resultat.innerHTML = html;
      }
    };
    XHR.send();
  }

});