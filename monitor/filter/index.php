<?php 

// DIMAB

$mysqli = new mysqli('127.0.0.1', 'root', '', 'dimba');
date_default_timezone_set('America/Argentina/Buenos_Aires');
// onbtener variables de estado
$filter = date("Y-m-d");///hoy
if (isset($_GET['f'])) 
{
    $filter = $_GET['f'];
}

$type = 0;
if (isset($_GET['type'])) 
{
    $type = $_GET['type'];
}

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
    <title>MONITOR DE BARRERAS</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="..">Monitor de Barreras</a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
               <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li  role="presentation"><a href="../">Registros en Vivo </a></li>
                        <!-- <li class="active" role="presentation"><a href="#">Monitor de Barreras </a></li> -->
                        <!-- <li role="presentation"><a href="../cdp">Contador de Pasajeros</a></li> -->
                    </ul>
                </div>
            </div>
        </nav>

        <!-- aca puedo poner para seleccionar el dispositvo para ir a ver los registros -->
<h2>Mostrando Registros del dia <?php echo $filter;?></h2>
<form>
    <label>Filtrar registos por fecha:</label>
    <input type="date" name="f" <?php echo 'value="'.date("Y-m-d").'"';?>>
    <input class="btn btn-success" type="submit" value="Buscar">
</form>


<!--  -->

<?php 

$sql = "SELECT * , date_format(timestamp,'%Y-%m-%d') as dia FROM dimba having dia like '%".$filter."%'  " ;
if (!$resultado = $mysqli->query($sql)) {
   
    echo "Error: La ejecución de la consulta falló debido a: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
}




 ?>

<!-- <div id="toolbar">
        <select class="form-control">
                <option value="">Exportar Basico</option>
                <option value="all">Exportar Todo</option>
                <option value="selected">Exportar Seleccionado</option>
        </select>
</div> -->

    <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th class="col-md-2" data-field="fecha" data-filter-control="select" data-sortable="true">Fecha</th>
            <!-- <th data-field="usuario" data-filter-control="select" data-sortable="true">Usuario</th> -->
            <th data-field="topico" data-filter-control="select" data-sortable="true">Topico</th>
            <th data-field="mensaje" data-filter-control="select" data-sortable="true">Mensaje</th>
            </tr>
        </thead>
        <tbody id="sheet">
          <?php


while ($res = $resultado->fetch_assoc()) 
{
 echo ' <tr><td class="col-md-2"><b>'.$res['timestamp'].'</b></td>
                <td>'.$res['topic'].'</td>
                <td>'.$res['payload'].'</th></td>';
}
          ?>

        </tbody>
    </table>

    
</div>
       
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    

  

    <!-- <script  src="js/index.js"></script> -->
</body>

</html>