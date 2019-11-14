/*var search = document.querySelector("#search");
var resultat = document.querySelector("#result");
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
        const html = "<table class='table table-bordered' style='width:100%'>"+result+"</table>";
        resultat.innerHTML = html;
      }
    };
    XHR.send();
  }

});*/