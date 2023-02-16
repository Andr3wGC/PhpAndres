<html>

<body>
    <h1>Consulta de stock</h1>
    <form method="post">
    <?php
    require "funcionesCestaCompra.php";
    $conn = conexion();
    selectNomProducto($conn);
    consultarStock($conn);
    ?>
    <input type="submit" value="Consultar stock"><br><br><br>
    <?php
    consultarStock($conn);
    ?>    
</form>
    
</body>

</html>