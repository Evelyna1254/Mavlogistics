<?php 
    include_once("conexion.php");
    $con = conectar();

    // Validar la entrada
    $correo = isset($_POST['InputUsuario']) ? $_POST['InputUsuario'] : "";
    $clave = isset($_POST['InputClave']) ? $_POST['InputClave'] : "";

    if (!empty($correo) && !empty($clave)) {
        // Consulta preparada para evitar SQL Injection
        $sql = "SELECT * FROM usuarios WHERE correo = ? AND Clave = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $correo, $clave);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Usuario autenticado correctamente
            // Redirigir al usuario a la página de inicio
            mysqli_close($con);
            header("Location: ../Html/inicio.html");
            exit();
        } else {
            // Usuario no encontrado en la base de datos
            mysqli_close($con);
            header("Location: ../Html/iniciosesion.php");
            exit();
        }
    } else {
        // Datos de entrada faltantes
        header("Location: ../Html/iniciosesion.php");
        exit();
    } 
?>