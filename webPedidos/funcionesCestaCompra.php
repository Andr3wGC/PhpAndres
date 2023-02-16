<?php

include 'apiRedsys.php'; //Include la api de redsys


//Conextar al usuario a la base de datos
function conexion()
{
    /*SELECTs - mysql PDO*/
    // Iniciar sesion mysql pdo

    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "pedidos";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    return $conn;
}

//Funcion para validar los campos
function validar($campoformulario)
{
    $campoformulario = trim($campoformulario);
    $campoformulario = stripslashes($campoformulario);
    $campoformulario = htmlspecialchars($campoformulario);
    return $campoformulario;
}

//Buscar al cliente, ver si la contraseña esta bien(apellido) y crear la cookie en ese caso
function logCliente($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $usuario = validar($_POST["usuario"]);
        $clave = validar($_POST["clave"]);
        //busqueda del usuario en la base de datos
        $stmt = $conn->prepare("SELECT customerNumber,contactLastName, contactFirstName FROM customers WHERE customerNumber=:usuario");
        $stmt->bindparam(":usuario",$usuario);
        $stmt->execute();
        $resultado=$stmt->fetch();

        if($resultado["customerNumber"] !== null){
            //comprobación del usuario y su clave, y creación de la cookie
            if($clave == $resultado["contactLastName"])
            {
                setcookie("user", $resultado["customerNumber"], time() + (86400 * 30), "/");
                echo "Bienvenido".$resultado["contactFirstName"]." <br><br>";
                header("Location: pe_inicio.php");
            }
            else
            {
                echo "Contraseña erronea";
            }
        }
        else
        {
            echo "Usuario no existente en la base de datos";
        }

    }
}

//funcion que crea un select con los resultados de los productos
function selectNomProducto($conn)
{
    $stmt1 = $conn->prepare("SELECT productName FROM products where quantityInStock>=0");
    $stmt1->execute();
    $resultado1=$stmt1->fetchAll();
    if(empty($resultado1)){
        echo "Actualmente no hay productos en stock<br><br>";
    }
    else
    {
        echo "Elige el producto que desee <br><select name='product_name' id='product_name'>";
        echo "<option value='' selected>";
        foreach ($resultado1 as $resultados)
        {
           echo "<option>".$resultados["productName"]."</option><br>";
        }
    echo "</select><br><br>";
    }
}

