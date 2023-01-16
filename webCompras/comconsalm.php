<html>
<body>
    <h1>COMPROBACIÓN DE STOCK</h1>
    <form method="post">
        <?php
        require "funcionesWebCompras.php";
        $conn = conexion();
        localidadAlmacenes($conn);
        informacionProducto($conn);
        ?>
        <input type="submit">
    </form>
</body>
</html>