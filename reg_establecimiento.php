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
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-box">
                        <h2>Registro de Establecimiento</h2>
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
                            <div class="form-group">
                                <label for="photos">Fotos</label>
                                <input type="file" class="form-control-file" id="photos" name="photos[]"
                                    accept="image/*" multiple required>
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Enviar Registro</button>
                            </div>
                        </form>
                    </div>
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
        document.addEventListener("DOMContentLoaded", function () {
            const slider = document.querySelector(".slide ul");
            const slides = document.querySelectorAll(".slide li");
            const controls = document.querySelectorAll(".slider-control");

            let currentIndex = 0;
            const slideCount = slides.length;
            const slideWidth = slides[0].clientWidth;
            const intervalTime = 3000;

            function nextSlide() {
                currentIndex = (currentIndex + 1) % slideCount;
                updateSlider();
            }

            function updateSlider() {
                const translateX = -currentIndex * slideWidth;
                slider.style.transform = `translateX(${translateX}px)`;

                // Actualiza los botones de control
                controls.forEach((control, index) => {
                    if (index === currentIndex) {
                        control.classList.add("active");
                    } else {
                        control.classList.remove("active");
                    }
                });
            }

            setInterval(nextSlide, intervalTime);

            // Agrega eventos a los botones de control
            controls.forEach((control, index) => {
                control.addEventListener("click", () => {
                    currentIndex = index;
                    updateSlider();
                });
            });
        });
    </script>


</body>

</html>