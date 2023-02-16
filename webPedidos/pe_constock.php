<html>

<body>
    <h1>Consulta de stock por lineas</h1>
    <form method="post">
    <?php
    require "funcionesCestaCompra.php";
    $conn = conexion();
    selectLineaProducto($conn);
    ?>
    <input type="submit" value="Consultar stock"><br><br><br>
    <?php
    consultarStockLinea($conn);
    ?>
    </form>
    
</body>

</html>