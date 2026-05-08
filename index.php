<?php 
    include 'Contato.class.php';

    $pg = $_GET["pg"] ?? '';

    include 'header.html';

    $Contato = new Contato($pdo);

?>
    <header>
    <h1 id="logo">Agenda de contatos</h1><br>
    </header>

    <div class="divcentro">
        <form action="agenda.php?pg=adicionarContato" method="post"><br>
            <div class="campo">
                <label for="nome">Nome: </label><input type="text" name="nome"/><br>
            </div>
            <div class="campo">
                <label for="celular">Celular: </label><input type="number" name="celular"/><br>
            </div>
            <div class="campo">
                <label for="email">Email: </label><input type="email" name="email"/><br>
            </div>
            <button type="submit">Enviar</button>
        </form>
        <br>
        <a href="agenda.php?pg=contatos">Mostrar Contatos</a><br><hr>