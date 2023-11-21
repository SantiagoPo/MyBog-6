<?php
include_once('config/conexion.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: main.php'); // Redirige a la página de inicio de sesión si el usuario no está conectado.
    exit;
}

if (isset($_GET['id'])) {
    $establecimientoId = $_GET['id'];

    // Consulta para obtener los detalles del establecimiento a editar
    $sql = "SELECT * FROM registro_de_establecimiento WHERE Id_registro = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $establecimientoId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        // Manejar el caso en que el establecimiento no se encuentre en la base de datos.
        echo "El establecimiento no se encuentra en la base de datos.";
        exit;
    }
} else {
    // Manejar el caso en que no se proporcionó un ID válido.
    echo "ID de establecimiento no válido.";
    exit;
}

// Procesa el formulario de edición si se envió.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_establecimiento'])) {
    $nombreEstablecimiento = $_POST['nombre_establecimiento'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $informacionAdicional = $_POST['informacion_adicional'];
    $nit = $_POST['nit'];
    $localidad = $_POST['localidad'];
    $tipoEstablecimiento = $_POST['tipo_establecimiento'];

    // Consulta para actualizar los detalles del establecimiento en la base de datos
    $sql = "UPDATE registro_de_establecimiento SET Nombre_del_establecimiento=?, Direccion_de_establecimiento=?, Telefono=?, Informacion_adicional=?, Nit=?, localidad=?, id_tipo_de_establecimiento=? WHERE Id_registro=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssssi", $nombreEstablecimiento, $direccion, $telefono, $informacionAdicional, $nit, $localidad, $tipoEstablecimiento, $establecimientoId);

    if ($stmt->execute()) {
        // Establecimiento actualizado con éxito, puedes redirigir a una página de éxito o mostrar un mensaje aquí.
        echo '<div class="alert alert-success" role="alert">
        Establecimiento registrado de forma exitosa
        </div>';
    } else {
        // Error al actualizar el establecimiento, muestra un mensaje de error.
        echo "Error al actualizar el establecimiento: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Establecimiento</title>
    <!-- Agrega los enlaces a las bibliotecas de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./style/HeaderFooter.css">
    <link rel="stylesheet" type="text/css" href="./style/inicio.css">
</head>

<body>
    <div class="wrapper">
        <nav id="custom-navbar" class="navbar navbar-expand-lg navbar-light navbar-dark-bg">
            <div class="container-fluid" id="header">
                <a class="navbar-brand Logo" href="./index.php"><img src="./Imagenes/Logo.png" alt="Logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item">
                            <a class="nav-link rojo" id="mapa" href="./mapa.php">Mapa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link amarillo" id="calendario" href="./calendario.php">Calendario</a>
                        </li>
                        <?php
                        if (isset($_SESSION['user_id'])) {
                            echo '<li class="nav-item">
                            <a class="nav-link amarillo" id="calendario" href="./reg_establecimiento.php">registra tu establecimiento</a>
                            </li>';
                        } else {
                            echo '';
                        }
                        include('modales_usuario.php');
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form method="post" action="" class="editar">
                        <h2 class="mb-4">Editar Establecimiento</h2>

                        <div class="form-group">
                            <label for="nombre_establecimiento">Nombre del Establecimiento:</label>
                            <input type="text" class="form-control" id="nombre_establecimiento"
                                name="nombre_establecimiento" value="<?php echo $row['Nombre_del_establecimiento']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                value="<?php echo $row['Direccion_de_establecimiento']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                value="<?php echo $row['Telefono']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="informacion_adicional">Información Adicional:</label>
                            <textarea class="form-control" id="informacion_adicional"
                                name="informacion_adicional"><?php echo $row['Informacion_adicional']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="nit">NIT:</label>
                            <input type="text" class="form-control" id="nit" name="nit"
                                value="<?php echo $row['Nit']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="localidad">Localidad:</label>
                            <?php if ($row['localidad'] == 'Chapinero') {
                                echo 'selected';
                            } ?>
                            <select class="form-control" name="localidad" required>
                                <option value="" disabled selected>Seleccione La Localidad</option>
                                <option value="Chapinero" <?php if ($row['localidad'] == 'Chapinero') {
                                    echo 'selected';
                                } ?>>Chapinero</option>
                                <option value="Santa Fe" <?php if ($row['localidad'] == 'Santa Fe') {
                                    echo 'selected';
                                } ?>>Santa Fe</option>
                                <option value="San Cristobal" <?php if ($row['localidad'] == 'San Cristobal') {
                                    echo 'selected';
                                } ?>>San Cristobal</option>
                                <option value="Usme" <?php if ($row['localidad'] == 'Usme') {
                                    echo 'selected';
                                } ?>>Usmeo
                                </option>
                                <option value="Tunjuelito" <?php if ($row['localidad'] == 'Tunjuelito') {
                                    echo 'selected';
                                } ?>>Tunjuelito</option>
                                <option value="Bosa" <?php if ($row['localidad'] == 'Bosa') {
                                    echo 'selected';
                                } ?>>Bosa
                                </option>
                                <option value="Kennedy" <?php if ($row['localidad'] == 'Kennedy') {
                                    echo 'selected';
                                } ?>>
                                    Kennedy</option>
                                <option value="Suba" <?php if ($row['localidad'] == 'Suba') {
                                    echo 'selected';
                                } ?>>Suba
                                </option>
                                <option value="Usaquén" <?php if ($row['localidad'] == 'Usaquén') {
                                    echo 'selected';
                                } ?>>
                                    Usaquén</option>
                                <option value="Barrios Unidos" <?php if ($row['localidad'] == 'Barrios Unidos') {
                                    echo 'selected';
                                } ?>>Barrios Unidos</option>
                                <option value="Teusaquillo" <?php if ($row['localidad'] == 'Teusaquillo') {
                                    echo 'selected';
                                } ?>>Teusaquillo</option>
                                <option value="Los Mártires" <?php if ($row['localidad'] == 'Los Mártires') {
                                    echo 'selected';
                                } ?>>Los Mártires</option>
                                <option value="Puente Aranda" <?php if ($row['localidad'] == 'Puente Aranda') {
                                    echo 'selected';
                                } ?>>Puente Aranda</option>
                                <option value="La Candelaria" <?php if ($row['localidad'] == 'La Candelaria') {
                                    echo 'selected';
                                } ?>>La Candelaria</option>
                                <option value="Rafael Uribe Uribe" <?php if ($row['localidad'] == 'Rafael Uribe Uribe') {
                                    echo 'selected';
                                } ?>>Rafael Uribe Uribe</option>
                                <option value="Ciudad Bolívar" <?php if ($row['localidad'] == 'Ciudad Bolivar') {
                                    echo 'selected';
                                } ?>>Ciudad Bolívar</option>
                                <option value="Sumapaz" <?php if ($row['localidad'] == 'Sumapaz') {
                                    echo 'selected';
                                } ?>>
                                    Sumapaz</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipo_establecimiento">Tipo de Establecimiento:</label>
                            <select class="form-control" name="tipo_establecimiento" required>
                                <option value="" disabled selected>Seleccione el Tipo de Establecimiento</option>
                                <option value="restaurante" <?php if ($row['id_tipo_de_establecimiento'] == 'restaurante') {
                                    echo 'selected';
                                } ?>>Restaurante</option>
                                <option value="hotel" <?php if ($row['id_tipo_de_establecimiento'] == 'hotel') {
                                    echo 'selected';
                                } ?>>Hotel</option>
                                <option value="tienda" <?php if ($row['id_tipo_de_establecimiento'] == 'tienda') {
                                    echo 'selected';
                                } ?>>Tienda</option>
                            </select>
                        </div>
                        <button type="submit" name="editar_establecimiento" class="btn btn-primary">Guardar
                            Cambios</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php
    include('modales_footer.php');
    ?>
    <footer class="footer">
        <nav>
            <ul>
                <li><a href="#" data-toggle="modal" data-target="#modalPoliticaPrivacidad">Política de
                        privacidad</a></li>
                <li><a href="#" data-toggle="modal" data-target="#modalTerminosCondiciones">Términos y
                        condiciones</a></li>
                <li><a href="#" data-toggle="modal" data-target="#modalContacto">Contacto</a></li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '';
                } else {
                    echo '<li><a data-toggle="modal" data-target="#myModal" href="#">deseas registrar tu establecimiento</a></li>';
                }
                ?>

            </ul>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Mensaje</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            Debes estar logeado/Registrado para utilizar este servicio.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <p>©
                <?php echo date("Y"); ?> MyBog. Todos los derechos reservados.
            </p>
        </nav>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./Funcionamiento_por_js/editar_usuario.js"></script>
    <script src="./Funcionamiento_por_js/search_index.js"></script>

