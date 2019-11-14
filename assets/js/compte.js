function CompteurtCli()
{
  var XHR = new XMLHttpRequest();
  XHR.open("GET" , "http://localhost/CodeIgniter/Client/getCountCli?count=client");
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
        client = document.querySelector('#client')
        response = parseInt(XHR.responseText);
        client.innerHTML = response;

    }

  }
      XHR.send();
}
function CompteurFrs()
{
  var XHR = new XMLHttpRequest();
  XHR.open("GET" , "http://localhost/CodeIgniter/fournisseur/getCountFrs?count=fournisseur");
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
        fournisseur = document.querySelector('#fournisseur')
        response = parseInt(XHR.responseText);
        fournisseur.innerHTML = response;

    }

  }
      XHR.send();
}
function CompteurProd()
{
  var XHR = new XMLHttpRequest();
  XHR.open("GET" , "http://localhost/CodeIgniter/produit/getCountProd?count=produit");
    XHR.onreadystatechange = function(){
      if(XHR.readyState == 4 && XHR.status == 200){
        produit = document.querySelector('#produit');
        produit.innerHTML = XHR.responseText;
  }
  
  }

  XHR.send();

}

setInterval(function(){
CompteurtCli();
CompteurProd(); 
CompteurFrs(); 
} , 2000);

let div = document.querySelectorAll(".carousel-caption");
function interval()
{
  setInterval(function(){
  for(let i =0 ; i < div.length ; i++)
    {
        div[i].firstElementChild.classList.toggle('tog');
    }
  } , 200);
}

setInterval(interval , 5000);