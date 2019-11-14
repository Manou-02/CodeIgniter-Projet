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
var cible = document.querySelector(".table");


setInterval(function(){
  chiffreAffaire(cible)} , 8000)

function getClient(order='' , mode = 0, limit=0)
{
  switch(order)
  {
    case 1 : order = 'codeCli'; break;
    case 2 : order = 'nomCli'; break;
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
    XHR.open("GET" , "http://localhost/CodeIgniter/Client/listeClient?task=list&order="+order+"&mode="+mode+"&limit="+limit);
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
          var result = XHR.responseText;
          resultat.innerHTML = result;
          resultat.scrollTop = resultat.scrollHeight;
      }

};
XHR.send();
}
getClient('codeCli');
setInterval(function(){
  getClient('codeCli')} , 10000);

var search = document.getElementById("search");
  var resultat = document.getElementById("tableau");
  search.addEventListener('keyup' , function(e){
    e.preventDefault();
      if(search.value == '')
      {
        getClient('codeCli');
        CountCli();
      }
  else{
      var XHR = new XMLHttpRequest();
      XHR.open("GET" , "http://localhost/CodeIgniter/Client/searchClient?query="+search.value);
      XHR.onreadystatechange = function(){
          if(XHR.status == 200 && XHR.readyState == 4)
          {
            //clearInterval(getClient);
            if(XHR.responseText == "Aucun client ne correspond à votre requête")
              {
                var html = "<p style='width:100%;color:black;text-align:center;font-weight:bold;font-size:13px'>"+XHR.responseText + "</p>";
                resultat.innerHTML = html;
                resultat.scrollHeigth = resultat.scrollTop;

              }
            else{
                        var result = JSON.parse(XHR.responseText);

                      var html = result.map(function(reponse){

                        return `<tr>
                            <td>C${reponse.codeCli}</td>
							<td>${reponse.nomCli}</td>
							<td>${reponse.adresse}</td>
                            <td>
                            <button onclick='editClient(${reponse.codeCli})' class='btn btn-primary'>Modifier <span class='glyphicon glyphicon-edit'></span></a></button>
                            <button onclick='supprimerClient(${reponse.codeCli})' class='btn btn-danger'>Supprimer <span class='glyphicon glyphicon-erase'></sapn></a></button>
                            </td>
                            </tr>
                            `
                          }).join('');
                      html += "";
                      var head = `<tr>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getClient(1 ,1)' onclick='getClient(1)'>Code du Client <span class="glyphicon glyphicon-chevron-down"></sapn></th>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getClient(2,1)' onclick='getClient(2)'>Nom <span class="glyphicon glyphicon-chevron-down"></sapn></th>
                    <th style='color:rgba(50,50,200, .75);cursor:pointer' ondblclick='getClient(3,1)' onclick='getClient(3)'>Adresse <span class="glyphicon glyphicon-chevron-down"></sapn></th>
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

function addClient(formulaire)
{

  var XHRreq = new XMLHttpRequest();
  var data = new FormData(formulaire);

  XHRreq.open("POST" , "addClient");

  XHRreq.onreadystatechange = function(){
    if(XHRreq.readyState == 4 && XHRreq.status == 200)
    {
      getClient('codeCli');
      CountCli();
      }
  }
  XHRreq.send(data);
  return true;
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

function supprimerClient(codecli)
{
var alert = document.querySelector(".alert");

if(confirm("Supprimer ce client ?"))
  {
      var XHR = new XMLHttpRequest();
      XHR.open("GET" , "supprimerClient?supprimer=" + codecli );
      XHR.onreadystatechange = function(){
        if(XHR.status == 200 && XHR.readyState == 4){
          getClient('codeCli');
          CountCli();
          setTimeout(function(){
            alert.innerHTML = "Le client a été supprimé avec succès";
          } , 0 , 4000)

        }
      }
      XHR.send();
  }
  else
    {
      getClient("codeCli");
      CountCli();
    }
}

var btn = document.getElementById("save");
var form = document.getElementById("myForm");
var nom = document.getElementById("nom");
var adresse = document.getElementById("adresse");
var alert = document.querySelector(".alert");
btn.addEventListener("click" , function(e){

e.preventDefault();
  const pattern1 = "[^0-9&#\"({})\\\[|`\]@=+-*\/<>!§:.;,?°]{"+((adresse.value).length )+"}$";
  const pattern2 = "[^0-9&#\"({})\\\[|`\]@=+-*\/<>!§:.;,?°]{"+((nom.value).length )+"}$";
  let reg1 = new RegExp(pattern1,"gi");
  let reg2 = new RegExp(pattern2,"gi");

if(isNaN(adresse.value) && isNaN(nom.value) && reg1.test(adresse.value) != true && reg2.test(nom.value) != true)
{      
            addClient(form); 
            CountCli();
            alert.innerHTML = "Le client a été ajouté avec succes";
            nom.value = '';
            adresse.value = '';
            document.querySelector('.bg-modal').style.display = 'none';
            resultat.scrollTop = resultat.scrollHeight;
        
       }
else{
  alert.innerHTML = 'Les champs doivent contenir uniquement des caractères alphabetiques';
}
});


function CountCli()
{
  var str = document.querySelector(".pagination");
  str.innerHTML = "";
  var XHR = new XMLHttpRequest();
  XHR.open("GET" , "http://localhost/CodeIgniter/Client/getCountCli?count=client");
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
CountCli();

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
  getClient('codeCli' , 0 ,limit);

  })
  
  }
}


