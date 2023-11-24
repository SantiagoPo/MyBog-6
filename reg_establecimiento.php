<?php
include_once('config/conexion.php');

if (!isset($_SESSION['user_id'])) {
    // Redirige a main.php
    header('Location: ./main.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Establecimiento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/HeaderFooter.css">
    <link rel="stylesheet" type="text/css" href="style/Style_reg_establecimiento.css">
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
            <h2>Registro de Establecimiento</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-box">
                        <form action="php/procesar_registro_establecimiento.php" method="post"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" class="form-control" name="nombre_establecimiento" required>
                                <label>Nombre del Establecimiento</label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="localidad" required>
                                    <option value="" disabled selected>Seleccione La Localidad</option>
                                    <option value="Chapinero">Chapinero</option>
                                    <option value="Santa Fe">Santa Fe</option>
                                    <option value="San Cristobal">San Cristobal</option>
                                    <option value="Usme">Usmeo</option>
                                    <option value="Tunjuelito">Tunjuelito</option>
                                    <option value="Bosa">Bosa</option>
                                    <option value="Kennedy">Kennedy</option>
                                    <option value="Suba">Suba</option>
                                    <option value="Usaquén">Usaquén</option>
                                    <option value="Barrios Unidos">Barrios Unidos</option>
                                    <option value="Teusaquillo">Teusaquillo</option>
                                    <option value="Los Mártires">Los Mártires</option>
                                    <option value="Puente Aranda">Puente Aranda</option>
                                    <option value="La Candelaria">La Candelaria</option>
                                    <option value="Rafael Uribe Uribe">Rafael Uribe Uribe</option>
                                    <option value="Ciudad Bolívar">Ciudad Bolívar</option>
                                    <option value="Sumapaz">Sumapaz</option </select>
                                </select>
                                <label>Localidad</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="direccion" required>
                                <label for="">direccion</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="telefono" required>
                                <label>Teléfono</label>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="informacion_adicional"
                                    required></textarea>
                                <label>Información Adicional</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="nit" required>
                                <label>NIT</label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="tipo_establecimiento" required>
                                    <option value="" disabled selected>Seleccione el Tipo de Establecimiento</option>
                                    <option value="restaurante">Restaurante</option>
                                    <option value="hotel">Hotel</option>
                                    <option value="tienda">Tienda</option>
                                </select>
                                <label>Tipo de Establecimiento</label>
                            </div>
                            <div class="form-group"><label class="labelfotos">
                                    Seleccionar archivos
                                </label>
                            </div>
                            <div class="input-group mb-3">
                                <label for="photos" class="custom-file-label"></label>
                                <input type="file" class="custom-file-input" id="photos" name="photos[]"
                                    accept="image/*" multiple required onchange="handleFileSelect(event)">
                                <div id="image-preview" class="image-preview"></div>
                            </div>
                            <div class="thumbnail-container" id="thumbnail-container"></div>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Enviar Registro</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div>
                </div>
            </div>
        </div>
       <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="modalImage" class="img-fluid" src="" alt="Image Preview">
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
                </ul>
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
        <script src=".Funcionamiento_por_js/reg_establecimiento.js"></script>
        <script>
            document.getElementById('photos').addEventListener('change', function (e) {
                var label = document.querySelector('.custom-file-label');
                var files = e.target.files;

                if (files.length > 1) {
                    label.textContent = files.length + ' archivos seleccionados';
                } else {
                    label.textContent = files[0].name;
                }

                handleFileSelect(files);
            });

            function handleFileSelect(files) {
                var container = document.getElementById('thumbnail-container');
                var imagePreview = document.getElementById('image-preview');

                // Limpiar el contenedor de miniaturas
                container.innerHTML = '';

                // Limpiar la imagen de la vista previa
                imagePreview.innerHTML = '';

                // Verificar si hay archivos seleccionados
                if (files.length > 0) {
                    // Mostrar el contenedor de miniaturas
                    container.style.display = 'flex';

                    // Crear miniaturas y agregar al contenedor
                    for (var i = 0; i < files.length; i++) {
                        var thumbnail = document.createElement('img');
                        thumbnail.className = 'thumbnail';
                        thumbnail.src = URL.createObjectURL(files[i]);
                        thumbnail.addEventListener('click', function (event) {
                            toggleThumbnailSelection(event, files);
                        });
                        container.appendChild(thumbnail);
                    }

                    // Mostrar la imagen seleccionada en la vista previa
                    var thumbnails = document.querySelectorAll('.thumbnail');
                    thumbnails.forEach(function (thumbnail, index) {
                        thumbnail.addEventListener('click', function () {
                            openImageModal(files, index);
                        });
                    });
                }
            }

            // Function to open the image modal
            function openImageModal(files, index) {
                var modalImage = document.getElementById('modalImage');
                modalImage.src = URL.createObjectURL(files[index]);

                $('#imageModal').modal('show');
            }
            // Update the openImageModal function
            function openImageModal(files, index) {
                var modalImage = document.getElementById('modalImage');
                var modalTitle = document.getElementById('imageModalLabel');

                modalImage.src = URL.createObjectURL(files[index]);

                // Set the modal title to the name of the image
                var imageName = files[index].name;
                modalTitle.innerHTML = imageName;

                $('#imageModal').modal('show');
            }

        </script>



</body>

</html>

<style>
    .thumbnail-container {
        display: none;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 40px;
        border: 2px solid #cacaca;
        padding: 10px 10px 0px 10px;
        border-radius: 10px;
    }


    .thumbnail {
        border: 2px solid #cacaca;
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: border 0.3s ease;
    }

    .thumbnail:hover {
        border: 2px solid #FFFB00;
    }

    .thumbnail.selected {
        border: 2px solid #ff0000;

    }


    .custom-file-input {
        display: none;
    }

    .custom-file-label {
        background-color: #f5f5f5;
        color: black;
        border: 2px solid #cacaca;
        padding: 8px 12px;
        border-radius: 10px;
        cursor: pointer;
        display: inline-block;
    }

    .labelfotos {
        display: block;
    }

    .btn {
        width: 30%;
        display: block;
        margin: 40px auto;
        padding: 7px 10px;
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

    .btn:hover {
        text-decoration: none;
        background: rgba(255, 0, 0, 0.4);
        color: black;
        border-radius: 5px;
        box-shadow: 0 0 2px #ff0000, 0 0 4px #ff0000, 0 0 6px #ff0202, 0 0 8px #ff0000;
    }

    #image-preview {
        display: none;
    }

    .modal-dialog .modal-body {
        text-align: center;
    }

    #modalImage {
        max-height: 400px;
        height: auto;
        margin: 0 auto;
    }

    .modal-dialog .modal-content {
        background-color: white
    }

    .modal-dialog .modal-header {
        text-align: center;
        color: #3c3c3c;
    }

    .modal-dialog .modal-body {
        text-align: center;
        padding: 20px;
    }


    h2 {
        margin: 0;
        padding: 0;
        color: #f2163e;
        text-align: center;
        margin-bottom: 60px;
    }
</style>