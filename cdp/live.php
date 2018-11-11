<?php 
header('Content-Type: application/json; charset=UTF-8');
// CONTADOR

$mysqli = new mysqli('127.0.0.1', 'root', '', 'dimba');

if ($mysqli->connect_errno) {
  echo "Error: " . $mysqli->connect_error . "\n";
    
    exit;
}


$sql = "SELECT * FROM `cdp` order by timestamp desc limit 0,500" ;
if (!$resultado = $mysqli->query($sql)) {
   
    echo "Error: La ejecución de la consulta falló debido a: \n";
    echo "Query: " . $sql . "\n";
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
// print_r( $data);


 ?>