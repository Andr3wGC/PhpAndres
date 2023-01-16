<html>

<body>
    <h1>ALTA CATEGORIA</h1>
    <form method="post">
        NOMBRE CATEGORIA <input type="text" name="nombre"><br><br>
        
    <?php 

    require "funcionesWebCompras.php";
    $conn = conexion();
    autoCompIdCat($conn); 

    ?>

        <input type="submit">
    </form>
</body>

</html>

<?php	

crearCat($conn);
$conn = null;

?>