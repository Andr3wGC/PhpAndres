<html>
<body>
<form method="post">
    <h1>COMPRA DE PRODUCTOS</h1>
    

<?php
    require "funcionesCestaCompra.php";
    $conn = conexion();
    crearCarrito($conn);
    eliminarCarrito();
    cerrarSesion();
    selectNomProducto($conn);
?>
        
        CANTIDAD DEL PRODUCTO <input type='number' name='cantidad'><br><br>
        
        
        <input type="submit" value="Añadir al carrito" name="añadir"><br> <br>
    </form>
    
     <form method="POST" >  <!-- Valores de formulario mas redsys que además tramitará el pedido -->
        <h1>TU CARRITO</h1>

    <?php
        mostrarCarrito($conn);
    ?>
    
    NUMERO DE PAGO <input type='text' name='num_pago' placeholder="AA99999">
     <!-- formulario con valores de redsys ocultos -->
    

    <br><input type="submit" value="Tramitar pedido" name="tramitar">
    </form>
    
    <form method="post"> <!-- ponerlo en un form distinto o llevará a pagina de redsys--> 
    <input type="submit" value="Eliminar carrito" name="eliminar">
    </form>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<form method="post">
<input type="submit" value="Cerrar sesion" name="cerrar">
</form>


    
</body>
</html>







