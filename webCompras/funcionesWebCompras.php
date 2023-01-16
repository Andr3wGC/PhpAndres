<?php

function conexion()
{
    /*SELECTs - mysql PDO*/
    // Iniciar sesion mysql pdo

    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "COMPRASWEB";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    return $conn;
}

//funcion para validar formulario
function validar($campoformulario)
{
    $campoformulario = trim($campoformulario);
    $campoformulario = stripslashes($campoformulario);
    $campoformulario = htmlspecialchars($campoformulario);
    return $campoformulario;
}

//funcion para crear el id de la siguiente categoria con el modelo C-XXX 
function autoCompIdCat($conn)
{
    $stmt = $conn->prepare("SELECT MAX(ID_CATEGORIA) FROM CATEGORIA"); 
    $stmt->execute();
    $resultado=$stmt->fetch();
    if($resultado[0]==null)
    {
        echo"<input type='text' name='id_cat' value=C-001 readonly><br><br>"; 
    }else
    {
        $parte = substr($resultado[0],-3); 
        $parte += 1;
        $resultado[0] = substr_replace($resultado[0],$parte,-strlen($parte));
        echo "<input type='text' name='id_cat' value=".$resultado[0]." readonly><br><br>";
    }
}

//funcion que crea la categoria dependiendo de lo que le envie el formulario
function crearCat($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        try
        {
            $nombre = validar($_POST["nombre"]);
            $id_categoria = validar($_POST["id_cat"]);    
            $stmt = $conn->prepare("INSERT INTO CATEGORIA(ID_CATEGORIA, NOMBRE) VALUES (:id_categoria, :nombre);");
            $stmt->bindparam(":nombre", $nombre);     
            $stmt->bindparam(":id_categoria", $id_categoria); 
            $stmt->execute();
            echo "Categoria creada con el código". $id_categoria."<br><br>";
        }
        catch(Exception $e)
        {
            $nombre = validar($_POST["nombre"]);
            $id_categoria = validar($_POST["id_cat"]);    
            $parte = substr($id_categoria,-3); 
            $parte += 1;
            $id_categoria = substr_replace($id_categoria,$parte,-strlen($parte));
            $stmt = $conn->prepare("INSERT INTO CATEGORIA(ID_CATEGORIA, NOMBRE) VALUES (:id_categoria, :nombre);");
            $stmt->bindparam(":nombre", $nombre);     
            $stmt->bindparam(":id_categoria", $id_categoria); 
            $stmt->execute();
            echo "Categoria creada con el código ". $id_categoria."<br><br>";

        }
    }
}

//funcion que crea un select con los resultados de la categoria
function selectCategoria($conn)
{
    $stmt = $conn->prepare("SELECT NOMBRE FROM CATEGORIA");
    $stmt->execute();
    $resultado=$stmt->fetchAll();
    if($resultado[0] == null){
        echo "No hay ninguna categoria creada en la base de datos";
    }else{
       echo "NOMBRE DE LA CATEGORIA <select name='nom_categoria' id='nom_categoria'>";
       echo "<option value='' selected>";
       foreach ($resultado as $resultados) {
           echo "<option>".$resultados["NOMBRE"]."</option><br>"; 
       }
       echo "</select><br><br>";
    }
}

//Funcion que crea el id del producto siguiente
function autoCompIdPro($conn)
{
    $stmt = $conn->prepare("SELECT MAX(ID_PRODUCTO) FROM PRODUCTO"); 
    $stmt->execute();
    $resultado=$stmt->fetch();
    if($resultado[0]==null)
    {
        echo"<input type='text' name='id_producto' value=P0001 readonly><br><br>"; 
    }
    else
    {
        $parte = substr($resultado[0],-4); 
        $parte += 1;
        $resultado[0] = substr_replace($resultado[0],$parte,-strlen($parte));
        echo "<input type='text' name='id_producto' value=".$resultado[0]." readonly><br><br>";
    }


}