//Creacion de la cesta buscando en la base de datos el producto mediante el nombre
function crearCarrito($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["añadir"]))
    {
        //if para evitar que sin la cookie del usuario se haga nada
        if(!isset($_COOKIE["user"]))
        {
            setcookie("carrito","", time() - (86400 * 30), "/");
            header("Location: pe_login.php");
        }
        else
        {
        
            $product_name= $_POST["product_name"];
            $cantidad =$_POST["cantidad"];

            $stmt = $conn->prepare("SELECT productCode,quantityInStock FROM products WHERE productName=:product_name");
            $stmt->bindparam(":product_name", $product_name);
            $stmt->execute();
            $resultado=$stmt->fetch();
            //Sistema de ifs para evitar errores por si la cantidad supera el stock, por si ya existe la cookie con el carrito y por si la cantidad no es valida
            //Ademas, crea la cookie en caso de q no exista
            //if "no cookie carrito, stock suficiente, cantidad valida"
            if($resultado["quantityInStock"]>=$cantidad && !isset($_COOKIE['carrito']) && $cantidad>0)
            {
                $carroArray = array($resultado["productCode"]=>$cantidad);
                $carroArray = serialize($carroArray);
                setcookie("carrito", $carroArray, time() + (86400 * 30), "/");
                echo $product_name." ha sido añadido al carrito<br><br>";

            }
            //if "si cookie carrito, stock suficiente, cantidad valida"
            elseif($resultado["quantityInStock"]>=$cantidad && $cantidad>0 && isset($_COOKIE['carrito']))
            {
                $_COOKIE['carrito'] = unserialize($_COOKIE['carrito']);
                //usar este if para sumar las cantidades cuando ya se hayan añadido los productos al carrito 
                if(array_key_exists($resultado["productCode"],$_COOKIE['carrito'])){
                    $_COOKIE['carrito'][$resultado["productCode"]]+=$cantidad;
                    //if "suma de cantidad no valida"
                    if($cantidad>$resultado["quantityInStock"])
                    {
                        echo "La suma de productos supera el stock<br><br>";
                    }
                    else{
                    $_COOKIE['carrito'] = serialize($_COOKIE['carrito']);
                    setcookie("carrito", $_COOKIE['carrito'], time() + (86400 * 30), "/");
                    echo "Producto sumado* a tu carrito<br><br>";
                    }

                }else{
                $_COOKIE['carrito'] = (array($resultado["productCode"]=>$cantidad)) + $_COOKIE['carrito'];
                $_COOKIE['carrito'] = serialize($_COOKIE['carrito']);
                setcookie("carrito", $_COOKIE['carrito'], time() + (86400 * 30), "/");
                echo $product_name." ha sido añadido al carrito<br><br>";
            }
                serialize($_COOKIE['carrito']);
            } 
            //cantidad no valida"
            elseif($cantidad<=0)
            {
                echo "Introduzca una cantidad valida<br><br>";
            }
            //if "stock insuficiente"
            elseif($resultado["quantityInStock"]<=$cantidad)
            {
                echo "No contamos con esa cantidad del producto ".$product_name." en stock<br><br>";
            }
        
        }
    }
    
}

//Funcion que accede a la cookie y a la base de datos para mostrar el carrito con sus productos 
function mostrarCarrito($conn)
{
    if(isset($_COOKIE['carrito']))
    {
    $_COOKIE['carrito'] = unserialize($_COOKIE['carrito']);
    foreach($_COOKIE['carrito'] as $resultados => $value)
    {
        $stmt = $conn->prepare("SELECT productName,buyPrice FROM products WHERE productCode=:productCode");
        $stmt->bindparam(":productCode", $resultados);
        $stmt->execute();
        $resultado=$stmt->fetch();
        $nom_producto = $resultado['productName'];
        $precio_producto= $resultado['buyPrice'];
        $precio_compra=+$precio_producto;

         echo $nom_producto." (". $value.") . Coste unidad: ".$precio_producto."<br>";
    }
    echo "<br>Precio total: ".$precio_compra."<br><br>";

    $stmt1 = $conn->prepare("SELECT MAX(orderNumber) FROM orders");
    $stmt1->execute();
    $order_num=$stmt1->fetch();
    $order_num[0]=$order_num[0]+1;

    //La pasarela se creará en cuanto el carrito tenga algún producto
    

    // Si pulsan tramitar esta función le dará a tramitarCarrito lo que necesite
    
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tramitar"]))
        {
            $numPago= validar($_POST["num_pago"]);
            tramitarCarrito($conn,$precio_compra,$numPago,$_COOKIE['carrito'], $order_num[0]);
        }
    }
    else
    {
        echo "Carrito vacio <br>";
    }
}

//elimina el carrito cuando se le da al boton o se tramita el pedido
function eliminarCarrito()
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST["eliminar"])||isset($_POST["tramitar"]))
        {
            setcookie("carrito","", time() - (86400 * 30), "/");
        }
    }
}

