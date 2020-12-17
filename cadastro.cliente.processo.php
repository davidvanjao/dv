<?php

require 'conexao.banco.php';
//======================================================VARIAVEIS=================================================================


$id="0";

//======================================================CADASTRO SALVAR=================================================================

if(isset($_POST['idEndereco']) && empty($_POST['idEndereco']) == false) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
	$idEndereco = $_POST['idEndereco'];
    $numero = $_POST['numero'];           
    $cpf = $_POST['cpf']; 

    $sql = $pdo->prepare("INSERT INTO tb_cliente SET nome = :nome, idEndereco = :idEndereco, numero = :numero, telefone = :telefone, cpf = :cpf");
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":telefone", $telefone);
    $sql->bindValue(":idEndereco", $idEndereco);
    $sql->bindValue(":numero", $numero);
    $sql->bindValue(":cpf", $cpf);
    $sql->execute();

    header("Location:/cadastro.cliente.painel.1.php");

    exit;
} 



//======================================================PREENCHER DADOS=================================================================

if(isset($_GET['idCliente']) && empty($_GET['idCliente']) == false) {
    $id = addslashes($_GET['idCliente']);

    $sql = "SELECT a.id, a.nome, a.cpf, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero 
    from tb_cliente a, tb_endereco b 
    WHERE a.id = '$id'
    and a.idEndereco = b.id 
    order by a.nome";

    $sql = $pdo->query($sql);
    if($sql->rowCount() > 0) {

        $cliente = $sql->fetch();
    }
}


//======================================================ATUALIZAR DADOS=================================================================

if(isset($_GET['idEnd']) && empty($_GET['idEnd']) == false) {
    $idEndereco = addslashes($_GET['idEnd']);
    $id = addslashes($_GET['id']);

    if(isset($_POST['nome']) && empty($_POST['nome']) == false) {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $numero = $_POST['numero'];  
        $cpf = $_POST['cpf'];      
        $idEnd = $idEndereco;   
        
        $sql = $pdo->prepare("UPDATE tb_cliente SET nome = :nome, idEndereco = :idEndereco, cpf = :cpf, numero = :numero, telefone = :telefone WHERE id = '$id'");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":numero", $numero);
        $sql->bindValue(":cpf", $cpf);
        $sql->bindValue(":idEndereco", $idEnd);

        $sql->execute();

        header("Location:/cadastro.cliente.painel.1.php"); 

        exit;

    }

    $sql = "SELECT a.id, a.nome, a.cpf, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero 
    from tb_cliente a, tb_endereco b 
    WHERE a.id = '$id'
    and b.id = '$idEndereco' 
    order by a.nome";

    $sql = $pdo->query($sql);
    if($sql->rowCount() > 0) {

        $cliente = $sql->fetch();
    }
    
} else {

    if(isset($_POST['nome']) && empty($_POST['nome']) == false) {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $cpf = $_POST['cpf'];  
        $numero = $_POST['numero'];       
        
        $sql = $pdo->prepare("UPDATE tb_cliente SET nome = :nome, cpf = :cpf, numero = :numero, telefone = :telefone WHERE id = '$id'");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":cpf", $cpf);
        $sql->bindValue(":numero", $numero);
        $sql->execute();

        header("Location:/cadastro.cliente.painel.1.php"); 

        exit;

    }
}

?>