//=======================================================

function editClient(codeCli)
{
  let XHR = new XMLHttpRequest();
  XHR.open("GET" , "clientDescription?codeCli="+codeCli);
  XHR.onreadystatechange = function(){
    if(XHR.readyState == 4 && XHR.status == 200)
    {
      const reponse = JSON.parse(XHR.responseText);
        const html = reponse.map(function(client){
            return `
            <form method='POST' action='update' id='updatePro'>
            <label>Mettre à jour un client : ${client.nomCli}</label><br/>
            <label>Code du client : </label>&nbsp;&nbsp;&nbsp;<input type='text' onfocus='blur()' name='codeCli' value='${client.codeCli}'><br/>
            <label for="nom">Nom du client</label>
              <input class='form-control' type='text' value='${client.nomCli}' name='nom' id='nom' required>
              <label for="adresse">Adresse :</label>
              <input class='form-control' type='text' value='${client.adresse}' name='adrs' id='adresse' required>
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

var nom = document.getElementById("nom");
var adresse = document.getElementById("adresse");
var alert = document.querySelector(".alert");

let button = document.querySelector('#uptodate');

button.addEventListener('click' , function(e){
  e.preventDefault();
  const pattern1 = "[^0-9&#\"({})\\\[|`\]@=+-*\/<>!§:.;,?°]{"+((adresse.value).length - 1)+"}$";
  const pattern2 = "[^0-9&#\"({})\\\[|`\]@=+-*\/<>!§:.;,?°]{"+((nom.value).length - 1)+"}$";
  let reg1 = new RegExp(pattern1,"gi");
  let reg2 = new RegExp(pattern2,"gi");

if(isNaN(adresse.value) && isNaN(nom.value) && reg1.test(adresse.value) != true && reg2.test(nom.value) != true )
{ 
  let form = document.querySelector('#updatePro');
  let formulaire = new FormData(form);

  let XHRreq = new XMLHttpRequest();
  XHRreq.open('POST' , 'update');
  XHRreq.onreadystatechange = function(){
    if(XHRreq.readyState == 4 && XHRreq.status == 200)
        getClient('codeCli');
  }
  XHRreq.send(formulaire);
        let formul = document.querySelector('#update');
        formul.style.display = 'none';
        alert.innerHTML = 'Le client a été mise à jour avec succès';
        return true;
        }
  else
    alert.innerHTML = 'Les champs doivent contenir uniquement des caractères alphabetiques';
  return false;
    })
});