function tramitarCarrito($conn,$precio_compra,$numPago,$carrito, $order_num)
{
    // primero hay q hacer virguerias: Crear la order, la orderdetails, cambiar el stock.
    // Crear la order necesito las variables del carrito y puedo o volver a hacerlas o empotrar este codigo con lo de antes
    //custnum-cookie, ordernum-busquedamax+1,orderdate-now,requiredDate-now,shipped-null,status-inproces,coments-null
    //orderDetails: 
    
    //El valor del order number ya buscado anteriormente
    //meter la order
    $stmt1 = $conn->prepare("INSERT INTO orders VALUES (:order_num, now(), now(), null,'In Process',null,:customerNumber);");
    $stmt1->bindparam(":order_num",$order_num);
    $stmt1->bindparam(":customerNumber",$_COOKIE["user"]);
    $stmt1->execute();


    //sacar la cookie
    $i=1;
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

    
   
    // form de la vergüenza porque un boton no puede hacerlo todo :c  
    echo "</form>";
   
    echo '<form method="POST" target="_blank" action="https://sis-t.redsys.es:25443/sis/realizarPago">';
         pasarela($precio_compra, $order_num);
    echo '<input type="submit" value="Confirmar comprar" name="Comprar"></form>';
}

//Funcion que borra las cookies si se pulsa cerrar sesion o no existe la cookie de usuario y envia al usuario al login  
function cerrarSesion()
{
    if(($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerrar"]))||($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_COOKIE["user"])))
    {
        {
            setcookie("carrito","", time() - (86400 * 30), "/");
            setcookie("user","", time() - (86400 * 30), "/");
            header("Location: pe_login.php");

        }
    }
}

function pasarela($amount, $id) // numero de pedido (auto increment) y lo que ellos pagan
{

    // Se crea Objeto
    $miObj = new RedsysAPI;

    $fuc="999008881"; // "fuc" que nos asignan, no lo vamos a solicitar
	$terminal="1"; //terminal (no tenemos banco real)
	$moneda="978"; //euro
	$trans="0"; //autorizacion
	$url=""; //url que no tenemos
	$urlOKKO="http://localhost/practicacestaCompra/pe_altaped.php"; //redirección a la que enviar al usuario en caso de transaccion ok o ko
	$amount=$amount*100; //multiplicarlo por 100 para que no haya errores	

    // Se Rellenan los campos
	$miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
	$miObj->setParameter("DS_MERCHANT_ORDER",$id); 
	$miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc);
	$miObj->setParameter("DS_MERCHANT_CURRENCY",$moneda);
	$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans);
	$miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
	$miObj->setParameter("DS_MERCHANT_MERCHANTURL",$url);
	$miObj->setParameter("DS_MERCHANT_URLOK",$urlOKKO);
	$miObj->setParameter("DS_MERCHANT_URLKO",$urlOKKO);

    //Datos de configuración (que alguien entenderá)
	$version="HMAC_SHA256_V1";
	$kc = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';//Clave recuperada de CANALES
	// Se generan los parámetros de la petición ( que son importantes)
	$request = "";
	$params = $miObj->createMerchantParameters();
	$signature = $miObj->createMerchantSignature($kc);

    echo '<input hidden type="text" name="Ds_SignatureVersion" value="'. $version.'" /> <input hidden type="text" name="Ds_MerchantParameters" value="'.$params.'" /> <input hidden type="text" name="Ds_Signature" value="'.$signature.'" /></br>';
}

// 2. Consultar compras
// Funcion que crea el select con los numeros de cliente
function selectCliente($conn)
{
    $stmt = $conn->prepare("SELECT customerNumber FROM customers");
    $stmt->execute();
    $resultado=$stmt->fetchAll();
    if($resultado[0] == null){
        echo "No hay ningún cliente en la base de datos";
    }else{
       echo "Elija el numero de cliente <select name='customer_number' id='customer_number'>";
       echo "<option value='' selected>";
       foreach ($resultado as $resultados) {
           echo "<option>".$resultados["customerNumber"]."</option><br>";
       }
       echo "</select><br><br>";
    }
}


