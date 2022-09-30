<HTML>
<HEAD><TITLE> EJ4B – Tabla Multiplicar</TITLE></HEAD>
<BODY>

<?php
$modsDaw1 = array("Bases Datos", "Entornos Desarrollo", "Programación");
$modsDaw2 = array("Sistemas Informáticos","FOL","Mecanizado");
$modsDaw3 = array("Desarrollo Web ES","Desarrollo Web EC","Despliegue","Desarrollo Interfaces", "Inglés");
$cont=count($modsDaw1);
$cont1=count($modsDaw2);
$cont2=count($modsDaw3);
$i=$cont;
for($x=0;$x<$cont1;$x++){
	$modsDaw1[$i]=$modsDaw2[$x];
	$i++;
}
for($x=0;$x<$cont2;$x++){
	$modsDaw1[$i]=$modsDaw3[$x];
	$i++;
}
print_r($modsDaw1);

$modsDaw1A = array("Bases Datos", "Entornos Desarrollo", "Programación");
$modsDaw2A = array("Sistemas Informáticos","FOL","Mecanizado");
$modsDaw3A = array("Desarrollo Web ES","Desarrollo Web EC","Despliegue","Desarrollo Interfaces", "Inglés");
$Merge=array_merge($modsDaw1A,$modsDaw2A,$modsDaw3A);
echo "<br>";
echo "<br>";
print_r($Merge);
echo "<br>";	
echo "<br>";
$modsDaw1B = array("Bases Datos", "Entornos Desarrollo", "Programación");
$modsDaw2B = array("Sistemas Informáticos","FOL","Mecanizado");
$modsDaw3B = array("Desarrollo Web ES","Desarrollo Web EC","Despliegue","Desarrollo Interfaces", "Inglés");
array_push($modsDaw1B, $modsDaw2B, $modsDaw3B);
print_r($modsDaw1B);






?>

</BODY>
</HTML>

