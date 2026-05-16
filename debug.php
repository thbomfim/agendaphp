<?php 
include 'Contato.class.php';

$Contato = new Contato($pdo);

$buscarContato = $Contato->buscarDados();



//var_dump($Contato->buscarDados());

var_dump($buscarContato['nome']);

?>