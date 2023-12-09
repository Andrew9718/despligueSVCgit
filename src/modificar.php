<?php
if (isset($_POST['enviar'])) {
    $id = $_GET['id'];
    $dato = $_POST['datos'];
    $nuevo = $_POST['nuevo'];

    include_once 'ConexionSQL.PHP';
    $BD = new ConectarBD();
    $conn = $BD->getConexion();

    $stmt = $conn->prepare("UPDATE stock SET $dato = :nuevo WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nuevo', $nuevo);
    $stmt->execute();

    $BD->cerrarConexion();

    // Redirige después de realizar la modificación
    header('Location: Stock.php');
    exit(); // Asegura que el código no continúe ejecutándose después de la redirección
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/modificar.css">
    <title>Modificar una Pieza</title>
</head>

<body>
    <h1 id="titulo">Modificar una Pieza</h1>

    <div class="contenedor">
        <form action="" method="post">
            <p>Qué quieres modificar:</p>
            <select name="datos" id="datos">
                <option value="ref">REFERENCIA</option>
                <option value="nombre">NOMBRE</option>
                <option value="precio">PRECIO</option>
                <option value="unidades">UNIDADES</option>
            </select>
            <p>Introduce el cambio: </p>
            <input type="text" name="nuevo" id="nuevo" required>
            <input type="submit" name="enviar" value="Modificar">
        </form>
    </div>

    <a href="Stock.php" id="volver">← Volver</a>

</body>

</html>
