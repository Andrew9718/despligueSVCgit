<?php
if (isset($_POST['enviar'])) {
    $respuesta = $_POST['respuesta'];

    if ($respuesta == 'SI') {
        $id = $_GET['id'];

        include_once 'ConexionSQL.PHP';
        $BD = new ConectarBD();
        $conn = $BD->getConexion();
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $BD->cerrarConexion();

        // Redirige después de realizar la eliminación
        header('Location: nuevousuario.php');
        exit(); // Asegura que el código no continúe ejecutándose después de la redirección
    } else {
        // Redirige si la respuesta es 'NO'
        header('Location: nuevousuario.php');
        exit(); // Asegura que el código no continúe ejecutándose después de la redirección
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/eliminaruser.css">
    <title>Eliminar Producto</title>
</head>

<body>
    <h1>Eliminar Usuario</h1>
    <form action="" method="post">
        <p>¿Está seguro de que desea eliminar este Usuario?</p>
        <input type="radio" name="respuesta" value="SI" id="si">
        <label for="si">SI</label>
        <input type="radio" name="respuesta" value="NO" id="no">
        <label for="no">NO</label>
        <input type="submit" name="enviar" value="Confirmar">
    </form>

    <a href="Stock.php" id="volver">← Volver</a>
</body>

</html>