//Funcion que crea el producto 
function crearProcucto($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        try{
            $id_producto = validar($_POST["id_producto"]);
            $nombre = validar($_POST["nombre"]);
            $precio = validar($_POST["precio"]);
            $nom_categoria = validar($_POST["nom_categoria"]);    

            $stmt1 = $conn->prepare("SELECT ID_CATEGORIA FROM CATEGORIA WHERE NOMBRE = '".$nom_categoria."'");
            $stmt1->execute();
            $resultado1=$stmt1->fetch();
            $id_categoria = $resultado1['ID_CATEGORIA'];

            $stmt = $conn->prepare("INSERT INTO PRODUCTO(ID_PRODUCTO, NOMBRE, PRECIO, ID_CATEGORIA) VALUES (:id_producto, :nombre, :precio, :id_categoria);");
            $stmt->bindparam(":id_producto", $id_producto);   
            $stmt->bindparam(":nombre", $nombre);     
            $stmt->bindparam(":precio", $precio);  
            $stmt->bindparam(":id_categoria", $id_categoria); 
            $stmt->execute();
            echo "Producto creado con el código ". $id_producto."<br><br>";
       } 
       catch(Exception $e)
       {
        
            $id_producto = validar($_POST["id_producto"]);
            $nombre = validar($_POST["nombre"]);
            $precio = validar($_POST["precio"]);
            $nom_categoria = validar($_POST["nom_categoria"]);   
            $parte = substr($id_producto,-4); 
            $parte += 1;
            $id_producto = substr_replace($id_producto,$parte,-strlen($parte));

            $stmt1 = $conn->prepare("SELECT ID_CATEGORIA FROM CATEGORIA WHERE NOMBRE = '".$nom_categoria."'");
            $stmt1->execute();
            $resultado1=$stmt1->fetch();
            $id_categoria = $resultado1['ID_CATEGORIA'];
    
            $stmt = $conn->prepare("INSERT INTO PRODUCTO(ID_PRODUCTO, NOMBRE, PRECIO, ID_CATEGORIA) VALUES (:id_producto, :nombre, :precio, :id_categoria);");
            $stmt->bindparam(":id_producto", $id_producto);   
            $stmt->bindparam(":nombre", $nombre);     
            $stmt->bindparam(":precio", $precio);  
            $stmt->bindparam(":id_categoria", $id_categoria); 
            $stmt->execute();
            echo "Producto creado con el código ". $id_producto;

        }
    }
}

//Funcion que comprueba si la localidad existe y llama a altaAlmacen() si no existe
function comprobarLocalidad($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $localidad = validar($_POST["localidad"]);
        $stmt = $conn ->prepare("SELECT LOCALIDAD FROM ALMACEN WHERE LOCALIDAD='".$localidad."'");
        $stmt->execute();
        $resultado=$stmt->fetch();
        if(isset($resultado[0]))
        {
            echo "Error: La localidad ya tiene un almacen<br><br>";
        }
        else
        {
            altaAlmacen($conn,$localidad);
        }

    }
}


//Funcion que crea el almacen
function altaAlmacen($conn,$localidad)
{
    $stmt = $conn->prepare("INSERT INTO ALMACEN(LOCALIDAD) VALUES (:localidad);");
    $stmt->bindparam(":localidad", $localidad); 
    $stmt->execute();
    echo "Almacen creado en la localidad <br><br>". $localidad;
}

//Funcion que crea el select con los nombres de los productos
function nombreProductos($conn)
{
    $stmt = $conn->prepare("SELECT NOMBRE FROM PRODUCTO");
    $stmt->execute();
    $resultado=$stmt->fetchAll();
    if($resultado[0] == null)
    {
        echo "No hay ningún producto en la base de datos";
    }
    else
    {
       echo "NOMBRE DEL PRODUCTO <select name='nom_producto' id='nom_producto'>";
       echo "<option value='' selected>";
       foreach ($resultado as $resultados)
       {
           echo "<option>".$resultados["NOMBRE"]."</option><br>"; 
       }
       echo "</select><br><br>";
    }
}

