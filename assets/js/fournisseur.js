function getFournisseur(order='' , mode = 0, limit=0)
{
  switch(order)
  {
    case 1 : order = 'codeFrs'; break;
    case 2 : order = 'nomFrs'; break;
    case 3 : order = 'adresse'; break;
    default :  break;
  }
  if(mode != 0)
    mode = 'ASC';
else mode='DESC';
//Si c'est 1, on veut une affichage ascendante
//On traite directement la requete sous forme de chaine de caractere
  var XHR = new XMLHttpRequest();
	var resultat = document.getElementById("tableau");
    XHR.open("GET" , "http://localhost/CodeIgniter/Fournisseur/listeFournisseur?task=list&order="+order+"&mode="+mode+"&limit="+limit);
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
          var result = XHR.responseText;
          resultat.innerHTML = result;
          resultat.scrollTop = resultat.scrollHeight;
      }

};
XHR.send();
}
getFournisseur('codeFrs');
setInterval(function(){
  getFournisseur('codeFrs')} , 10000);

var search = document.getElementById("search");
  var resultat = document.getElementById("tableau");
  search.addEventListener('keyup' , function(e){
    e.preventDefault();
      if(search.value == '')
      {
        getFournisseur('codeFrs');
        CountFrs();
      }
  else{
      var XHR = new XMLHttpRequest();
      XHR.open("GET" , "http://localhost/CodeIgniter/Fournisseur/searchFournisseur?query="+search.value);
      XHR.onreadystatechange = function(){
          if(XHR.status == 200 && XHR.readyState == 4)
          {
            //clearInterval(getFournisseur);
            if(XHR.responseText == "Aucun fournisseur ne correspond à votre requête")
              {
                var html = "<p style='width:100%;color:black;text-align:center;font-weight:bold;font-size:13px'>"+XHR.responseText + "</p>";
                resultat.innerHTML = html;
                resultat.scrollHeigth = resultat.scrollTop;

              }
            else{
                        var result = JSON.parse(XHR.responseText);

                      var html = result.map(function(reponse){

                        return `<tr>
                            <td>F${reponse.codeFrs}</td>
              <td>${reponse.nomFrs}</td>
              <td>${reponse.adresse}</td>
                            <td>
                            <button onclick='editFourniisseur(${reponse.codeFrs})' class='btn btn-primary'>Modifier <span class='glyphicon glyphicon-edit'></span></a></button>
                            <button onclick='supprimerFourniisseur(${reponse.codeFrs})' class='btn btn-danger'>Supprimer <span class='glyphicon glyphicon-erase'></sapn></a></button>
                            </td>
                            </tr>
                            `
                          }).join('');
                      html += "";
                      var head = `<tr>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getFournisseur(1 ,1)' onclick='getFournisseur(1)'>Code du Client <span class="glyphicon glyphicon-chevron-down"></sapn></th>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getFournisseur(2,1)' onclick='getFournisseur(2)'>Nom <span class="glyphicon glyphicon-chevron-down"></sapn></th>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getFournisseur(3,1)' onclick='getFournisseur(3)'>Adresse <span class="glyphicon glyphicon-chevron-down"></sapn></th>
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

function CountFrs()
{
  var str = document.querySelector(".pagination");
  str.innerHTML = "";
  var XHR = new XMLHttpRequest();
  XHR.open("GET" , "http://localhost/CodeIgniter/Fournisseur/getCountFrs?count=client");
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
        client = document.querySelector('.client')
        response = parseInt(XHR.responseText);
        client.innerHTML = response;
        

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
}

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
  getFournisseur('codeFrs' , 0 ,limit);

  })
  
  }
}

var btn = document.getElementById("save");
var form = document.getElementById("myForm");
var nom = document.getElementById("nom");
var adresse = document.getElementById("adresse");
var alert = document.querySelector(".alert");
btn.addEventListener("click" , function(e){

  e.preventDefault();
  

      if(confirm("Voulez-vous ajouter ce fournisseur ?"))
      {
          addFournisseur(form);
          CountFrs();
          alert.innerHTML = "Le fournisseur a été ajouté avec succes";
          
      }
      nom.value = '';
      adresse.value = '';
      document.querySelector('.bg-modal').style.display = 'none';
      resultat.scrollTop = resultat.scrollHeight;

});

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

CountFrs();

  function addFournisseur(formulaire)
{

  var XHRreq = new XMLHttpRequest();
  var data = new FormData(formulaire);

  XHRreq.open("POST" , "addFournisseur");

  XHRreq.onreadystatechange = function(){
    if(XHRreq.readyState == 4 && XHRreq.status == 200)
    {
      getFournisseur('codeFrs');
      CountFrs();
      }
  }
  XHRreq.send(data);
  }
function supprimerFournisseur(codeFrs)
{
var alert = document.querySelector(".alert");

if(confirm("Supprimer ce fournisseur ?"))
  {
      var XHR = new XMLHttpRequest();
      XHR.open("GET" , "supprimerFournisseur?supprimer=" + codeFrs );
      XHR.onreadystatechange = function(){
        if(XHR.status == 200 && XHR.readyState == 4){
          getFournisseur('codeFrs');
          CountFrs();
          setTimeout(function(){
            alert.innerHTML = "Le fournisseur a été supprimé avec succes";
          } ,  500)

        }
      }
      XHR.send();
  }
  else
    {
      getFournisseur("codeFrs");
      CountFrs();
    }
}


//=======================================================================

function editFournisseur(codeFrs)
{
  let XHR = new XMLHttpRequest();
  XHR.open("GET" , "fournisseurDescription?codeFrs="+codeFrs);
  XHR.onreadystatechange = function(){
    if(XHR.readyState == 4 && XHR.status == 200)
    {
      const reponse = JSON.parse(XHR.responseText);
      const html = reponse.map(function(frs){
            return `
            <form method='POST' action='update' id='updatePro'>
            <label>Mettre à jour un client : ${frs.nomFrs}</label><br/>
            <label>Code du client : </label>&nbsp;&nbsp;&nbsp;<input type='text' onfocus='blur()' name='codeFrs' value='${frs.codeFrs}'><br/>
            <label for="nom">Nom du fournisseur</label>
              <input class='form-control' type='text' value='${frs.nomFrs}' name='nom' required>
              <label for="adresse">Adresse :</label>
              <input class='form-control' type='text' value='${frs.adresse}' name='adrs' required>
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
  var nom = document.getElementById("nom");
var adresse = document.getElementById("adresse");
var alert = document.querySelector(".alert");

  let form = document.querySelector('#updatePro');
  let formulaire = new FormData(form);

  let XHRreq = new XMLHttpRequest();
  XHRreq.open('POST' , 'update');
  XHRreq.onreadystatechange = function(){
    if(XHRreq.readyState == 4 && XHRreq.status == 200)
        getFournisseur('codeFrs');
  }
  XHRreq.send(formulaire);
        let formul = document.querySelector('#update');
        formul.style.display = 'none';
  })
});