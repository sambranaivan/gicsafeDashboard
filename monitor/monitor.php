
<?php 
$mysqli = new mysqli('127.0.0.1', 'root', '', 'gicsafe');
date_default_timezone_set('America/Argentina/Buenos_Aires');

///CONEXION A BASE DE DATOS
if ($mysqli->connect_errno) {
  echo "Error: " . $mysqli->connect_error . "\n";
    
    exit;
}

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

 ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONITOR DE BARRERAS</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style type="text/css">
    	.table-fixed thead {
  width: 97%;
}
.table-fixed tbody {
  height: 230px;
  overflow-y: auto;
  width: 100%;
}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
}
.table-fixed tbody td, .table-fixed thead > tr> th {
  float: left;
  border-bottom-width: 0;
}
    </style>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="../">Monitor de Barreras</a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
               <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li  role="presentation"><a href="../">Inicio </a></li>
                        <!-- <li class="active" role="presentation"><a href="#">Monitor de Barreras </a></li> -->
                        <!-- <li role="presentation"><a href="../cdp">Contador de Pasajeros</a></li> -->
                    </ul>
                </div>
            </div>
        </nav>
        
<?php 





if (isset($_GET['monitor'])) 
{
	$monitor = $_GET['monitor'];
switch ($type) {
	case 0:
	case 1: //mostrar tabla de digitales
		$sql = "
		SELECT r.id, d1, d2, d3,  (d1 * 4 + d2 * 2 + d3 * 1) as binario, addtime(from_unixtime((ts+ IFNULL(c.correccion,0)),'%Y-%m-%d %T'),'03:00:00') as fechax,r.fecha as fechaLlegada ,ts as tsoriginal, (ts+ IFNULL(c.correccion,0)) as ts , duracion ,device_id
	FROM registrodigital r
	LEFT JOIN configuraciones c
	on r.device_id = c.device
	where d1 != 9 and d2 != 9 and d3 != 9
	and r.device_id = $monitor
	having fechax like '%".$filter."%'  
ORDER BY `fechaLlegada`  asc
	";
echo $sql;
if (!$resultado = $mysqli->query($sql)) {
   
    echo "Error: La ejecución de la consulta falló debido a: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
}
?>
<h2>Reporte de Estados del Monitor de Barreras :<?php echo $_GET['monitor']?></h2>
<h3>Mostrando registros del dia: <?php echo $filter;?></h3>

<form>
	<input type="hidden" name="monitor" <?php echo 'value="'.$_GET['monitor'].'"';?>>
	<input type="date" name="f" <?php echo 'value="'.date("Y-m-d").'"';?>>
	<input class="btn btn-success" type="submit" value="Buscar">
</form>
<button class="btn btn-primary" id="export">Exportar XLS</button>
<div>
    <table
class="table2excel table table-responsive" data-tableName="Test Table 1"
    >
        <thead>
            <tr>
                <th data-field="fecha" class="col-md-2">Fecha</th>
                <th data-field="cv">Circuito de vía</th>
                <th data-field="bb">Brazo </br> Bajo</th>
                <th data-field="ba">Brazo </br> Alto</th>
                <th data-field="estado">Estado</th>
                <th data-field="descripcion">Descripción del estado</th>
                <th data-field="duracion">Duración</th>
            </tr>
        </thead>
<?php

$data = [];
while ($res = $resultado->fetch_assoc()) 
{
	$data[] = $res;
}
echo sizeof($data); 
echo "<tbody>";
$estado = "null";
for ($i=0; $i < sizeof($data)-2; $i++) 
{ 
	$r = $data[$i];
	
	switch ($r['binario']) //convito el binario a estado
	{
			case 2:
			// $estado = 0;
					if($estado == 5 )
					{
						$color = "#b7e1cd";
						$observacion = "Desocupado+Alto";
					}
					else
					{
						$color = "#ff9900";
						$observacion = "Anomalía Detectada Desocupado+Alto";
					}
			$estado = 0;
			break;
			case 6:
			// $estado = 1;
					if($estado == 0 )
					{
						$color = "#b7e1cd";
						$observacion = "Ocupado+Alto";
					}
					else
					{
						$color = "#ff9900";
						$observacion = "Anomalía Detectada Ocupado+Alto";
					}
			$estado = 1;
			break;
			case 7:
			// $estado = 2;
					if($estado == 1 )
					{
						$color = "#fce8b2";
						$observacion = "Bajando";
					}
					else
					{
						$color = "#ff9900";
						$observacion = "Anomalía Detectada Bajando";
					}
			$estado = 2;
			break;
			case 5:
			// $estado = 3;
					if($estado == 2 )
					{
						$color = "#f4c7c3";
						$observacion = "Ocupado+Bajo";
					}
					else
					{
						$color = "#ff9900";
						$observacion = "Anomalía Detectada Ocupado+Bajo";
					}
			$estado = 3;
			break;
			case 1:
			// $estado = 4;
				if($estado == 3 )
				{
					$color = "#f4c7c3";
					$observacion = "Desocupado+Bajo";
				}
				else
				{
					$color = "#ff9900";
					$observacion = "Anomalía Detectada Desocupado+Bajo";
				}
			$estado = 4;
			break;
			case 3:
			// $estado = 5;
					if($estado == 4 )
					{
						$color = "#fce8b2";
						$observacion = "Subiendo";
					}
					else
					{
						$color = "#ff9900";
						$observacion = "Anomalía Detectada Subiendo";
					}
			$estado = 5;
			break;
			default:
			$estado = "null";
			$color = "#ff9900";
			$observacion = "Anomalía ??";
			break;
	}



echo '<tr style="background-color:'.$color.'">';
	?>

                <td class="col-md-2"><?php echo $r['fechax']?></td>
                <td><?php echo $r['d1']?"Ocupado":"Desocupado";?></td>
                <td><?php echo $r['d2']?"No Bajo":"Bajo";?></td>
                <td><?php echo $r['d3']?"No Alto":"Alto";?></td>
                <td><?php echo $estado;?></td>
                <td><?php echo $observacion;?></td>
                <td><?php  $total =  $data[$i+1]['duracion'];
                // $total = 685;
$horas = floor($total / 3600);
$minutos = floor(($total - ($horas * 3600)) / 60);
$segundos = floor($total % 60);
echo $horas.":";
echo $minutos<10?"0".$minutos:$minutos;
echo ":";
echo $segundos<10?"0".$segundos:$segundos;
?></td></th>
            </tr>
	<?php
}
echo "</tbody";

echo" </table>";




		break;
	
	default:
		# code...
		break;
}






}
else{
	echo "Error no ah definido un monitor";
}



 ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="dist/jquery.table2excel.min.js"></script>

<script type="text/javascript">
	
	$("#export").click(function(){
		console.log("export")
		$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: <?php echo '"'.$_GET['monitor'].'_'.date("Y-m-d").'.xls"';?>,
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
	})

				
			
	
</script>


</body></html>