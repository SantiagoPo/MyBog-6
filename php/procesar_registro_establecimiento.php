<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php
include('../config/conexion.php');

if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreEstablecimiento = $_POST['nombre_establecimiento'];
    $localidad = $_POST['localidad'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $nit = $_POST['nit'];
    $tipoEstablecimiento = $_POST['tipo_establecimiento'];
    $informacionAdicional = $_POST['informacion_adicional'];

    $archivos = $_FILES['photos']['name'];
    $carpeta_destino = 'Imagen_guardar/';

    foreach ($archivos as $key => $archivo) {
        $nombre_archivo = $archivo;
        $archivo_temporal = $_FILES['photos']['tmp_name'][$key];
        $ruta_destino = $carpeta_destino . $nombre_archivo;

        move_uploaded_file($archivo_temporal, $ruta_destino);
    }

    // Utiliza parámetros preparados para evitar problemas de seguridad y consultas SQL inseguras
    $sql = "INSERT INTO registro_de_establecimiento (Nombre_del_establecimiento, Direccion_de_establecimiento, Id_Usuario, Telefono, Informacion_adicional, Nit, localidad, id_tipo_de_establecimiento)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssisssss", $nombreEstablecimiento, $direccion, $_SESSION['user_id'], $telefono, $informacionAdicional, $nit, $localidad, $tipoEstablecimiento);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">
        Registro. Serás redireccionado en 3 segundos.
        </div>';
        echo '<script> setTimeout(function(){ window.location.href = "../index.php"; }, 3000); </script>';
        exit();
    } else {
        // Error al insertar los datos
        echo 'Error al registrar el establecimiento: ' . $stmt->error;
    }

    $stmt->close();
} else {
    echo 'Error: No hay datos para procesar o el usuario no está autenticado.';
    exit();
}

$conexion->close();
?>