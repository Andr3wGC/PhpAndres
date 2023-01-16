<html>

<body>
    <h1>ALTA PRODUCTO</h1>
    <form method="post">
        NOMBRE PRODUCTO <input type="text" name="nombre"><br><br>
        PRECIO DEL PRODUCTO <input type="text" name="precio"><br><br>
        
        <?php
        require "funcionesWebCompras.php";
        $conn = conexion();
        autoCompIdPro($conn); 
        selectCategoria($conn);

        
        ?>
    <input type="submit">
    </form>
</body>

</html>
<?php
crearProcucto($conn)
?>