<?php?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ysana - QR</title>
</head>
<body>
    <div id="container">
        <textarea id="data" rows="5"></textarea>
        <button id="enviar">Generar QR</button>
    </div>
    <div id="imagen"></div>
</body>
<script>
document.getElementById('enviar').addEventListener('click', function(){
    var datos = document.getElementById('data').value;
    var url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data="+datos;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("imagen").innerHTML = this.responseText;
        }
    };
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.setRequestHeader("Access-Control-Allow-Origin", "*");
    xhttp.open("GET", url, true);
    xhttp.send(); 
});
</script>
<style>
#container{
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 400px;
    align-items: center;
}
#data{
    width: 100%;
}
</style>
</html>