<?php 

header('Content-Type: application/json; charset=UTF-8');
// CONTADOR
date_default_timezone_set('America/Argentina/Buenos_Aires');
$mysqli = new mysqli('127.0.0.1', 'root', '', 'dimba');

if ($mysqli->connect_errno) {
  echo "Error: " . $mysqli->connect_error . "\n";
    
    exit;
}


// filtro

switch ($_GET['filter']) {
	case 'hour':
	$query = "SELECT *  FROM `cdp` 
where payload like '%Header%' AND
timestamp >= NOW() - INTERVAL 1 HOUR
ORDER BY `timestamp`  DESC";
		break;
	case 'weak':
	$query = "SELECT * FROM `cdp` 
where payload like '%Header%' AND
timestamp >= NOW() - INTERVAL 1 WEEK
ORDER BY `timestamp`  DESC";
break;
case 'day':
	$query = "SELECT * FROM `cdp` 
where payload like '%Header%' AND
timestamp >= NOW() - INTERVAL 1 DAY
ORDER BY `timestamp`  DESC";
break;
	default:
		# code...
		break;
}




if (!$resultado = $mysqli->query($query)) {
   
    echo "Error: La ejecución de la consulta falló debido a: \n";
    echo "Query: " . $query . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
}


$data = [];
while ($res = $resultado->fetch_assoc()) 
{
	$payload = utf8_encode($res['payload']);
	$data[] = array('topic'=>$res["topic"],'timestamp'=>$res["timestamp"],'payload'=>$payload);
}

echo json_encode($data);






 ?>