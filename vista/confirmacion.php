<?php
session_start();
if (empty($_SESSION['nombreCompleto'])) {
    header('Location:formulario1.php?errores=Debe completar ambos formularios');
    exit();
}

// llamamos al archivo que carga la BBDD
include_once("../modelo/conexion.php");
// ejecuta la funcion conectar
$link = conectar();
// hacemos la consulta que se guarda en una variable ($consulta)
$consulta = "SELECT * FROM alumno WHERE idAlumno = ".$_SESSION["idRegistro"];
// se ejecuta la consulta
$resultado = mysqli_query($link, $consulta);
$arrayAlumnos[] = mysqli_fetch_assoc($resultado);

include_once "header.php";
?>


<h1>Formulario de Alta de nuevo Alumno</h1>
<h2 class="centrado">3️⃣⇢ Alta Confirmada</h2>
<div class="formulario unaColumna">
    <div>
        <p>Le informamos que el alta al sistema de Inscripcion del CENTRO DE EDUCACION  PARA ADULTOS se ha realizado
            con exito</p>
        <p>Sus datos son:</p>
        <ul>
            <li>Nombre: <?=$_SESSION["nombreCompleto"]?></li>
            <li>Telefono: <?=$_SESSION["telefono"] ?></li>
<!--            --><?php //=$_SESSION["datosCompletos"]?>
        </ul>
        <p>Nota: Su numero de registro es: <span class="error"><?=$_SESSION["idRegistro"]?></span></p>
    </div>


</div>
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
