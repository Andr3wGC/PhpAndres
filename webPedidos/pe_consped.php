<html>

<body>
    <h1>Consulta de pedidos</h1>
    <form method="post">
    <?php
    require "funcionesCestaCompra.php";
    $conn = conexion();
    selectCliente($conn);
    ?>
    <input type="submit" value="Consultar pedidos"><br><br><br>

    <?php
    consultarCompras($conn);
    ?>
    </form>
    
</body>

</html>