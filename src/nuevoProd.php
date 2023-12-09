<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['enviar'])) {
    $ref = $_POST['ref'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $unidades = $_POST['unidades'];
    $nombreFichero = $_FILES['imgplano']['name'];  // Nombre del archivo
    $imagen = file_get_contents($_FILES['imagen']['tmp_name']);

    if (!empty($ref) && !empty($nombre) && !empty($precio) && !empty($unidades) && !empty($nombreFichero) && !empty($imagen)) {
        include_once 'ConexionSQL.PHP';
        $BD = new ConectarBD();
        $conn = $BD->getConexion();
        $consulta = "SELECT COUNT(*) FROM stock WHERE ref = :ref";

        $nombreDirectorio = "imagenes/";  // Directorio destino donde subir el archivo 
        $nombreCompleto = $nombreDirectorio . $nombreFichero;
        move_uploaded_file($_FILES['imgplano']['tmp_name'], $nombreCompleto);

        $checkStmt = $conn->prepare($consulta);
        $checkStmt->bindParam(':ref', $ref);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();
        $sql = "INSERT INTO stock (ref, nombre, precio, unidades, imgplano, imagen) VALUES (:ref, :nombre, :precio, :unidades, :nombreCompleto, :imagen)";

        if ($count == 0) {
            $insertStmt = $conn->prepare($sql);
            $insertStmt->bindParam(':ref', $ref);
            $insertStmt->bindParam(':nombre', $nombre);
            $insertStmt->bindParam(':precio', $precio);
            $insertStmt->bindParam(':unidades', $unidades);
            $insertStmt->bindParam(':nombreCompleto', $nombreCompleto);
            $insertStmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);
            $insertStmt->execute();

            $BD->cerrarConexion();
            header('Location: Stock.php');
            exit(); // Asegura que el código no continúe ejecutándose después de la redirección
        } else {
            echo "El código del producto ya existe. Ingresa otro código.";
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir un nuevo producto</title>
    <link rel="stylesheet" href="css/nuevoprod.css">
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <p>REFERENCIA: <input type="text" name="ref" required></p>
        <p>NOMBRE: <input type="text" name="nombre" required></p>
        <p>FOTOGRAFIA: <input type="file" name="imgplano" required></p>
        <p>PLANO: <input type="file" name="imagen"></p required>
        <p>PRECIO: <input type="number" name="precio" step="any" required></p>
        <p>UNIDADES: <input type="number" name="unidades" required></p>
        <input type="submit" name="enviar" value="Añadir">
    </form>

    <a href="Stock.php">← Volver</a>
</body>

</html>
