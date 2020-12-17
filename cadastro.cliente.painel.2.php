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


$idEnd = 0;
if(isset($_GET['idEnd']) && empty($_GET['idEnd']) == false) {
    $idEnd = addslashes($_GET['idEnd']);


    $sql = "SELECT * FROM tb_endereco WHERE id = '$idEnd'";
    $sql = $pdo->query($sql);
    if($sql->rowCount() > 0) {

        $endereco = $sql->fetch();
    }

} else {
    echo "Não deu certo!";
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
                                        <form method="POST" action="cadastro.cliente.processo.php">

                                            <div class="">
                                                <label>Nome:</label></br>
                                                <input type="text" autocomplete="off" name="nome" placeholder="" required="required" value=""/>
                                            </div>

                                            <div class="">
                                                <label>Telefone:</label></br>
                                                <input type="tel"  pattern="^\(\d{2}\)\d{5}-\d{4}$" title="Se atentar ao formato correto: (XX)91234-1234" autocomplete="off" name="telefone" placeholder="(XX)9XXXX-XXXX" required="required"/>
                                            </div>      

                                            <div class="">
                                                <label>CPF:</label></br>
                                                <input type="text"  pattern="^\d{3}\.\d{3}\.\d{3}-\d{2}$" title="Se atentar ao formato correto: 123.123.123-00" autocomplete="off" name="cpf" placeholder="XXX.XXX.XXX-XX" required="required"/>
                                            </div>   

                                            <div class="">
                                                <label>Cidade/Estado:</label></br>
                                                <input type="text" autocomplete="off" name="cidade" placeholder="" required="required" value="<?php echo $endereco['cidadeEstado'];?>" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Bairro:</label></br>
                                                <input type="text" autocomplete="off" name="bairro" placeholder="" required="required" value="<?php echo $endereco['bairro'];?>" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Longradouro:</label></br>
                                                <input type="text" autocomplete="off" name="logradouro" required="required" value="<?php echo $endereco['logradouro'];?>" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Numero:</label></br>
                                                <input type="number" min='0' autocomplete="off" name="numero" required="required"/>
                                            </div>

                                            <input type="hidden" autocomplete="off" name="idEndereco" placeholder="" required="required" value="<?php echo $endereco['id'];?>" readonly="readonly"/>

                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Salvar"/>

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