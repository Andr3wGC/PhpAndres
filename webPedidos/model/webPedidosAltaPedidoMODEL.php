<?php
//pe_altaped.php--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//CrearCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function infoProductoSeleccionado($conn,$product_name)
{
    $stmt = $conn->prepare("SELECT productCode,quantityInStock FROM products WHERE productName=:product_name");
    $stmt->bindparam(":product_name", $product_name);
    $stmt->execute();
    $resultado=$stmt->fetch();
    return $resultado;
}
//selectNomProducto--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function nombresProducto($conn)
{
    $stmt1 = $conn->prepare("SELECT productName FROM products where quantityInStock>=0");
    $stmt1->execute();
    $resultado1=$stmt1->fetchAll();
    return $resultado1;
}
//mostrarCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function selectInfoProductosCarro($conn,$resultados)
{
    $stmt = $conn->prepare("SELECT productName,buyPrice FROM products WHERE productCode=:productCode");
    $stmt->bindparam(":productCode", $resultados);
    $stmt->execute();
    $resultado=$stmt->fetch();
    return $resultado;
}
function selectMaxOrderNumber($conn)
{
    $stmt1 = $conn->prepare("SELECT MAX(orderNumber) FROM orders");
    $stmt1->execute();
    $order_num=$stmt1->fetch();
    return $order_num;
}
//tramitarCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function insertOrders($conn,$order_num,$userCookie,$carrito,$numPago,$precio_compra){
    $stmt1 = $conn->prepare("INSERT INTO orders VALUES (:order_num, now(), now(), null,'In Process',null,:customerNumber);");
    $stmt1->bindparam(":order_num",$order_num);
    $stmt1->bindparam(":customerNumber",$userCookie);
    $stmt1->execute();

    $i=1;
    //sacar la cookie 
    foreach($carrito as $product_code => $quantity)
    {
        //buscar el buyprice con le valor de la cookie        
        $stmt3= $conn->prepare("SELECT buyPrice FROM products WHERE productCode=:product_code");
        $stmt3->bindparam(":product_code",$product_code);
        $stmt3->execute(); 
        $productoCodeYPrecio=$stmt3->fetch();

        //Insert la order detail
        $stmt2 = $conn->prepare("INSERT INTO orderDetails(orderNumber, productCode, quantityOrdered, priceEach,orderLineNumber) VALUES (:order_num, :product_code, :cuantity_ordered, :price_each,:order_line_number);");
        $stmt2->bindparam(":order_num",$order_num);
        $stmt2->bindparam(":product_code",$product_code);
        $stmt2->bindparam(":cuantity_ordered",$quantity);
        $stmt2->bindparam(":price_each",$productoCodeYPrecio["buyPrice"]);
        $stmt2->bindparam(":order_line_number",$i);
        $stmt2->execute();  
        $i++;    

        //updatear el stock
        $stmt4 = $conn->prepare("UPDATE products SET quantityInStock = quantityInStock-:quantity WHERE productCode = :product_code");
        $stmt4->bindparam(":product_code", $product_code);
        $stmt4->bindparam(":quantity", $quantity);
        $stmt4->execute();
    } 
    //Insertar en payments los valores
    $stmt5 = $conn->prepare("INSERT INTO payments(customerNumber, checkNumber, paymentDate, amount) VALUES (:customerNumber, :check_number, now(), :amount);");
    $stmt5->bindparam(":customerNumber",$_COOKIE["user"]);
    $stmt5->bindparam(":check_number",$numPago);
    $stmt5->bindparam(":amount",$precio_compra);
    $stmt5->execute();
}
?>