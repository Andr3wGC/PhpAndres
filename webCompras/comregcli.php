<html>

<body>
    <h1>LOGIN CLIENTE</h1>
    <form method="post">
        NIF <input type="text" name="nif"><br><br>
        NOMBRE <input type="text" name="nombre"><br><br>
        APELLIDO <input type="text" name="apellido"><br><br>
        CP <input type="text" name="cp"><br><br>
        DIRECCION <input type="text" name="direccion"><br><br>
        CIUDAD <input type="text" name="ciudad"><br><br>
    <input type="submit">
    <?php
        require "funcionesWebCompras.php";
        $conn = conexion();
        crearCliente($conn);
    ?>
    </form>
</body>

</html>