//Funcion que crea el select con los ids de los almacenes
function idAlmacenes($conn)
{
    $stmt = $conn->prepare("SELECT NUM_ALMACEN FROM ALMACEN");
    $stmt->execute();
    $resultado=$stmt->fetchAll();
    if($resultado[0] == null)
    {
        echo "No hay ningún almacen en la base de datos";
    }
    else
    {
       echo "NUMERO DE ALMACEN <select name='num_almacen' id='num_almacen'>";
       echo "<option value='' selected>";
       foreach ($resultado as $resultados) 
       {
           echo "<option>".$resultados["NUM_ALMACEN"]."</option><br>"; 
       }
       echo "</select><br><br>";
    }
}

//Funcion que almacena los productos seleccionados
function almacenarProductos($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $cantidad = validar($_POST["cantidad"]);
        $num_almacen = validar($_POST["num_almacen"]);
        $nom_producto = validar($_POST["nom_producto"]);
    
        $stmt1 = $conn->prepare("SELECT ID_PRODUCTO FROM PRODUCTO WHERE NOMBRE='".$nom_producto."'");
        $stmt1->execute();
        $resultado1=$stmt1->fetch();
        $id_producto = $resultado1['ID_PRODUCTO'];


        $stmt = $conn->prepare("INSERT INTO ALMACENA(NUM_ALMACEN,ID_PRODUCTO,CANTIDAD) VALUES (:num_almacen,:id_producto,:cantidad);");
        $stmt->bindparam(":cantidad", $cantidad);
        $stmt->bindparam(":num_almacen", $num_almacen); 
        $stmt->bindparam(":id_producto", $id_producto);
        $stmt->execute();
        echo "Almacenados ".$cantidad." ".$nom_producto." en el almacen número ".$num_almacen."<br><br>";
    }
}

//Funcion que comprueba el stock del producto determinado, en que almacen y en que localidad
function comprobarStock($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $nom_producto = validar($_POST["nom_producto"]);
        $stmt = $conn->prepare("SELECT ID_PRODUCTO FROM PRODUCTO WHERE NOMBRE='".$nom_producto."'");
        $stmt->execute();
        $resultado=$stmt->fetch();
        $id_producto = $resultado['ID_PRODUCTO'];

        $stmt1 = $conn->prepare("SELECT NUM_ALMACEN, CANTIDAD FROM ALMACENA WHERE ID_PRODUCTO='".$id_producto."'");
        $stmt1->execute();
        $resultado1=$stmt1->fetchAll();
        
        if($resultado1==null)
            {
                echo "No hay productos en ningún almacen<br><br>";
            }

        foreach ($resultado1 as $resultados1)
        {
            
            $stmt2 = $conn->prepare("SELECT LOCALIDAD FROM ALMACEN WHERE NUM_ALMACEN='".$resultados1['NUM_ALMACEN']."'");
            $stmt2->execute();
            $resultado2=$stmt2->fetch();
            $localidad = $resultado2['LOCALIDAD'];

             echo "En el almacen número ".$resultados1['NUM_ALMACEN']." de la localidad de ".$localidad." hay ".$resultados1['CANTIDAD']."<br><br>";
        }
    }

}

//Funcion que crea el select con las localidades de los almacenes
function localidadAlmacenes($conn)
{
    $stmt = $conn->prepare("SELECT LOCALIDAD, NUM_ALMACEN FROM ALMACEN");
    $stmt->execute();
    $resultado=$stmt->fetchAll();
    if($resultado[0] == null)
    {
        echo "No hay ningún almacen en la base de datos";
    }
    else
    {
       echo "NUMERO DE ALMACEN <select name='idLocalidad' id='idLocalidad'>";
       echo "<option value='' selected>";
       foreach ($resultado as $resultados) 
       {
            echo "<option>".$resultados["NUM_ALMACEN"]."   ".$resultados["LOCALIDAD"]."</option><br>"; 
       }
       echo "</select><br><br>";
    }
}

