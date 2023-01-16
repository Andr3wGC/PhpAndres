<html>

<body>
    <h1>ALTA ALMACEN</h1>
    <form method="post">
        LOCALIDAD  <input type="text" name="localidad"><br><br>
        <input type="submit">
    </form>
</body>
</html>

<?php
require "funcionesWebCompras.php";
$conn = conexion();
comprobarLocalidad($conn);
?>