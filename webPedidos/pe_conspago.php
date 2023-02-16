<html>

<body>
    <h1>Consulta de compras</h1>
    <form method="post">
    <?php
    require "funcionesCestaCompra.php";
    $conn = conexion();
    ?>
    DESDE <input type="date" name="fecha_desde"><br><br>
    HASTA <input type="date" name="fecha_hasta"><br><br>
    
    <input type="submit" value="Consultar compras"><br><br><br>
    <?php
    revisarCompras($conn);
    ?>
    </form>
    
</body>

</html>