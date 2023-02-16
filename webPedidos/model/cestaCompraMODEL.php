<?php
function loginObtenerDataUser($conn,$usuario){
    echo "3. INICIO cestaCompraMODEL.php";

    $stmt = $conn->prepare("SELECT customerNumber,contactLastName, contactFirstName FROM customers WHERE customerNumber=:usuario");
    $stmt->bindparam(":usuario",$usuario);
    $stmt->execute();
    $resultado=$stmt->fetch(); 
    
    echo "3. FIN cestaCompraMODEL.php";
    return $resultado;
}

?>