
<?php
require_once 'CLASSES/usuarios.php';
$user = new usuarios();
define('host_name', 'localhost');
define('host_user', 'root');
define('host_pwd', "").
define('db_name', 'bicicletaria');
?>

<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title> Login </title>
	<link rel="stylesheet" href="CSS/estilo.css">
</head>
<body>
	<div id="corpo-form">
	<h1>Entrar</h1>
	<form method="POST">
		<input type="email" name="email" placeholder="Email">
		<input type="password" name="senha" placeholder="Senha">
		<input type="submit" value="Acessar">
		<a href="cadastro.php"> Ainda não é inscrito?<strong>Cadastre-se</strong></a>
	</form>
	</div>
    <?php
    if(isset($_POST['email']))
    {
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    if (!empty($email) && !empty($senha)) {
        $user -> conectar(db_name, host_name,host_user,host_pwd);
        if ($user -> msgErro == ""){
            if($user -> logar($email, $senha)){
                header("location: arearestrita.php");
            } else {
                ?>
                <div class="msg-erro"> Email ou Senha não conferem </div>
            <?php
            }
        } else {
            ?>
            <div class="msg-erro">
                <?php
                echo "ERRO: " . $user -> msgErro;
                ?>
            </div>
        <?php
        }

    }else {
        ?>
        <div class="msg-erro"> Por gentileza. Preencha os dois campos </div>
    <?php
        }
    }
    ?>
</body>
</html>
