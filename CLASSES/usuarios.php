<?php


class usuarios
{
    private $pdo;
    public $msgErro = "";

    public function conectar($nome, $host, $usuario, $senha){
        global $pdo;
        global $msgErro;

        try{
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario,$senha);
        } catch (PDOException $e){
            $msgErro = $e -> getMessage();
        }
    }

    public function cadastrar($nome, $cpf, $telefone, $email, $senha){
        global $pdo;
        //verificação
        $sql = $pdo -> prepare("SELECT id_cliente FROM cliente WHERE email_cliente = :e");
        $sql -> bindValue(":e", $email);
        $sql -> execute();
        if ($sql -> rowCount() > 0){
            return false;
        } else {
            //cadastro
            $sql = $pdo -> prepare("INSERT INTO cliente (nome_cliente, cpf_cliente, telefone_cliente, email_cliente, senha_cliente) VALUES(:n, :d, :t, :e, :s)");
            $sql -> bindValue(":n", $nome);
            $sql -> bindValue(":d", $cpf);
            $sql -> bindValue(":t", $telefone);
            $sql -> bindValue(":e", $email);
            $sql -> bindValue(":s", md5($senha));

            $sql -> execute();
            return true;
        }

    }

    public function logar($email, $senha){
        global $pdo;

        // verificação
        $sql = $pdo -> prepare("SELECT id_cliente FROM cliente WHERE email_cliente = :e AND  senha_cliente = :s");
        $sql -> bindValue(":e", $email);
        $sql -> bindValue(":s", md5($senha));
        $sql -> execute();

        if ($sql -> rowCount() > 0){
            //iniciar sessão
            $info = $sql -> fetch();
            session_start();
            $_SESSION['id_cliente'] = $info['id_cliente'];
            return true;
        } else {
            return false;
        }

    }
}