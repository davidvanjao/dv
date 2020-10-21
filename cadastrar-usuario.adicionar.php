<?php
session_start();
require 'conexao.banco.php';
require 'classes/usuarios.class.php';


if (isset($_SESSION['logado']) && empty($_SESSION['logado']) == false) {
} else {
    header("Location: login.php");
}

$usuarios = new Usuarios($pdo);
$usuarios->setUsuario($_SESSION['logado']);

if($usuarios->temPermissao('PES') == false) {
    header("Location:index.php");
    exit;
}

if(isset($_POST['nome']) && empty($_POST['nome']) == false) {
    $nome = $_POST['nome'];
	$usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $permissao = $_POST['permissao'];

    foreach($permissao as $per) {
        $per = substr_replace($per, ',',10,0);

        
    }
    


           

    $sql = $pdo->prepare("INSERT INTO tb_usuarios SET nome = :nome, usuario = :usuario, senha = :senha, permissao = :permissao");
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":usuario", $usuario);
    $sql->bindValue(":senha", $senha);
    $sql->bindValue(":permissao", $per);

   

    $sql->execute();

    header("Location:/cadastrar-usuario.painel.php");

    exit;

} else {

    header("Location:/cadastrar-usuario.painel.php");

}


?>