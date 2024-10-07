<?php
//Objeto en PHP
$objeto = new stdClass();
$objeto->nombre="Bryan";
$objeto->apellido="Pazmino";
print_r($objeto->nombre);
echo(gettype($objeto));
echo("<br>");

//Vector en PHP

$colores = array("Azul", "Rojo", "Amarillo");
print_r($colores[0]);
echo("<br>");

//Array asosiativo clave valor
$arrayasoc= array("nombre"=>"Bryan","apellido"=>"Pazmino");
print_r($arrayasoc['nombre']);
echo("<br>");

//Lista
$lista = '{"nombre"=>"Bryan","apellido"=>"Pazmino"}';
print_r($lista);
echo("<br>");

//JSON_ENCODE.- convierte un php a json
$Mijson = json_encode($arrayasoc);
echo($Mijson);
echo(gettype($Mijson));
echo("<br>");

//Json_DECODE.- json a tipo de dato de php
$lista1 = '{"nombre":"Bryan","apellido":"Pazmino"}';
print_r($lista1);
$Miphp = json_decode($lista1);
print_r($Miphp->nombre);
echo(gettype($Miphp));

?>