<?php
session_start();
if (empty($_SESSION['insertarAlumno'])) {
    header("Location: formulario1.php?errores=No se puede confirmar porque debe completar todos los campos");
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario 2</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/estilos-header.css">
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <script src="js/formulario2.js"></script>
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
<h2 class="centrado">2️⃣→ Datos de persona Contacto</h2>
<form action="../controlador/controlador.php">
    <input type="hidden" name="origen" value="formulario2">
    <div class="formulario unaColumna">
        <div>
            <p>
                <label for="nombreFamiliar">Nombre persona Contacto</label>
                <input type="text" name="nombreFamiliar" id="nombreFamiliar">
            </p>

            <p>
                <label for="telefonoFamiliar">Teléfono persona Contacto</label>
                <input type="text" name="telefonoFamiliar" id="telefonoFamiliar">
            </p>

            <p>
                <label for="relacion">Relación:</label>
                <select name="relacion" id="relacion">
                    <option value=""></option>
                    <?php
                    include_once("../modelo/conexion.php"); //invocamos el archivo que carga la BBDD
                    $link = conectar();//ejecutas la funcion conectar()
                    $consulta = "SELECT * FROM parentesco"; //se guarda en una variable la consulta
                    $resultado = mysqli_query($link, $consulta);//se ejecuta la consulta
                    while ($fila = mysqli_fetch_assoc($resultado)) { //recorrer el array y guardar en $fila que es cada
                        //registro asociado a cada campo-> ej: $fila["idEstudios"]   / $fila["nombreNivel"]
                        echo "<option value='$fila[idRelacion]'>$fila[nombreRelacion]</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                <input type="checkbox" id="casilla">Acepta la Política de <a href="http://aepd.es/" target="_blank"> Privacidad y Protección de Datos <a/>
            </p>
        </div>
    </div>
    <div class="enviarBoton">
        <input type="submit" name="enviarFormulario2" value="↪️ Finalizar" disabled id="enviarFormulario2" class="botonDesactivado">
        <p>
            <?php
            if (!empty($_GET["errores"])) {
                echo $_GET["errores"];
            }
            ?>
        </p>
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
