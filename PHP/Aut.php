<?php
session_start();
require_once('conexion1.php');


    $usuario = isset($_POST['InputUsuario']) ? $_POST['InputUsuario'] : "";
    $clave = isset($_POST['InputClave']) ? $_POST['InputClave'] : "";

    // Conexión a la base de datos
    $conn = conectar();

    if ($conn) {
        // Consulta SQL para verificar las credenciales del usuario
        $query = "SELECT * FROM Tbl_Usuarios WHERE Usuario = '$usuario' AND Clave =  '$clave'";
        $stmt = $conn->prepare($query);
        $stmt->execute([$usuario, $clave]);

        // Obtener la primera fila del resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró un usuario con las credenciales proporcionadas
        if ($result !== false) {
            // Usuario autenticado correctamente
            $_SESSION['Usuario'] = $usuario;

            // Si se seleccionó el checkbox de recordar sesión, establecer una cookie
            if(isset($_POST['recordar']) && $_POST['recordar'] == 'si') {
                setcookie('Usuario', $usuario, time() + (86400 * 30), "/"); // Cookie válida por 30 días
            }

            // Redireccionar al usuario a la página de inicio
            header("Location: ../Html/inicio.html");
            exit;
        } else {
            // Si las credenciales son incorrectas, mostrar un mensaje de error
            header("Location: ../Html/iniciosesion.php");
        }
    } else {
        header("Location: ../Html/iniciosesion.php");
    }


?>
