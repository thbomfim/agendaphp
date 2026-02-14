<?php 
include "config.php";

class Contato {
    public $id;
    public $nome;
    public $celular;
    public $email;
    public $pdo;

    function __construct($dbConnection) {
        $this->pdo = $dbConnection;
        $this->id = $_POST["id"] ?? 'null';
        $this->nome = $_POST["nome"] ?? 'null';
        $this->celular = $_POST["celular"] ?? 'nul';
        $this->email = $_POST["email"] ?? 'null';
    }

    public function adicionarContato() {
        //verifica se o contato ja existe e nao permite adicionar outro contato caso algum dado se repetir
        $sql = "SELECT 1 FROM agenda WHERE nome = :nome || celular = :celular || email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":celular", $this->celular);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            die("Um dos dados desse contato ja existe");
        }

        //insert do contato
        $sql = "INSERT INTO agenda (nome, celular, email) VALUES (:nome, :celular, :email)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":celular", $this->celular);
        $stmt->bindParam(":email", $this->email);

        $stmt->execute();

        if ($stmt->rowCount() > 0 ) {
            echo 'Contato Adicionado com Suceso!';
        }else{
            echo 'Ocorreu algum erro!';
        }

    }

    public function mostrarContatos() {
        $sql = "SELECT * FROM agenda";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $chave => $valor) {
            ?>
            <li><strong> Nome :</strong><?= $valor['nome'] ?></li>
            <li><strong> celular :</strong><?= $valor['celular'] ?></li>
            <li><strong> Email :</strong><?= $valor['email'] ?></li>
            <a href="index.php?pg=deletarContato&id=<?=$valor['id']?>">[X]</a>
            <a href="index.php?pg=alterarContato&id=<?=$valor['id']?>&nome=<?=$valor['nome']?>&celular=<?=$valor['celular']?>&email=<?=$valor['email']?>">[A]</a>
            <hr>
            <?php
            }
    }  
    
    public function deletarContato() {
        $id = $_GET["id"];

    //verificar se não o contato existe
        $sql = "SELECT * FROM agenda WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!$result) {
            die("Este contato não existe!");
        }

        //deletar contato
        $sql = "DELETE FROM agenda WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo 'Contato apagado!';
        } else {
            echo 'Ocorreu algum erro!';
        }
    }

     public function alterarContato() {
        $id = $_GET["id"];

    //verificar se não o contato existe
        $sql = "SELECT * FROM agenda WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!$result) {
            die("Este contato não existe!");
        }

        //atualiza as informacoes do contato
        $sql = "UPDATE agenda set nome = :nome, celular = :celular, email = :email WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":celular", $celular);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo 'Contato alterado com sucesso!';
        } else {
            echo 'Ocorreu algum erro!';
        }
     }


}

?>