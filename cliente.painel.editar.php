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

$id = 0;

if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);

    if(isset($_POST['nome']) && empty($_POST['nome']) == false) {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $numero = $_POST['numero'];           

        $sql = $pdo->prepare("UPDATE tb_cliente SET nome = :nome, numero = :numero, telefone = :telefone WHERE id = '$id'");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":numero", $numero);
        $sql->execute();

        header("Location:/cliente.painel.1.php"); 

        exit;

    }

    $sql = "SELECT a.id, a.nome, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero 
    from tb_cliente a, tb_endereco b 
    WHERE a.id = '$id'
    and a.idEndereco = b.id 
    order by a.nome";

    $sql = $pdo->query($sql);
    if($sql->rowCount() > 0) {

        $cliente = $sql->fetch();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Entrega</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/cesta-basica.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">

                <div class="conteudo-Central">
                    <div class="corpo">
                        <header class="desktop_header">
                            <div class="logo">
                                <img src="">
                            </div>
                            <div class="superiorMenu">
                                <a href="cliente.painel.1.php">voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-cesta">
                                    <div class="campo-inserir">
                                        <form class="cesta-area" id="cesta-area" name="buscar-form" method="POST">

                                            <div class="">
                                                <label>Nome:</label></br>
                                                <input type="text" autocomplete="off" name="nome" placeholder="" required="required" value="<?php echo $cliente['nome'];?>"/>
                                            </div>

                                            <div class="">
                                                <label>Telefone:</label></br>
                                                <input type="text" autocomplete="off" name="telefone" placeholder="" required="required" value="<?php echo $cliente['telefone'];?>"/>
                                            </div>      

                                            <div class="">
                                                <label>Cidade/Estado:</label></br>
                                                <input type="text" autocomplete="off" name="cidade" placeholder="" required="required" value="<?php echo $cliente['cidadeEstado'];?>" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Bairro:</label></br>
                                                <input type="text" autocomplete="off" name="bairro" placeholder="" required="required" value="<?php echo $cliente['bairro'];?>" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Longradouro:</label></br>
                                                <input type="text" autocomplete="off" name="logradouro" required="required" value="<?php echo $cliente['logradouro'];?>" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Numero:</label></br>
                                                <input type="number" min='0' autocomplete="off" name="numero" required="required" value="<?php echo $cliente['numero'];?>"/>
                                            </div>

                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar"/>

                                        </form>
                                    </div>

                                    <div class="tabela-titulo">
                                       
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            
                                        </div>
                                    </div>                                    
                                </div> 

                            </div> 
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </body>


</html>