//Consulta del estado de las compras
function consultarCompras($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $customer_number = validar($_POST["customer_number"]);
    
        $stmt = $conn->prepare("SELECT orderNumber,orderDate,status FROM orders WHERE customerNumber=:customer_number");
        $stmt->bindparam(":customer_number", $customer_number);
        $stmt->execute();
        $resultado=$stmt->fetchAll();
        if(empty($resultado[0]))
        {
            echo "No se han realizado compras por este cliente<br><br>";
        }
        else
        {
            foreach($resultado as $resultados)
            {
                echo "Numero de pedido: ".$resultados["orderNumber"].". Fecha de la compra: ".$resultados["orderDate"].". Estado: ".$resultados["status"]."<br>";
            }
        }
    }
}

//3. Consulta stock
//Consulta del stock dependiendo del producto seleccionado
function consultarStock($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $product_name = validar($_POST["product_name"]);
    
        $stmt = $conn->prepare("SELECT quantityInStock FROM products WHERE productName=:product_name");
        $stmt->bindparam(":product_name", $product_name);
        $stmt->execute();
        $resultado=$stmt->fetchAll();
        
        foreach($resultado as $resultados)
        {
            echo "Cantidad de productos en stock: ".$resultados["quantityInStock"]."<br><br>";
        }
        
    }
}

//4. Consulta de stock por lineas
//Select con las lineas de productos
function selectLineaProducto($conn)
{
    $stmt = $conn->prepare("SELECT productLine FROM productLines");
    $stmt->execute();
    $resultado=$stmt->fetchAll();
    if($resultado[0] == null){
        echo "No hay ninguna linea de productos en la base de datos";
    }else{
       echo "Elija la linea de productos <select name='product_line' id='product_line'>";
       echo "<option value='' selected>";
       foreach ($resultado as $resultados) {
           echo "<option>".$resultados["productLine"]."</option><br>";
       }
       echo "</select><br><br>";
    }
}

//Consulta del stock dependiendo de la linea seleccionada 
function consultarStockLinea($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $product_line = validar($_POST["product_line"]);
    
        $stmt = $conn->prepare("SELECT productName,quantityInStock FROM products WHERE productLine=:product_line ORDER BY quantityInStock DESC");
        $stmt->bindparam(":product_line", $product_line);
        $stmt->execute();
        $resultado=$stmt->fetchAll();
        
        foreach($resultado as $resultados)
        {
            echo "Nombre del producto: ''".$resultados["productName"]."''. Cantidad de productos en stock: ".$resultados["quantityInStock"].".<br><br>";
        }
        
    }
}

// 5. Consulta de compras
//funcion que revisa las compras realizadas en las fechas indicadas
function revisarCompras($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $fecha_desde = validar($_POST["fecha_desde"]);
        $fecha_hasta = validar($_POST["fecha_hasta"]);
    
        $stmt = $conn->prepare("SELECT orderNumber FROM orders WHERE orderDate>=:fecha_desde AND orderDate<=:fecha_hasta");
        $stmt->bindparam(":fecha_desde", $fecha_desde);
        $stmt->bindparam(":fecha_hasta", $fecha_hasta);
        $stmt->execute();
        $resultado=$stmt->fetchAll();
        if(empty($resultado[0]))
        {
            echo "No se realizaron compras entre esas fechas.";
        }
        else
        {
            foreach($resultado as $resultados)
            {
                echo "Del pedido de número: ".$resultados["orderNumber"].".<br>";
                $stmt1 = $conn->prepare("SELECT productCode,quantityOrdered,priceEach FROM orderDetails WHERE orderNumber=:order_number");
                $stmt1->bindparam(":order_number", $resultados["orderNumber"]);
                $stmt1->execute();
                $resultado1=$stmt1->fetchAll();

                foreach($resultado1 as $resultados1)
                {
                    $stmt2 = $conn->prepare("SELECT productName FROM products WHERE productCode=:product_code");
                    $stmt2->bindparam(":product_code", $resultados1["productCode"]);
                    $stmt2->execute();
                    $resultado2=$stmt2->fetch();
                    echo "Nombre del producto: ''".$resultado2["productName"]."''.<br> Codigo del producto: ".$resultados1["productCode"].".<br> Cantidad del producto: ".$resultados1      ["quantityOrdered"].".<br> Precio del producto: ".$resultados1["priceEach"].".<br><br>";
                }
            }
        }
    }
}

