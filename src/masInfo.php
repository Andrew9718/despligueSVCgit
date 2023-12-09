<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/masinfo.css">
    <title>Informacion</title>
    <style>
       
    </style>
</head>
<body>

<?php

include_once 'ConexionSQL.PHP';
$BD = new ConectarBD();
$conn = $BD->getConexion();
$id = $_GET['id'];

$stmt = $conn->prepare('SELECT * FROM stock where id = :id');
$stmt->bindParam(':id', $id);
$stmt->execute();

while ($producto = $stmt->fetch()) {
    echo "<div class='contenedor'>";
    echo "<div id='titulo'>" . 'Referencia: ' . $producto['ref'] . "</div>";
    echo "<div>" . 'Nombre: ' . $producto['nombre'] . "</div>";
    echo '<div><img src="' . $producto['imgplano'] . '" alt="' . $producto['nombre'] . '"></div>';
    echo "<div>" . 'Precio: ' . $producto['precio'] .'€'. "</div>";
    echo "<div>" . 'Cantidad a producir: ' . $producto['unidades'] . "</div>";
    echo "</div>";
    echo "<div><a href='descargar.php?id=" . $producto['id'] . "'>Descargar Plano</a></div>";
}
?>

<a href="Stock.php">← Volver</a>


    
</body>
</html>
