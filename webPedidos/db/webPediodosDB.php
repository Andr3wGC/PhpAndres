<?php
function conexion()
{
    /*SELECTs - mysql PDO*/
    // Iniciar sesion mysql pdo

    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "pedidos";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    return $conn;
}

?>

