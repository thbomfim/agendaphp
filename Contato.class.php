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
            <!--colocar um alert para confirmar o delete no link abaixo--> 
            <a href="index.php?pg=deletarContato&id=<?=$valor['id']?>">[X]</a> |
            <a href="index.php?pg=alterarContato&id=<?=$valor['id']?>">[A]</a>
            <hr>
            <?php
            }
    }  
    
    public function deletarContato() {
        try {
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
        }
        
        }catch (PDOException $e){
            echo 'Ocorreu algum erro! :' .$e->getMessage();
        }
        catch (Exception $e) {
            echo 'Ocorreu algum erro:' .$e->getMessage();
        }
    }

     public function alterarContato($id) {
        try {
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $celular = $_POST['celular'];
            $email = $_POST['email'];

            var_dump($id);
            var_dump($nome);
            var_dump($celular);
            var_dump($email);

        //verificar se não o contato existe
            $sql = "SELECT * FROM agenda WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch();

            if (!$result) {
                //ao invez do die lancei em uma excecao para cair no catch
                throw new Exception("Este contato não existe!");
            }

            //atualiza as informacoes do contato
            $sql = "UPDATE agenda set nome = :nome, celular = :celular, email = :email WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':celular' => $celular,
                ':email' => $email,
                ':id' => $id
            ]);

                echo 'Contato alterado com sucesso!';
     } catch (PDOException $e) {
            //captura os erros de sintaxe SQL ou conexao
            echo "Erro no banco de dados: " .$e->getMessage();
        } catch (Exception $e) {
            // Captura o erro do "contato não existe" ou outros erros manuais
            echo "Error: " . $e->getMessage();
        }
     }

     public function buscarDados($id) {
        //verificar se não o contato existe
        $sql = "SELECT * FROM agenda WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!$result) {
            die("Este contato não existe!");
        }

        //busca os dados
        $sql = "SELECT * FROM agenda WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

     }


}

?>