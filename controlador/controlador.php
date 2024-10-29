<?php
session_start();
/**
 * Array de errores que se utiliza tanto en el formulario1 como en el formulario 2
 * Se inicializa cada vez que se llama al archivo controlador
 */
$errores=array();
/**
 * La siguiente condición lee desde donde se recibe el formulario y valida los campos importantes u obligatorios.
 * Si todo es correcto, envía al siguiente formulario
 * En caso de error, se envía cuáles campos tienen error para su corrección.
 */
if ($_REQUEST["origen"]==="formulario1"){
    validarCpostal($_REQUEST["cp"]);
    validarDNI($_REQUEST["dni"]);
    validarEdad($_REQUEST["fNacimiento"]);
    validarTexto($_REQUEST["nombre"] , "nombre");
    validarTexto($_REQUEST["pApellido"] , "apellido");
    validarTelefono($_REQUEST["telefono"]);
    validarVacio($_REQUEST["provincia"], "La provincia");
    validarVacio($_REQUEST["fechaUE"], "La Fecha ultimo estudio");
    validarVacio($_REQUEST["direccion"], "La direccion");
    validarVacio($_REQUEST["uEstudio"], "El ultimo estudio");

    if (count($errores)>0){
    for ($i=0;$i<count($errores);$i++){
    $todosLosErrores.=$errores[$i];
    }
        header("Location:../vista/formulario1.php?errores=$todosLosErrores");
    }else{
        $_SESSION["insertarAlumno"]="insert into alumno(nombre, primerApellido, segundoApellido, dni, telefono, direccion, cp, ciudad, fechaUltimoEstudio, idProvincia, idEstudios, fechaNacimiento) values 
        ('" . $_REQUEST["nombre"] . "',
        '" . $_REQUEST["pApellido"] . "',
        '" . $_REQUEST["sApellido"] . "',
        '" . $_REQUEST["dni"] . "',
        " . $_REQUEST["telefono"] . ",
        '" . $_REQUEST["direccion"] . "',
        '" . $_REQUEST["cp"] . "',
        '" . $_REQUEST["ciudad"] . "',
        '" . $_REQUEST["fechaUE"] . "',
        " . $_REQUEST["provincia"] . ",
        " . $_REQUEST["uEstudio"] . ",
        '" . $_REQUEST["fNacimiento"] . "'
        )";
        // Guardar los datos en $_SESSION
        header("Location:../vista/formulario2.php");
    }
}

/**
 * La siguiente condición lee desde donde se recibe el formulario y valida los campos importantes u obligatorios.
 * Si todo es correcto, envía al siguiente formulario
 * En caso de error, se envía cuáles campos tienen error para su corrección.
 */
if ($_REQUEST["origen"]==="formulario2"){
    validarTexto($_REQUEST["nombreFamiliar"], "Persona Contacto");
    validarTelefono($_REQUEST["telefonoFamiliar"]);
    validarVacio($_REQUEST["relacion"], "La relacion");

    if (count($errores)>0){
        for ($i=0;$i<count($errores);$i++){
            $todosLosErrores.=$errores[$i];
        }
        header("Location:../vista/formulario2.php?errores=$todosLosErrores");
    }else{
        require_once ("../modelo/conexion.php"); // LLamamos a la conexión
        $link=conectar();
        $insertarFamiliar="insert into familiar(nombreFamiliar, telefono, idRelacion) values 
        ('".$_REQUEST["nombreFamiliar"]."',
        ".$_REQUEST["telefonoFamiliar"].",
        ".$_REQUEST["relacion"]."
        )";
        $resultado = mysqli_query($link, $insertarFamiliar); // Ejecuta la consulta
        $idFamiliar = mysqli_insert_id($link); // Recupero el ID del último link que he insertado
        //echo $idFamiliar; <- Cambiado ahora
        $insertarAlumno=$_SESSION["insertarAlumno"];
        $resultado=mysqli_query($link,$insertarAlumno);
        $idAlumno = mysqli_insert_id($link);
        $_SESSION["idRegistro"]=$idAlumno;
        $insertarFamiliarAlumno="update alumno set idFamiliar=".$idFamiliar." where idAlumno=".$idAlumno;
        $resultado=mysqli_query($link,$insertarFamiliarAlumno);

        /*Una vez insertados los datos del alumno y del familiar, puede recuperar su nombre, apellido, teléfono */
        $consultaDatosAlumno="select nombre, primerApellido, dni, telefono, direccion, cp, ciudad, fechaUltimoEstudio, fechaNacimiento from alumno where idAlumno=".$idAlumno;
        $resultado=mysqli_query($link,$consultaDatosAlumno);
        $arrayAlumno[]=mysqli_fetch_array($resultado);

        foreach ($arrayAlumno as $alumno){
            $_SESSION["nombreCompleto"]=$alumno["nombre"]." ".$alumno["primerApellido"];
            $_SESSION["telefono"]=$alumno["telefono"];
//            $_SESSION["datosCompletos"] = "<li>".$alumno["nombre"]." ".$alumno["primerApellido"]."</li>
//                                           <li>".$alumno["dni"]."</li>
//                                           <li>".$alumno["telefono"]."</li>
//                                           <li>".$alumno["direccion"]." ".$alumno["cp"]." ".$alumno["ciudad"]."</li>
//                                           <li>".$alumno["fechaUltimoEstudio"]."</li>
//                                           <li>".$alumno["fechaNacimiento"]."</li>";
        }
        mysqli_close($link); // Cierra la BBDD
        header("Location:../vista/confirmacion.php");
    }
}