//
function informacionProducto($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $idLocalidad = validar($_POST["idLocalidad"]);
        // echo $idLocalidad[0];
        // $parte = substr($idLocalidad,-1); 
        // var_dump($parte);
        $stmt = $conn->prepare("SELECT ID_PRODUCTO,CANTIDAD FROM ALMACENA WHERE NUM_ALMACEN='".$idLocalidad[0]."'");
        $stmt->execute();
        $resultado=$stmt->fetchAll();
        if($resultado[0] == null)
        {
            echo "No hay ningún producto en este almacen";
        }
        else
        {
            foreach ($resultado as $resultados) 
            {
                $stmt1 = $conn->prepare("SELECT ID_PRODUCTO,NOMBRE,PRECIO,ID_CATEGORIA FROM PRODUCTO WHERE ID_PRODUCTO='".$resultados['ID_PRODUCTO']."'");
                $stmt1->execute();
                $resultado1=$stmt1->fetch();
                $nombre = $resultado1['NOMBRE'];
                $precio = $resultado1['PRECIO'];
                $id_categoria = $resultado1['ID_CATEGORIA'];

                echo "En el almacen ".$idLocalidad." hay ".$resultados["CANTIDAD"]." ".$nombre." que cuestan ".$precio." de la categoria ".$id_categoria."<br><br>";
                
            }
        }
    }
}


//funcion que crea el cliente en la base de datos y la cookie con el nif y la contraseña
function crearCliente($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $nif = validar($_POST["nif"]);//COOKIE
        $nombre = validar($_POST["nombre"]);
        $apellido = validar($_POST["apellido"]);//COOKIE
        $cp = validar($_POST["cp"]);
        $direccion = validar($_POST["direccion"]);
        $ciudad = validar($_POST["ciudad"]);
        try{
            $stmt = $conn->prepare("INSERT INTO CLIENTE(NIF,NOMBRE,APELLIDO,CP,DIRECCION,CIUDAD) VALUES (:nif,:nombre,:apellido,:cp,:direccion,:ciudad);");
            $stmt->bindparam(":nif", $nif);
            $stmt->bindparam(":nombre", $nombre); 
            $stmt->bindparam(":apellido", $apellido);
            $stmt->bindparam(":cp", $cp);
            $stmt->bindparam(":direccion", $direccion);
            $stmt->bindparam(":ciudad", $ciudad);
            $stmt->execute();
            echo "<br><br>Cliente creado";
            setcookie("NIF", $nif, time() + (86400 * 30), "/");
            $clave = strrev($apellido);
            setcookie("clave", $clave, time() + (86400 * 30), "/");
            echo "<br><br>Su contraseña es ".$clave. " no la pierda";

        }
        catch(Exception $e)
        {
            echo "<br><br>Revise los datos y vuelva a intentarlo";
        }
    }
}


function comprobarCliente($conn)
{
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $nombre = validar($_POST["nombre"]);
        $clave = validar($_POST["clave"]);

        $stmt = $conn->prepare("SELECT NIF FROM CLIENTE WHERE NOMBRE='".$nombre."'");
        $stmt->execute();
        $resultado=$stmt->fetch();
        if($resultado["NIF"] == $_COOKIE["NIF"]){
            if($clave == $_COOKIE["clave"])
            {
                echo "Bienvenido <br><br>";
                echo "<a href='comprocli.php'> Compra de productos </a><br><br>";
                echo "<a href='http://10.33.6.4/webCompras/comconscli.php'> Consulta de compras </a><br><br>";

            }
            else
            {
                echo "Contraseña erronea";
            }
        }
        else
        {
            echo "Nombre no existente en la base de datos";
        }

    }
}




?>

<!-- NIF VARCHAR(9),
 NOMBRE VARCHAR(40),
 APELLIDO VARCHAR(40),
 CP VARCHAR(5),
 DIRECCION VARCHAR(40),
 CIUDAD VARCHAR(40)); -->