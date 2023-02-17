<?php

//pe_login.php--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function loginComprobarEscribirDataUser($dataUser)
{
    echo "4. INICIO cestaCompraLoginVIEW.php<br>";
        echo "Bienvenido" . $dataUser["contactFirstName"] . " <br><br>";
        header("Location: pe_inicio.php");
    echo "4. FIN cestaCompraLoginVIEW.php<br>";
}
function claveErronea()
{
    echo "4. INICIO cestaCompraLoginVIEW.php<br>";
    echo "Clave erronea<br>";
    echo "4. FIN cestaCompraLoginVIEW.php<br>";
}

function noUser()
{
    echo "4. INICIO cestaCompraLoginVIEW.php<br>";
    echo "Usuario no existente en la base de datos";
    echo "4. FIN cestaCompraLoginVIEW.php<br>";
}

?>