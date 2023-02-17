<?php
require "model/webPedidosAltaPedidoMODEL.php";
require "views/webPedidosAltaPedidoVIEWS.php";
require "apiRedsys.php";
function validar($campoformulario)
{
    $campoformulario = trim($campoformulario);
    $campoformulario = stripslashes($campoformulario);
    $campoformulario = htmlspecialchars($campoformulario);
    return $campoformulario;
}

//pe_altaped.php--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//AñadirPructosCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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

            $resultado = infoProductoSeleccionado($conn,$product_name); //funcion de model   Select info producto seleccionado

            //Sistema de ifs para evitar errores por si la cantidad supera el stock, por si ya existe la cookie con el carrito y por si la cantidad no es valida
            //Ademas, crea la cookie en caso de q no exista
            //if "no cookie carrito, stock suficiente, cantidad valida"
            if($resultado["quantityInStock"]>=$cantidad && !isset($_COOKIE['carrito']) && $cantidad>0)
            {
                $carroArray = array($resultado["productCode"]=>$cantidad);
                $carroArray = serialize($carroArray);
                setcookie("carrito", $carroArray, time() + (86400 * 30), "/");
                productoAñadido($product_name);//funcion de view
            }
            //if "si cookie carrito, stock suficiente, cantidad valida"
            elseif($resultado["quantityInStock"]>=$cantidad && $cantidad>0 && isset($_COOKIE['carrito']))
            {
                $_COOKIE['carrito'] = unserialize($_COOKIE['carrito']);
                //usar este if para sumar las cantidades cuando ya se hayan añadido los productos al carrito 
                if(array_key_exists($resultado["productCode"],$_COOKIE['carrito']))
                {
                    $_COOKIE['carrito'][$resultado["productCode"]]+=$cantidad;
                    //if "suma de cantidad no valida"
                    if($cantidad>$resultado["quantityInStock"])
                    {
                        sumaProductoSuperaStock();//funcion de view
                    }
                    else{
                    $_COOKIE['carrito'] = serialize($_COOKIE['carrito']);
                    setcookie("carrito", $_COOKIE['carrito'], time() + (86400 * 30), "/");
                    sumaProducto($product_name);//funcion de view
                    }
                }
                else
                {
                $_COOKIE['carrito'] = (array($resultado["productCode"]=>$cantidad)) + $_COOKIE['carrito'];
                $_COOKIE['carrito'] = serialize($_COOKIE['carrito']);
                setcookie("carrito", $_COOKIE['carrito'], time() + (86400 * 30), "/");
                productoAñadido($product_name); //funcion de view
                }
                serialize($_COOKIE['carrito']);
            } 
            //cantidad no valida"
            elseif($cantidad<=0)
            {
                cantidadNoValida();
            }
            //if "stock insuficiente"
            elseif($resultado["quantityInStock"]<=$cantidad)
            {
                cantidadSuperaStock($product_name);
            }
        }
    }
}
//BotonEliminarCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
//BotonCerrarSesion/NoCookieUser--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
//selectNomProducto--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function selectNomProducto($conn)
{
    $resultado1 = nombresProducto($conn);//funcion de model
    if(empty($resultado1))
    {
        NoProductosStock();//funcion de view
    }
    else
    {
        printSelectNomProducto($resultado1);//funcion de view
    }
}
//mostrarCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function mostrarCarrito($conn)
{
    if(isset($_COOKIE['carrito']))
    {
    $_COOKIE['carrito'] = unserialize($_COOKIE['carrito']);
    foreach($_COOKIE['carrito'] as $resultados => $value)
    {
        $resultado = selectInfoProductosCarro($conn,$resultados);//funcion de model
        
        $nom_producto = $resultado['productName'];
        $precio_producto= $resultado['buyPrice'];
        $precio_compra=+$precio_producto;

        printCarrito($nom_producto,$value,$precio_producto);//funcion de view
    }
    printTotal($precio_compra);//funcion de view

    $order_num = selectMaxOrderNumber($conn);//funcion de model
    $order_num[0]=$order_num[0]+1;
    //La pasarela se creará en cuanto el carrito tenga algún producto

    // Si pulsan tramitar esta función le dará a tramitarCarrito lo que necesite
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tramitar"]))
        {
            $numPago=validar($_POST["num_pago"]);
            tramitarCarrito($conn,$precio_compra,$numPago,$_COOKIE['carrito'], $order_num[0]);
        }
    }
    else
    {
        printCarroVacio();//funcion de view
    }
}
//TramitarCarrito--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function tramitarCarrito($conn,$precio_compra,$numPago,$carrito, $order_num)
{
    //meter la order, la orderdetails, el pago y updatear el stock
    insertOrders($conn,$order_num,$_COOKIE["user"],$carrito,$numPago,$precio_compra); //funcion de model
   
    // form de la vergüenza porque un boton no puede hacerlo todo :c  
    printpasarela1(); //funcion de view
    pasarela($precio_compra, $order_num); //funcion de model
    printpasarela2(); //funcion de view
}
//Pasarela--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
?>