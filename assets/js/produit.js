function getProduit(order='' , mode = 0, limit=0)
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
    XHR.open("GET" , "http://localhost/CodeIgniter/Produit/listeProduit?task=list&order="+order+"&mode="+mode+"&limit="+limit);
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
          var result = XHR.responseText;
          resultat.innerHTML = result;
          resultat.scrollTop = resultat.scrollHeight;
      }

};
clearInterval(function(){
  getProduit('codePro')
})

XHR.send();

clearInterval(function(){
  getProduit('codePro')
})
}

getProduit('codePro');


/*===============================================*/

setInterval(function(){
  getProduit("codePro")} , 5000);

//Si on a rien dans search, on affiche les produits avec getProduit

  var search = document.getElementById("search");
  var resultat = document.getElementById("tableau");
  search.addEventListener('keyup' , function(e){
    e.preventDefault();

      if(search.value == '')
      {
        getProduit('codePro');
        CountProd();
      }
  else{
      var XHR = new XMLHttpRequest();
      XHR.open("GET" , "http://localhost/CodeIgniter/Produit/searchProduit?query="+search.value);
      XHR.onreadystatechange = function(){
          if(XHR.status == 200 && XHR.readyState == 4)
          {
            //clearInterval(getProduit);
            if(XHR.responseText == "Aucun produit ne correspond à votre requête")
              {
                var html = "<p style='width:100%;color:black;text-align:center;font-weight:bold;'>"+XHR.responseText + "</p>";
                resultat.innerHTML = html;
                resultat.scrollHeigth = resultat.scrollTop;

              }
            else{
                        var result = JSON.parse(XHR.responseText);

                      var html = result.map(function(produit){

                        return `<tr>
                            <td>P${produit.codePro}</td>
                            <td>${produit.Design}</td>
                            <td>${produit.PU},00</td>
                            <td>${produit.stock}</td>
                            <td>
                            <button onclick='editProduit(${produit.codePro})' class='btn btn-primary'>Modifier <span class='glyphicon glyphicon-edit'></span></a></button>
                            <button onclick='supprimerProduit(${produit.codePro})' class='btn btn-danger'>Supprimer <span class='glyphicon glyphicon-erase'></sapn></a></button>
                            </td>
                            </tr>
                            `
                          }).join('');
                      html += "";
                      var head = `<tr>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getProduit(1 ,1)' onclick='getProduit(1)'>Code du produit <span class="glyphicon glyphicon-chevron-down"></sapn></th>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getProduit(2,1)' onclick='getProduit(2)'>Designation <span class="glyphicon glyphicon-chevron-down"></sapn></th>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getProduit(3,1)' onclick='getProduit(3)'>Prix unitaire (Ar)<span class="glyphicon glyphicon-chevron-down"></sapn></th>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getProduit(4,1)' onclick='getProduit(4)'>Stock actuel <span class="glyphicon glyphicon-chevron-down"></sapn></th>
                    <th>Action</th>
                    </tr>`;
                  html = "<table class='table table-bordered'>" + head + html + "</table>";

                  resultat.innerHTML = html;
                  resultat.scrollTop = resultat.scrollHeight;
                }
          }
           //console.log(typeof(html));
  }
      XHR.send();
  }

  })


//==================================================//
/*
# Il faut faire celle des suppressions maintenant
*/

function supprimerProduit(codePro)
{
var alert = document.querySelector(".alert");

if(confirm("Supprimer ce produit ?"))
  {
      var XHR = new XMLHttpRequest();
      XHR.open("GET" , "supprimerProduit?supprimer=" + codePro );
      XHR.onreadystatechange = function(){
        if(XHR.status == 200 && XHR.readyState == 4){
          getProduit('codePro');
          CountProd();
          setTimeout(function(){
            alert.innerHTML = "Le produit a été supprimé avec succes";
          } , 0 , 2000)

        }
      }
      XHR.send();
  }
  else
    {
      getProduit("codePro");
      CountProd();
    }
}

function editProduit(codePro)
{
  var editEspace = document.querySelector(".editEspace");
}

var btn = document.getElementById("save");
var form = document.getElementById("myForm");
var design = document.getElementById("design");
var prix = document.getElementById("prix");
var alert = document.querySelector(".alert");
var checkBox = document.querySelector(".checkBox");

btn.addEventListener("click" , function(e){

  e.preventDefault();

  
          addProduit(form);
          alert.innerHTML = "Le produit a été ajouté avec succes";
      
      prix.value = '';
      design.value = '';
      document.querySelector('.bg-modal').style.display = 'none';
 });

//Ajout d'un produit
function addProduit(formulaire)
{

  var XHRreq = new XMLHttpRequest();
  var data = new FormData(formulaire);

  XHRreq.open("POST" , "addProduit");

  XHRreq.onreadystatechange = function(){
    if(XHRreq.readyState == 4 && XHRreq.status == 200)
    {
      getProduit('CodePro');
      CountProd();
    }
  }
  XHRreq.send(data);
}
close = document.querySelector('.closed');
add = document.getElementById('add');
close.addEventListener("click" , function(e){
  e.preventDefault();
  document.querySelector('.bg-modal').style.display = 'none';
})
add.addEventListener("click" , function(e){
  e.preventDefault();
  document.querySelector('.bg-modal').style.display = 'block';
})



