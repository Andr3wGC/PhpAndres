<?php
$N1 = $_POST["Operando1"];
$N2 = $_POST["Operando2"];
$operacion = $_POST["operacion"];

if($operacion=="Suma"){
    $operacion= "+";
    echo "Resultado operacion ".$N1." ".$operacion." ".$N2. " = ", $N1+$N2;
}elseif($operacion=="Resta"){
    $operacion= "-";
    echo "Resultado operacion ".$N1." ".$operacion." ".$N2. " = ", $N1-$N2;
}elseif($operacion=="Multiplicacion"){
    $operacion= "*";
    echo "Resultado operacion ".$N1." ".$operacion." ".$N2. " = ", $N1*$N2;
}elseif($operacion=="Division"){
    $operacion= "/";
    echo "Resultado operacion ".$N1." ".$operacion." ".$N2. " = ", $N1/$N2;
}
?>