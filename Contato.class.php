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
        $this->id = $_POST["id"];
        $this->nome = $_POST["nome"];
        $this->celular = $_POST["celular"];
        $this->email = $_POST["email"];
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

        var_dump($this->nome);
        var_dump($this->celular);
        var_dump($this->email);

        $stmt->execute();

        if ($stmt->rowCount() > 0 ) {
            echo 'Contato Adicionado com Suceso!';
        }else{
            echo 'Ocorreu algum erro!';
        }

    }

    public function mostrarContatos() {

    }


}

?>