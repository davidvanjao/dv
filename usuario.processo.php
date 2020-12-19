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

//==============================================================ADICIONAR======================================================

if(isset($_POST['nome']) && empty($_POST['nome']) == false) {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $nomeCompleto = "$nome $sobrenome";
	$usuario = "$nome.$sobrenome";
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
    $sql->bindValue(":nome", $nomeCompleto);
    $sql->bindValue(":usuario", $usuario);
    $sql->bindValue(":senha", $senha);
    $sql->bindValue(":permissao", $permissoes);  

    $sql->execute();

    header("Location:/usuario.painel.1.php");

    exit;

} else {

    header("Location:/usuario.painel.1.php");

}

//==============================================================EDITAR======================================================

if(isset($_POST['idAtualiza']) && empty($_POST['idAtualiza']) == false) {

    $id = addslashes($_POST['idAtualiza']);

    if(isset($_POST['nomeAtualiza']) && empty($_POST['nomeAtualiza']) == false) {

        $nome = $_POST['nomeAtualiza'];
        $sobrenome = $_POST['sobrenomeAtualiza'];
        $nomeCompleto = "$nome $sobrenome";
        $usuario = "$nome.$sobrenome";
        $senha = $_POST['senhaAtualiza'];
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

        $sql = $pdo->prepare("UPDATE tb_usuarios SET nome = :nome, usuario = :usuario, senha = :senha, permissao = :permissao WHERE id = $id");
        $sql->bindValue(":nome", $nomeCompleto);
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":permissao", $permissoes);  
    
        $sql->execute();
    
        //header("Location:/usuario.painel.1.php");

    }
}

?>