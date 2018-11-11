<?php 

// DIMAB

$mysqli = new mysqli('127.0.0.1', 'root', '', 'dimba');

if ($mysqli->connect_errno) {
  echo "Error: " . $mysqli->connect_error . "\n";
    
    exit;
}


$sql = "SELECT * FROM dimba order by timestamp " ;
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
	$data[] = $res;
}



echo json_encode($data);


 ?>