// 6. Consulta de compras de un cliente
//funcion que revisa las compras realizadas por 1 cliente determinado
function revisarComprasCliente($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $customer_number = validar($_POST["customer_number"]);
        $fecha_desde = validar($_POST["fecha_desde"]);
        $fecha_hasta = validar($_POST["fecha_hasta"]);
        
        if(empty($fecha_desde) || empty($fecha_hasta))
        {
            $stmt = $conn->prepare("SELECT orderNumber FROM orders WHERE customerNumber=:customer_number");
            $stmt->bindparam(":customer_number", $customer_number);
            $stmt->execute();
            $resultado=$stmt->fetchAll();
            if(empty($resultado[0]))
            {
                echo "El cliente no ha realizado compras.";
            }
            else
            {
                foreach($resultado as $resultados)
                {
                    echo "Del pedido de número: ".$resultados["orderNumber"].". Del cliente de número: ".$customer_number.".<br>";
                    $stmt1 = $conn->prepare("SELECT productCode,quantityOrdered,priceEach FROM orderDetails WHERE orderNumber=:order_number");
                    $stmt1->bindparam(":order_number", $resultados["orderNumber"]);
                    $stmt1->execute();
                    $resultado1=$stmt1->fetchAll();

                    foreach($resultado1 as $resultados1)
                    {
                        $stmt2 = $conn->prepare("SELECT productName FROM products WHERE productCode=:product_code");
                        $stmt2->bindparam(":product_code", $resultados1["productCode"]);
                        $stmt2->execute();
                        $resultado2=$stmt2->fetch();
                        echo "Nombre del producto: ''".$resultado2["productName"]."''.<br> Codigo del producto: ".$resultados1["productCode"].".<br> Cantidad del producto: ".  $resultados1      ["quantityOrdered"].".<br> Precio del producto: ".$resultados1["priceEach"].".<br><br>";
                    }
                }
            }

        }
        else
        {
            $stmt = $conn->prepare("SELECT orderNumber FROM orders WHERE orderDate>=:fecha_desde AND orderDate<=:fecha_hasta and customerNumber=:customer_number");
            $stmt->bindparam(":fecha_desde", $fecha_desde);
            $stmt->bindparam(":fecha_hasta", $fecha_hasta);
            $stmt->bindparam(":customer_number", $customer_number);
            $stmt->execute();
            $resultado=$stmt->fetchAll();
            if(empty($resultado[0]))
            {
                echo "No se realizaron compras entre esas fechas.";
            }
            else
            {
                foreach($resultado as $resultados)
                {
                    echo "Del pedido de número: ".$resultados["orderNumber"].". Del cliente de número: ".$customer_number.".<br>";
                    $stmt1 = $conn->prepare("SELECT productCode,quantityOrdered,priceEach FROM orderDetails WHERE orderNumber=:order_number");
                    $stmt1->bindparam(":order_number", $resultados["orderNumber"]);
                    $stmt1->execute();
                    $resultado1=$stmt1->fetchAll();

                    foreach($resultado1 as $resultados1)
                    {
                        $stmt2 = $conn->prepare("SELECT productName FROM products WHERE productCode=:product_code");
                        $stmt2->bindparam(":product_code", $resultados1["productCode"]);
                        $stmt2->execute();
                        $resultado2=$stmt2->fetch();
                        echo "Nombre del producto: ''".$resultado2["productName"]."''.<br> Codigo del producto: ".$resultados1["productCode"].".<br> Cantidad del producto: ".  $resultados1      ["quantityOrdered"].".<br> Precio del producto: ".$resultados1["priceEach"].".<br><br>";
                    }
                }
            }
        }
    }
}




?>