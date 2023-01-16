<html>

<body>
    <h1>LOGIN CLIENTE</h1>
    <form method="post">
        NOMBRE <input type="text" name="nombre"><br><br>
        CLAVE <input type="text" name="clave"><br><br>
    <input type="submit">
    <?php
    require "funcionesWebCompras.php";
    $conn = conexion();
    comprobarCliente($conn);
    ?>

    </form>
</body>
</html>

