<HTML>

    <BODY>
        <h1>Conversor binario</h1>
    <form name='calculadora' method='post'>
        Numero decimal: <input type='text' name='decimal' size=15><br><br>
        <input type='radio' checked name='operacion' value='binario'>Binario</br>
        <input type='radio' name='operacion' value='octal'>Octal</br>
        <input type='radio' name='operacion' value='hexagesimal'>Hexagesimal</br>


        <input type="submit" value="enviar">
        <input type="reset" value="borrar">
    </FORM>
    </BODY>
</HTML>
    
<?php
$N1 = limpiar_campo($_POST["decimal"]);
function limpiar_campo($campoformulario) {
    $campoformulario = trim($campoformulario);
    $campoformulario = stripslashes($campoformulario);
    $campoformulario = htmlspecialchars($campoformulario); 
    return $campoformulario;
  }
  if($_POST["operacion"]=="binario"){
    $N1=bindec($N1);
    echo $N1;
    echo "<input value= '$N1'></input>";
    
  }elseif($_POST["operacion"]){

  }elseif($_POST["operacion"]){
    
  }
  function conversion($dec){
	$i=$dec;
	$numbin="";
if($dec==1){
		$numbin=1;
	}elseif($dec==2){
		$numbin=10;
	}else{
	do{
	$dec=$dec%2;
	$numbin="$dec$numbin";	
	$i=$i/2;
	$dec=$i;
	}while($i>=1);
	}
	//echo "El numero en binario es <input value='$numbin'></input>";
}
  

?>
