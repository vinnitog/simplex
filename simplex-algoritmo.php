<?php 

$objetivo = $_POST['objetivo'];

$restricao = $_POST['restricao'];
$recurso = $_POST['recurso'];


$totalobjetivo = count($objetivo);
$totalrestricao = count($restricao);

echo "<br/><br/> Restricao: ";
print_r($restricao);
echo "<br/><br/> Recurso: ";
print_r($recurso);
echo "<br/><br/> Objetivo:";
print_r($objetivo);
echo "<br/><br/>";
echo "total objetivo: ".$totalobjetivo;
echo "<br/><br/>";
echo "total restricao: ".$totalrestricao;

echo "<br/><br/>";
for ($i = 0 ; $i < $totalobjetivo ; $i++) 
{
	echo $objetivo[$i];
	echo "X".($i+1);			
	
	echo "<br/>";
}
echo "<br/><br/>";
for ($i = 0 ; $i < $totalrestricao ; $i++) 
{
	echo $restricao[$i];
	echo " <= ";			
	echo $recurso[$i];
	echo "<br/>";
}


while ($i<= $objetivo && $z_rest <= $restricao) 
{
	$z_vd = $objetivo;
	$z_rest = $restricao;
	$i++;
	break;
}

echo "array variaveis decisao"."<br>";
print_r($z_vd);
echo "<br>";
echo "array variaveis de folga"."<br>";
print_r($z_rest);



 ?>