/**
 * @param $texto
 * @param $variable
 * @return void
 * Función que valida cualquier texto, indicará un error en la variable global en caso de estar vacío o tener algún número
 */
function validarTexto($texto, $variable){
    global $errores;
    if (empty($texto) || !is_string($texto) || preg_match("/^[0-9]/", $texto)) {
        $errores[] = "<p class='error'> El $variable no puede estar vacio ni contener numeros </p>";
    }
}

/**
 * @param $valor
 * @param $variable
 * @return void
 * Función que recibe un valor y su campo a la que hace referencia.
 * En caso de estar vacío, guarda en la variable global el mensaje de error haciendo referencia a su campo
 * Ej: El campo Ciudad es obligatorio
 */
function validarVacio($valor, $variable){
    global $errores;
    if (empty($valor)){
        $errores[]="<p class='error'> El campo $variable es obligatorio</p>";
    }
}

/**
 * @param $telefono
 * @return void
 * Función que valida un número de teléfono de España con 9 dígitos y que comience con 6/7/8/9
 * En caso de error, guarda en la variable glogal el mensaje
 */
function validarTelefono($telefono){
    global $errores;
    if (empty($telefono) || !is_numeric($telefono) || !preg_match("/^[6789]\d{8}$/", $telefono)){
        $errores[]="<p class='error'>El formato del telefono es incorrecto, debe comenzar por 6/7/8/9 y tener 9 digitos</p>";
    }
}

/**
 * @param $fecha
 * @return void
 * @throws Exception
 * Función que recibe la fecha de nacimiento y calcula con respecto a la fecha actual la edad del alumno
 * En caso de no tener 18 años o mas, se guarda un error en la variable global que no puede ser menor de edad
 */
function validarEdad($fecha){
    global $errores;
    $fechaN = new DateTime($fecha); // La variable que se lee de la fecha de nacimiento reamos como timo dateTime
    //Obtener la fecha actual
    $feha_actual = new DateTime(); // Leemos la fecha actual

    //Calcular la diferencia entre la fecha actual y la fecha de nacimiento
    $diferencia = $feha_actual->diff($fechaN); // Método que calcula la diferencia entre dos fechas

    //Obtener la edad en años
    $edad = $diferencia->y;
    if ($edad < 18){
        $errores[]="<p class='error'>Tienes $edad anios. La edad no puede ser menor a 18 anios </p>";
    }
}

/**
 * @param $dni
 * @return void
 * Función que valida el DNI con el formato y la letra correcta.
 * En caso de error, se guarda en la variable global si el error de formato o de la letra
 */
function validarDNI($dni){
    global $errores;
    if (preg_match("/^[0-9]{8}[A-Za-z]$/", $dni)) { // Expresión regular que sólo valida el formato del DNI
        //Separar la letra del DNI
        $numero = substr($dni, 0, 8);
        $letra = strtoupper(substr($dni, -1));

        //Letras de control
        $letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";

        //Calcular la letra correspondiente al número
        $indice = $numero % 23;
        $letra_correcta = $letras_validas[$indice];

        //Verificar si la letra coincide
        if ($letra_correcta != $letra){
            $errores[] = "<p class='error'> DNI invalido (letra incorrecta)</p>"; // DNI inválido (letra incorrecta)
        }
    }else{
        $errores[]="<p class='error'> el DNI tiene formato incorrecto</p>"; // Formato de DNI no válido
    }
}

/**
 * @param $cp
 * @return void
 * Función que recibe un código postal y valida que sean 5 dígitos, solo números
 * En caso de error, guarda el mensaje en la variable global
 */
function validarCpostal($cp){
    global $errores;
    if (empty($cp) || !preg_match("/^[0-9]{5}$/", $cp)){
        $errores[]="<p class='error'>El codigo postal no puede estar vacio y debe contener 5 numeros</p>";
    }
}

