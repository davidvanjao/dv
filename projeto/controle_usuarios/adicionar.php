<?php
require 'config.php';

    if(isset($_POST['nome']) && empty($_POST['nome']) == false) { //se existir/ e ele nao estiver vazio.

        $nome = addslashes($_POST['nome']);
        $usuario = addslashes($_POST['usuario']);
        $senha = addslashes($_POST['senha']);

        $sql = "INSERT INTO tb_usuarios SET nome = '$nome', usuario = '$usuario', senha = '$senha', permissao = 'CAR,PES'";
        $pdo->query($sql);

        header("Location: index.php");
    }


?>

<form method="POST">
    Nome:<br/>
    <input type="text" name="nome"/><br/><br/>

    Usuario:<br/>
    <input type="text" name="usuario"/><br/><br/>
    

    Senha:<br/>
    <input type="password" name="senha"/><br/><br/>

    <input type="submit" value="Cadastrar"/><br/>

</form>