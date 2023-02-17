<?php
require "model/webPedidosLoginMODEL.php";
require "views/webPedidosLoginVIEWS.php";

function validar($campoformulario)
{
    $campoformulario = trim($campoformulario);
    $campoformulario = stripslashes($campoformulario);
    $campoformulario = htmlspecialchars($campoformulario);
    return $campoformulario;
}
//pe_login.php--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function logCliente($conn)
{
    echo "2. INICIO controller<br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = validar($_POST["usuario"]);
        $clave = validar($_POST["clave"]);
        $dataUser = loginObtenerDataUser($conn, $usuario); //funcion de Model
        if ($dataUser["customerNumber"] !== null) {
            //comprobación del usuario y su clave, y creación de la cookie
            if ($clave == $dataUser["contactLastName"]) {
                setcookie("user", $dataUser["customerNumber"], time() + (86400 * 30), "/");
                loginComprobarEscribirDataUser($dataUser); //funcion de view
            } 
            else 
            {
                claveErronea(); //funcion de view
            }
        } 
        else 
        {
            noUser(); //funcion de view
        }
    }
    echo "2. FIN controller<br>";
}


?>