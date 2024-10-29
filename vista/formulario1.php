
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulario Alta Alumno</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/estilos-header.css">
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <script src="js/formulario1.js"></script>
</head>

<body>
<header>
    <div class="container">
        <div class="logo">
            <a class="logotipo" href="../index.php"><img src="../vista/img/favicon.png" alt="Logotipo" /></a>
        </div>
        <div class="menu">
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="#">Inscripción</a></li>
            </ul>
        </div>
    </div>
</header>


<h1>Formulario de Alta de nuevo Alumno</h1>
<h2 class="centrado">1️⃣ → Datos personales del Alumno</h2>
<form action="../controlador/controlador.php" method="post">
    <input type="hidden" name="origen" value="formulario1">
    <div class="formulario dosColumnas">
        <div>
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
            </p>

            <p>
                <label for="pApellido">Primer Apellido:</label>
                <input type="text" name="pApellido" id="pApellido">
            </p>

            <p>
                <label for="sApellido">Segundo Apellido:</label>
                <input type="text" name="sApellido" id="sApellido">
            </p>

            <p>
                <label for="dni">DNI:</label>
                <input type="text" name="dni" id="dni">
            </p>

            <p>
                <label for="uEstudio">Último Estudio Cursado:</label>
                <select name="uEstudio" id="uEstudio">
                    <option></option>
                    <?php
                    include_once ("../modelo/conexion.php"); //Invocamos el archivo que carga la base de datos
                    $link=conectar(); // Ejecutamos la función conectar()
                    $consulta="SELECT * FROM nivelestudios"; // Se guarda en una variable la consulta
                    $resultado=mysqli_query($link,$consulta); // Se ejecuta la consulta
                    while ($fila=mysqli_fetch_assoc($resultado)) { // Recorrer el array y guardar en $fila (que es cada registro asociado a cada campo -> ej: $fila["idEstudios"] / $fila["nombreNivel"])
                        echo "<option value='" . $fila["idEstudios"] . "'>" . $fila["nombreNivel"] . "</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="fechaUE">Fecha Último Estudio:</label>
                <input type="date" name="fechaUE" id="fechaUE">
            </p>
        </div>

        <div>
            <p>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono">
            </p>
            <p>
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" id="direccion">
            </p>
            <p>
                <label for="cp">Código Postal:</label>
                <input type="text" name="cp" id="cp">
            </p>
            <p>
                <label for="ciudad">Ciudad:</label>
                <input type="text" name="ciudad" id="ciudad">
            </p>
            <p>
                <label for="privincia">Provincia:</label>
                <select name="provincia" id="provincia">
                    <option></option>
                    <?php
                    include_once ("../modelo/conexion.php"); //Invocamos el archivo que carga la base de datos
                    $link=conectar(); // Ejecutamos la función conectar()
                    $consulta="SELECT * FROM provincia"; // Se guarda en una variable la consulta
                    $resultado=mysqli_query($link,$consulta); // Se ejecuta la consulta
                    while ($fila=mysqli_fetch_assoc($resultado)) // Recorrer el array y guardar en $fila (que es cada registro asociado a cada campo -> ej: $fila["idEstudios"] / $fila["nombreNivel"])
                        echo "<option value='".$fila["idProvincia"]."'>".$fila["nombreProvincia"]."</option>";
                    ?>
                </select>
            </p>
            <p>
                <label for="fNacimiento">Fecha Nacimiento:</label>
                <input type="date" name="fNacimiento" id="fNacimiento">
            </p>
        </div>

        <div class="enviarBoton">
            <input type="submit" name="enviarFormulario1" value="↪️ Siguiente" class="boton">
            <p>
            <?php
            if (!empty($_GET["errores"])) {
                echo $_GET["errores"];
            }
            ?>
            </p>
        </div>
    </div>
</form>

<footer class="pie">
    <div class="c-45">
        <img src="../vista/img/flores.png" alt="Flores">
    </div>
    <div class="c-45 mas-datos">
        <div>
            <h4>Contacto</h4>
            <p>Teléfono</p>
            <p>Instagram</p>
            <p>Facebook</p>
        </div>

        <div>
            <h4>Contacto</h4>
            <p>Teléfono</p>
            <p>Instagram</p>
            <p>Facebook</p>
        </div>

        <div>
            <h4>Sobre Nosotros</h4>
            <p>Historia</p>
            <p>Blog</p>
        </div>
    </div>
</footer>


</body>
</html>