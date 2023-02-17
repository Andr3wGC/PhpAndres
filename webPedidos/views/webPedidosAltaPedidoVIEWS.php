<?php
//pe_altaped.php--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//crearCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function productoAñadido($product_name)
{
    echo $product_name." ha sido añadido al carrito<br><br>";
}

function sumaProductoSuperaStock()
{
    echo "La suma de productos supera el stock<br><br>";                    
}

function sumaProducto($product_name)
{
    echo $product_name. " sumado* a tu carrito<br><br>";
}

function cantidadNoValida()
{
echo "Introduzca una cantidad valida<br><br>";
}

function cantidadSuperaStock($product_name)
{
    echo "No contamos con esa cantidad del producto ".$product_name." en stock<br><br>";
}
//selectNomProducto--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function NoProductosStock()
{
    echo "Actualmente no hay productos en stock<br><br>";
}

function printSelectNomProducto($resultado1)
{
    echo "Elige el producto que desee <br><select name='product_name' id='product_name'>";
        echo "<option value='' selected>";
        foreach ($resultado1 as $resultados)
        {
           echo "<option>".$resultados["productName"]."</option><br>";
        }
        echo "</select><br><br>";
}
//mostrarCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function printCarrito($nom_producto,$value,$precio_producto)
{
    echo $nom_producto." (". $value.") . Coste unidad: ".$precio_producto."<br>";
}
function printTotal($precio_compra)
{
    echo "<br>Precio total: ".$precio_compra."<br><br>";
}
function printCarroVacio()
{
    echo "Carrito vacio <br>";
}
//tramitarCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function printpasarela1()
{
echo '</form><form method="POST" target="_blank" action="https://sis-t.redsys.es:25443/sis/realizarPago">';
}
function printpasarela2()
{        
    echo '<input type="submit" value="Confirmar comprar" name="Comprar"></form>';
}

?>