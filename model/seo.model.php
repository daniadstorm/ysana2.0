<?php

class seoModel {

    function __construct() {
    }

    function add_cabecera($ruta_inicio, $title="Ysana", $lang="es", $description="",$keywords=""){
        $o = '';
        $o .= '<!DOCTYPE html>
        <html lang="'.$lang.'">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>'.$title.'</title>
            <meta name="description" content="'.$description.'"/>
            <meta name="keywords" content="'.$keywords.'"/>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <meta http-equiv="Content-Language" content="'.$lang.'"/>
            <meta http-equiv="Cache-control" content="no-cache"/>
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500" rel="stylesheet">
            <link rel="shortcut icon" href="'.$ruta_inicio.'img/favicon.ico"/>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"/>
            <link type="text/css" href="'.$ruta_inicio.'css/fileinput.min.css" media="all" rel="stylesheet"/>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>
            <link href="'.$ruta_inicio.'themes/explorer-fa/theme.css" media="all" rel="stylesheet" type="text/css"/>
            <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
            <script src="'.$ruta_inicio.'js/jquery-ui.min.js"></script>
            <script type="text/javascript" src="'.$ruta_inicio.'js/ysana.js"></script>
            <link type="text/css" href="'.$ruta_inicio.'css/ysana.css" rel="Stylesheet" />
            <script src="'.$ruta_inicio.'js/plugins/sortable.js" type="text/javascript"></script>
            <script src="'.$ruta_inicio.'js/fileinput.min.js" type="text/javascript"></script>
            <script src="'.$ruta_inicio.'js/locales/fr.js" type="text/javascript"></script>
            <script src="'.$ruta_inicio.'js/locales/es.js" type="text/javascript"></script>
            <script src="'.$ruta_inicio.'themes/explorer-fa/theme.js" type="text/javascript"></script>
            <script src="'.$ruta_inicio.'themes/fa/theme.js" type="text/javascript"></script>
            <script src="https://www.google.com/recaptcha/api.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>
        </head>';
        
        return $o;
    }

}

?>