</body>

</html>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        background-color: #ffffff;
    }

    .container {
        margin-top: 30px;

    }

    @media (max-width: 1200px) {
        .container {
            padding-bottom: 150px;
        }
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 15px;
        box-sizing: border-box;
    }

    .editar h2 {
        margin: 0;
        padding: 0;
        color: #f2163e;
        text-align: center;
        margin-bottom: 30px;
    }

    .editar .form-group {
        position: relative;
    }

    .editar .form-control {
        width: 100%;
        padding: 8px;
        font-size: 16px;
        color: #000000;
        margin-bottom: 30px;
        border: none;
        border-radius: 10px;
        outline: none;
        background-color: #f5f5f5;
        transition: 0.3s;
    }

    .editar .form-control {
        border: 2px solid #cacaca;
    }

    .editar .form-control:focus {
        border: 2px solid #ff0000;
    }

    .editar .form-group label {
        color: #575757;
        font-size: 16px;
        transition: 0.3s;
        pointer-events: none;
    }

    .editar .form-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .editar .form-group {
        display: block;
        margin-bottom: 10px;
    }

    .editar button {
        margin: 20px auto;
        display: block;
        padding: 10px 20px;
        text-transform: uppercase;
        border-radius: 5px;
        color: #3c3c3c;
        text-decoration: none;
        overflow: hidden;
        transition: .5s;
        background-color: transparent;
        border: none;
        cursor: pointer;
        border-bottom: solid 1px rgba(255, 0, 0, 0.6);
        background-color: rgba(255, 0, 0, 0.1);
        box-shadow: 0 0 2px #ff0000, 0 0 2px #ff0000, 0 0 2px #ff0202, 0 0 0px #ff0000
    }

    .editar button:hover {
        text-decoration: none;
        background: rgba(255, 0, 0, 0.4);
        color: black;
        border-radius: 5px;
        box-shadow: 0 0 2px #ff0000, 0 0 4px #ff0000, 0 0 6px #ff0202, 0 0 8px #ff0000;
    }
</style>