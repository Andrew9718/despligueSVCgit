<?php
if (isset($_POST['usuario']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['pass'];
    $contraseña2 = $_POST['pass2'];
    $permiso = $_POST['permiso'];

    if ($contraseña == $contraseña2) {
        $contra = sha1($contraseña2);

        include_once 'ConexionSQL.PHP';
        $BD = new ConectarBD();
        $conn = $BD->getConexion();

        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
        $checkStmt->bindParam(':usuario', $usuario);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count == 0) {
            $insertStmt = $conn->prepare("INSERT INTO usuarios (usuario, contrasena, permiso) VALUES (:usuario, :contra, :permiso)");
            $insertStmt->bindParam(':usuario', $usuario);
            $insertStmt->bindParam(':contra', $contra);
            $insertStmt->bindParam(':permiso', $permiso);
            $insertStmt->execute();

            $BD->cerrarConexion();
            // Movemos la redirección fuera del bloque condicional
            header('Location: nuevousuario.php');
            exit(); // Añadimos exit para asegurarnos de que no se ejecute más código después de la redirección
        } else {
            echo "El usuario ya existe";
        }
    } else {
        echo "Las contraseñas no coinciden";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nuevousuario.css">
    <title>Administrar usuarios</title>
</head>

<body>
    <h3>Usuarios actuales</h3>
    <?php
    include_once 'ConexionSQL.PHP';
    $BD = new ConectarBD();
    $conn = $BD->getConexion();

    $stmt = $conn->prepare('SELECT * FROM usuarios');
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    while ($usuarios = $stmt->fetch()) {
        echo "<div class='info'>Usuario: {$usuarios['usuario']} - Permisos: {$usuarios['permiso']} >>>>>><a href='eliminar_usuario.php?id={$usuarios['id']}'>ELIMINAR</a></div>";
    }
    $BD->cerrarConexion();
    ?>

    <h3>Dar de alta un nuevo usuario</h3>
    <div class="container">
        <form action="" method="post">
            <div>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" required>
            </div>
            <div>
                <label for="pass">Contraseña:</label>
                <input type="password" name="pass" required>
            </div>
            <div>
                <label for="pass2">Repite la Contraseña:</label>
                <input type="password" name="pass2" required>
            </div>
            <div>
                <label for="permiso">Permiso:</label>
                <select name="permiso">
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <input type="submit" value="Añadir">
        </form>
    </div>

    <a href="Stock.php" id="volver">← Volver</a>

</body>

</html>
