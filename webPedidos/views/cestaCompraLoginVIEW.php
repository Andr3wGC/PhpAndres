<?php
function loginComprobarEscribirDataUser($dataUser, $clave)
{
    echo "4. INICIO cestaCompraLoginVIEW.php";

    if ($dataUser["customerNumber"] !== null) {
        //comprobación del usuario y su clave, y creación de la cookie
        if ($clave == $dataUser["contactLastName"]) {
            setcookie("user", $dataUser["customerNumber"], time() + (86400 * 30), "/");
            echo "Bienvenido" . $dataUser["contactFirstName"] . " <br><br>";
            header("Location: pe_inicio.php");
        } else {
            echo "Contraseña erronea";
        }
    } else {
        echo "Usuario no existente en la base de datos";
    }
    
    echo "4. FIN cestaCompraLoginVIEW.php";
}
