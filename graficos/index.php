<?php 

$mysqli = new mysqli('127.0.0.1', 'root', '', 'gicsafe');


if ($mysqli->connect_errno) {
  echo "Error: " . $mysqli->connect_error . "\n";
    
    exit;
}

 ?>
 <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GICSAFE</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">GICSAFE</a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <!-- <li class="active" role="presentation"><a href="#">Inicio </a></li> -->
                        <li role="presentation"><a href="monitor">Mensajes en formato crudo</a></li>
                        <!-- <li role="presentation"><a href="cdp">Contador de Pasajeros</a></li> -->
                    </ul>
                </div>
            </div>
        </nav>

        <h2>GRAFICOS</h2>

        
    </div>
</body>