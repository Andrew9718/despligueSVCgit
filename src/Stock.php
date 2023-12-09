<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
} else {
    // El usuario está autenticado, puedes acceder a $_SESSION['usuario'] y $_SESSION['permiso'].
    $usuario = $_SESSION['usuario'];
    $permiso = $_SESSION['permiso'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stock.css">
    <title>Control de Stock</title>
</head>

<body>
    <div class="container">
        <h1>Bienvenido <?php echo $usuario ?></h1>

        <table border="1" id="tabla">
            <tr>
                <th>REFERENCIA</th>
                <th>NOMBRE</th>
                <th>FOTOGRAFIA</th>
                <th>PLANO</th>
                <th>PRECIO POR UNIDAD</th>
                <th>UNIDADES</th>
                <th>ACCIONES</th>
            </tr>

            <?php
            include_once 'ConexionSQL.PHP';
            $BD = new ConectarBD();
            $conn = $BD->getConexion();

            $stmt = $conn->prepare('SELECT * FROM stock');
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            while ($producto = $stmt->fetch()) {
                $id = $producto['id'];
                echo "<tr>";
                echo "<td>" . $producto['ref'] . "</td><td>" . $producto['nombre'] . "</td>";

                // Mostrar las imágenes en una celda cada una
                echo '<td><img src="' . $producto['imgplano'] . '" alt="' . $producto['nombre'] . '"></td>'; //imagen de archivo local
                echo '<td><img src="data:image/jpeg;base64,' . base64_encode($producto['imagen']) . '" /></td>'; //imagen del archivo binario

                echo "<td>" . $producto['precio'] . '€' . "</td><td>" . $producto['unidades'] . "</td>";

                if ($permiso == 'admin') {
                    echo "<td><a href='modificar.php?id=" . $id . "' class='btn-modificar'>Modificar</a>-/-<a href='eliminar.php?id=" . $id . "' class='btn-eliminar'>Eliminar</a></td>";
                } else {
                    echo "<td><a href='masInfo.php?id=" . $id . "' class='btn-informacion'>Información</a></td>";
                }

                echo "</tr>";
            }

            if ($permiso == 'admin') {
                echo "<a href='nuevoProd.php' id='letras'>Añadir un nuevo Producto</a>";
                echo "<a href='nuevousuario.php' id='letras'>Administrador de usuarios</a>";
            }

            $BD->cerrarConexion();
            ?>
        </table>

        <a href="cerrarsesion.php" id="cerrar-sesion">Cerrar sesión</a>
    </div>

</body>

</html>
