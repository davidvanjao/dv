<?php
session_start();
require 'conexao.banco.php';
require 'classes/usuarios.class.php';


//==============================================================ADICIONAR======================================================

if(isset($_POST['nome']) && empty($_POST['nome']) == false) {
    $nome = strtoupper($_POST['nome']);
    $sobrenome = strtoupper($_POST['sobrenome']);
    $nomeCompleto = "$nome $sobrenome";
	$usuario = "$nome.$sobrenome";
    $senha = $_POST['senha'];
    $per = $_POST['permissao'];
    
    for($x = 0; $x < count($per); $x++) {
        $permissoes = implode(',',$per);
    }        

    $sql = $pdo->prepare("INSERT INTO tb_usuarios SET nome = :nome, usuario = :usuario, senha = :senha, permissao = :permissao");
    $sql->bindValue(":nome", $nomeCompleto);
    $sql->bindValue(":usuario", $usuario);
    $sql->bindValue(":senha", $senha);
    $sql->bindValue(":permissao", $permissoes);  

    $sql->execute();

    header("Location:/usuario.painel.1.php");

    exit;

}

//==============================================================EDITAR======================================================

if(isset($_POST['idAtualiza']) && empty($_POST['idAtualiza']) == false) {

    $id = addslashes($_POST['idAtualiza']);

    if(isset($_POST['nomeAtualiza']) && empty($_POST['nomeAtualiza']) == false) {

        $nome = strtoupper($_POST['nomeAtualiza']);
        $sobrenome = strtoupper($_POST['sobrenomeAtualiza']);
        $nomeCompleto = "$nome $sobrenome";
        $usuario = "$nome.$sobrenome";
        $senha = $_POST['senhaAtualiza'];
        $per = $_POST['permissao'];        

        for($x = 0; $x < count($per); $x++) {
            $permissoes = implode(',',$per);
        }
        

        $sql = $pdo->prepare("UPDATE tb_usuarios SET nome = :nome, usuario = :usuario, senha = :senha, permissao = :permissao WHERE id = $id");
        $sql->bindValue(":nome", $nomeCompleto);
        $sql->bindValue(":usuario", $usuario);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":permissao", $permissoes);  
    
        $sql->execute();
    
        header("Location:/usuario.painel.1.php");

    }
}

//==============================================================LIBERAR======================================================

if(isset($_GET['liberar']) && !empty($_SESSION['h_login'])) {
    $usuario = $_GET['liberar'];

    $sql = $pdo->prepare("SELECT * FROM tb_log_sessao WHERE usuario = :usuario AND status = 'S' ORDER BY data_login DESC LIMIT 1");
    $sql->bindValue(":usuario", $usuario);
    $sql->execute();

    if($sql->rowCount() > 0) {

        $sql = $pdo->prepare("UPDATE tb_log_sessao SET data_exit = NOW(), status = 'N' WHERE usuario = :usuario");
        $sql->bindValue(":usuario", $usuario);
        $sql->execute();

        header("Location: usuario.painel.online.php");

    }  else {
        
        echo "<script>alert('Não existe usuario para ser liberado!');</script>";
        header("Location: usuario.painel.1.php");
        
    }
}