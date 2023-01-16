<html>
<body>
    <h1>ALMACENAR PRODUCTOS</h1>
    <form method="post">
        CANTIDAD DE PRODUCTOS <input type="text" name="cantidad"><br><br>
        <?php
        require "funcionesWebCompras.php";
        $conn = conexion();
        nombreProductos($conn);
        idAlmacenes($conn);
        almacenarProductos($conn);
        ?>
        <input type="submit">
    </form>
</body>
</html>
