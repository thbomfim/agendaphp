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
<button type="submit">Enviar</button>
</form>
<br>
<a href="?pg=contatos">Mostrar Contatos</a><br><hr>

<?php
    $Contato = new Contato($pdo);

if ($pg == "adicionarContato") 
{
    $Contato->adicionarContato();

}
elseif ($pg == "contatos") 
{
    $Contato->mostrarContatos();
}
elseif ($pg == "deletarContato") 
{
    $Contato->deletarContato();
}
elseif ($pg == "alterarContato") 
{
    $id = $_GET['id'] ?? '';
    $buscarContato = $Contato->buscarDados($id);
?>
        <form action="index.php?pg=alterarContatook" method="post">
        <input type="hidden" name="id" value="<?=$buscarContato['id']?>"/>
        <label for="nome">Nome: <input type="text" name="nome" value="<?=$buscarContato['nome']?>"/></label><br>
        <label for="celular">Celular: <input type="number" name="celular" value="<?=$buscarContato['celular']?>"/></label><br>
        <label for="email">Email: <input type="email" name="email" value="<?=$buscarContato['email']?>"/></label><br>
        <button type="submit">Enviar</button>
        </form>
<?php
}elseif ($pg == "alterarContatook") 
{
    $id = $_POST['id'] ?? '';
    $Contato->alterarContato($id);
}

include "footer.html";

?>