<?php
function logCliente($conn)
{
    echo "2. INICIO controller";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $usuario = validar($_POST["usuario"]);
        $clave = validar($_POST["clave"]);
        $dataUser = loginObtenerDataUser($conn,$usuario); //funcion de Model
        loginComprobarEscribirDataUser($dataUser,$clave); //funcion de view
        
    }
    echo "2. FIN controller";
}

?>