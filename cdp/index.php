<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTADOR DE PASAJEROS</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">Contador de Pasajeros</a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
               <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li role="presentation"><a href="../">Inicio </a></li>
                        <li role="presentation"><a href="../monitor">Monitor de Barreras </a></li>
                        <li class="active"  role="presentation"><a href="#">Contador de Pasajeros</a></li>
                        <li class="active"  role="presentation"><a href="graficos">Gráficos</a></li>
                    </ul>
                </div>
            </div>
        </nav>

    
        <div class="row">
            <div class="col-md-2">
                <h4>fecha</h4></div>
            <div class="col-md-3">
                <h4>dispositivo </h4></div>
            <div class="col-md-7">
                <h4>mensaje</h4></div>
        </div>
        <div class="row" id="sheet">
            
        </div>
       
    <script src="../assets/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="live.js"></script>
</body>

</html>