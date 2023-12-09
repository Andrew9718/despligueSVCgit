<?php
include_once 'ConexionSQL.PHP';
$BD = new ConectarBD();
$conn = $BD->getConexion();

$id = $_GET['id'];

$stmt = $conn->prepare('SELECT imagen FROM stock WHERE id = :id');
$stmt->bindParam(':id', $id);
$stmt->execute();

// Verifica si la consulta fue exitosa
if ($stmt->rowCount() == 1) {
    // Obtiene la fila de resultados
    $row = $stmt->fetch();

    // Configura las cabeceras para la descarga de la imagen
    header('Content-Type: image/jpeg');
    header('Content-Disposition: attachment; filename="imagen_descargada.jpg"');

    // Muestra la imagen
    echo $row['imagen'];
} else {
    // Si no se encuentra la imagen, muestra un mensaje de error
    echo "Imagen no encontrada.";
}
?>
