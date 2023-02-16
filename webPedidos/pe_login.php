<html>

<body>
    <h1>LOGIN CLIENTE</h1>
    <form method="post">
        USUARIO <input type="text" name="usuario"><br><br>
        CLAVE <input type="text" name="clave"><br><br>
        <input type="submit">
        <?php
        require "db/cestaCompraDB.php";
         
        
        require "controller/cestaCompraController.php";

        $conn = conexion(); //funcion de bd

        logCliente($conn); //funcion de controller
        ?>

    </form>
    
</body>

</html>