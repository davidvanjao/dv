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

if($usuarios->temPermissao('USUARIO') == false) {
    header("Location:index.php");
    exit;
}

if(isset($_POST['nome']) && empty($_POST['nome']) == false) {
    $nome = $_POST['nome'];
	$usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $per = $_POST['permissao'];
    
    $per0 = "";
    $per1 = "";

    if(empty($per[0])) {

    } else {
        $per0 = $per[0];
    }   

    if(empty($per[1])) {

    } else {
        $per1 = substr_replace($per[1], ',',0,0);
    } 

    $permissoes = $per0.$per1;

    //var_dump($permissoes);           

    $sql = $pdo->prepare("INSERT INTO tb_usuarios SET nome = :nome, usuario = :usuario, senha = :senha, permissao = :permissao");
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":usuario", $usuario);
    $sql->bindValue(":senha", $senha);
    $sql->bindValue(":permissao", $permissoes);  

    $sql->execute();

    header("Location:/usuario.painel.php");

    exit;

} else {

    header("Location:/usuario.painel.php");

}


?>