var limiter = document.querySelectorAll(".limiter");
var i = 0;

for(i = 0 ; i < limiter.length ; i++)
{
var parent = (limiter[i].parentNode).parentNode;
parent = parent.childNodes;

  limiter[i].addEventListener('click' , function(e){
  e.preventDefault();
  for(var j = 0; j < parent.length ;j++)
  {
    if(parent[j].nodeType == 1)
        parent[j].classList.remove('active');
  }
this.parentNode.classList.add('active');
var limit = (parseInt((this.firstChild).data) - 1)* 10;
getProduit('codePro' , 0 ,limit);

})
}

function CountProd()
{
  var str = document.querySelector(".pagination");
  str.innerHTML = "";
  var XHR = new XMLHttpRequest();
  XHR.open("GET" , "http://localhost/CodeIgniter/produit/getCountProd?count=produit");
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
        client = document.querySelector('.client')
        client.innerHTML = XHR.responseText;

        response = parseInt(XHR.responseText);
              if(response < 10)
              {
                var li = document.createElement('li');
                li.classList.add('active');
                var a = document.createElement("a");
                a.href = "#";
                a.classList.add('limiter');
                text = document.createTextNode('1');
                a.appendChild(text);
                li.appendChild(a);
                str.appendChild(li);
              } 
      else
      {
        if(response % 10 == 0)
            response = response / 10;
        else
          response = ((response - (response % 10 ))/ 10) + 1;
        var i = 1;
        while(response > 0)
        {
         var li = document.createElement('li');          
         if(i == 1)
                li.classList.add('active');
    
                var a = document.createElement("a");
                a.href = "#";
                a.classList.add('limiter');
                text = document.createTextNode(i);
                a.appendChild(text);
                li.appendChild(a);
                str.appendChild(li);
                response--;
                i++;
            }
            event();
        }
  }
  
  }

  XHR.send();

  return XHR.responseText;
}
setTimeout(function(){
  CountProd()} , 2000);

function event()
{

  var limiter = document.querySelectorAll(".limiter");
  
 var i = 0;

  for(i = 0 ; i < limiter.length ; i++)
  {
  var parent = (limiter[i].parentNode).parentNode;
  parent = parent.childNodes;

    limiter[i].addEventListener('click' , function(e){
    e.preventDefault();
    for(var j = 0; j < parent.length ;j++)
    {
      if(parent[j].nodeType == 1)
          parent[j].classList.remove('active');
    }
  this.parentNode.classList.add('active');
  var limit = (parseInt((this.firstChild).data) - 1)* 10;
  getProduit('codePro' , 0 ,limit);

  })
  
  }
}
function editProduit(codePro)
{
  let XHR = new XMLHttpRequest();
  XHR.open("GET" , "produitDescription?codePro="+codePro);
  XHR.onreadystatechange = function(){
    if(XHR.readyState == 4 && XHR.status == 200)
    {
      const reponse = JSON.parse(XHR.responseText);
        const html = reponse.map(function(produit){
            return `
            <form method='POST' action='update' id='updatePro'>
            <label>Mettre à jour un produit : ${produit.design}</label><br/>
            <label>Code du produit : </label>&nbsp;&nbsp;&nbsp;<input type='text' onfocus='blur()' name='codePro' value='${produit.codePro}'><br/>
            <label for="design">Designation du produit</label>
              <input class='form-control' type='text' value='${produit.design}' name='design' id='design' required>
              <label for="prix">Prix unitaire (Ar) :</label>
              <input class='form-control' type='number' min='0' value='${produit.PU}' name='pu' id='pu' required>
              <br>          
              <button class='btn btn-success' id='uptodate'>METTRE A JOUR <span class="glyphicon glyphicon-edit"></span></button>
            </form>`;
        }).join("");
      let form = document.querySelector('#update');
      form.style.display = 'block';
      form.innerHTML = html;
      edit();
  }
}

  XHR.send();

}


var edit = (function(){

let button = document.querySelector('#uptodate');

button.addEventListener('click' , function(e){
e.preventDefault();
var design = document.getElementById("design");
var pu = document.getElementById("pu");
var alert = document.querySelector(".alert");

  let form = document.querySelector('#updatePro');
  let formulaire = new FormData(form);

  let XHRreq = new XMLHttpRequest();
  XHRreq.open('POST' , 'update');
  XHRreq.onreadystatechange = function(){
    if(XHRreq.readyState == 4 && XHRreq.status == 200)
        getProduit('codePro');
  }
        XHRreq.send(formulaire);
        alert.innerHTML = 'Le produit a été mise à jour avec succès';
        let formul = document.querySelector('#update');
        formul.style.display = 'none';

    })
});