<?php

session_start();
require 'conexao.banco.php';
require 'classes/usuarios.class.php';
require 'cadastro.cliente.processo.php';


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
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Entrega</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/cadastroCliente.css">
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
                                <a href="cadastro.cliente.painel.1.php">voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <form method="POST">

                                            <div class="">
                                                <label>Nome:</label></br>
                                                <input type="text" autocomplete="off" name="nome" placeholder="" required="required" value="<?php echo $cliente['nome'];?>"/>
                                            </div>

                                            <div class="">
                                                <label>Telefone:</label></br>
                                                <input type="tel" pattern="^\(\d{2}\)\d{5}-\d{4}$" title="Se atentar ao formato correto: (XX)91234-1234" autocomplete="off" name="telefone" placeholder="" required="required" value="<?php echo $cliente['telefone'];?>"/>
                                            </div>      

                                            <div class="">
                                                <label>CPF:</label></br>
                                                <input type="text" pattern="^\d{3}\.\d{3}\.\d{3}-\d{2}$" title="Se atentar ao formato correto: 123.123.123-00" autocomplete="off" name="cpf" placeholder="" required="required" value="<?php echo $cliente['cpf'];?>"/>
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

                                            <input class="input-botao" type="button" name="botao-adicionar" value="Alterar Endereço" onclick="window.location='cadastro.cliente.endereco.php?id=<?php echo $id; ?>'"/>
                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Atualizar"/>

                                        </form>

                        
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