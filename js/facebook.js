//Cargar modulo facebook de manera async
window.fbAsyncInit = function() {
    FB.init({
        appId      : '1681858355238478',
        cookie     : true,
        xfbml      : true,
        version    : 'v2.12'
    }); 
};

function comprobarEstadologin() {
    FB.getLoginStatus(function(response) {
        //console.log(response);
        statusChangeCallback(response);
    });
}

function statusChangeCallback(response) {
    //console.log('statusChangeCallback');
    //console.log(response);
    if (response.status === 'connected') {
      //Logeado en la aplicación
      recibirInfo();
    } else {
      //No logeado en la aplicación, botón cerrar pestaña o cancelar
      document.getElementById('status').innerHTML = 'Logueate en la aplicación para iniciar sesión';
    }
  }

  function recibirInfo() {
    console.log('Bienvenido!  Recopilando información.... ');
    ///me?fields=id,name,email
    FB.api('/me?fields=id,first_name,last_name,email', function(response) {
      enviarDatos(response);
      //console.log(response);
      //var url = "http://localhost/sesninesapp/inc/check_valid_fb_account.inc.php?id="+response.id+"&first_name="+response.first_name+"&last_name="+response.last_name+"&email="+response.email;
      //console.log(url);
      //location.href=url;
    });
  }

  function enviarDatos(response){
    var http = new XMLHttpRequest();
    if(http){
      http.open("POST","https://steampunkseo.es/sesninesfacebook/inc/check_valid_fb_account.inc.php",true);
      http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      //http.setRequestHeader("Access-Control-Allow-Origin","*");
      http.onreadystatechange = function(){
        if(http.readyState == 4 && http.status == 200){
          location.href="https://steampunkseo.es/sesninesfacebook/inc/check_valid_fb_account.inc.php";
          //alert(http.responseText);
        }
      }
      http.send("first_name="+response.first_name+"&last_name="+response.last_name+"&email="+response.email);
    }
  }

  function desloguear(){
    FB.logout(function(response) {
      // user is now logged out
    });
  }