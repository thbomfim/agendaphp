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
        <form action="index.php?pg=adicionarContato" method="post"><br>
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
        <a href="?pg=contatos">Mostrar Contatos</a><br><hr>

<?php
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
                    <div class="campo">
                        <label for="nome">Nome: </label><input type="text" name="nome" value="<?=$buscarContato['nome']?>"/><br>
                    </div>
                    <div class="campo">
                        <label for="celular">Celular: </label><input type="number" name="celular" value="<?=$buscarContato['celular']?>"/><br>
                    </div>
                    <div class="campo">
                        <label for="email">Email: </label><input type="email" name="email" value="<?=$buscarContato['email']?>"/><br>
                    </div>
                    <button type="submit">Enviar</button>
                </form>
        <?php
        }
        elseif ($pg == "alterarContatook") 
        {
            $id = $_POST['id'] ?? '';
            $Contato->alterarContato($id);
        }

        include 'footer.html';
?>
    </div>