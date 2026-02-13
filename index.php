<?php 
include 'Contato.class.php';

$pg = $_GET["pg"];

include "header.html";
?>

<h1>Agenda de contatos</h1><br>
<form action="index.php?pg=adicionarContato" method="post"><br>
<label for="nome">Nome: <input type="text" name="nome"/></label><br>
<label for="celular">Celular: <input type="number" name="celular"/></label><br>
<label for="email">Email: <input type="email" name="email"/></label><br>
<button type="submit">Enviar</button><br>
<a href="?pg=contatos">Mostrar Contatos</a>

<?php
if ($pg == "adicionarContato") 
{
    $Contato = new Contato($pdo);
    $Contato->adicionarContato();

}
elseif ($pg == "contatos") 
{
    $Contato = new Contato($pdo);
    $Contato->mostrarContatos();
}

include "footer.html";

?>