<?php
session_start();
ob_start();

if (isset($_POST['enviar'])) {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];

    if (!empty($nombre) && !empty($password)) {
        include_once 'ConexionSQL.PHP';
        $BD = new ConectarBD(); // conectamos a la base de datos con el documento externo
        $conn = $BD->getConexion();
        $hashedPassword = sha1($password);

        $stmt = $conn->prepare('SELECT * FROM usuarios WHERE usuario = :usuario AND contrasena = :contrasena');
        // realizamos la consulta para verificar si existe el usuario y la contraseña sea igual
        $stmt->bindParam(':usuario', $nombre);
        $stmt->bindParam(':contrasena', $hashedPassword);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // si ha encontrado al menos 1 usuario que coincida, guarda las variables en la session
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            // Almacenar la información en la sesión

            $_SESSION['usuario'] = $usuario['usuario'];
            $_SESSION['permiso'] = $usuario['permiso'];
            // Redirige al usuario a la página principal
            header('Location: Stock.php');
        } else {
            // aviso si no ha encontrado usuario o si la contraseña no es correcta
            echo "<h3 id='incorrecto'>Usuario o contraseña incorrectos</h3>";
        }
    } else {
        // y evitamos que el usuario deje campos vacíos
        echo "Ambos campos son obligatorios";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>LOGIN DATA</title>
</head>

<body>
    <h1 id="titulo">SISTEMA DE GESTIÓN DE STOCK</h1>

    <div class="contenedor">
        <form action="#" method="post">
            <div class="imgcontainer">
                <img src="avatar.jpg" alt="Avatar" class="avatar">
            </div>

            <div class="container">
                <label for="nombre"><b>Nombre de Usuario</b></label>
                <input type="text" placeholder="Introduce nombre de usuario" name="nombre" required>

                <label for="password"><b>Contraseña</b></label>
                <input type="password" placeholder="Introduce contraseña" name="password" required>

                <button type="submit" id="buton" name="enviar">Entrar</button>
            </div>
        </form>
    </div>
</body>

</html>