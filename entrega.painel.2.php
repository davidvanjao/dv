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

if($usuarios->temPermissao('ENT') == false) {
    header("Location:index.php");
    exit;
}


//========================================================================================================


$id = 0;
if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);


    $sql = "SELECT * FROM tb_endereco WHERE id = '$id'";
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
        <link rel="stylesheet" href="assets/css/entrega.css">
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
                                <a href="entrega.painel.php">voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <form class="form-cesta-2" name="buscar-form" method="POST" action="entrega.processo.php">

                                            <div class="">
                                                <label>Data:</label></br>
                                                <input type="date" value="<?php echo date('Y-m-d');?>" id="data" autocomplete="off" name="data" required="required"/>
                                            </div>

                                            <div class="">
                                                <input type="hidden" autocomplete="off" name="cep" placeholder="" required="required" value="<?php echo $endereco['cep'];?>" readonly="readonly"/>
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
                                                <label>Compras:</label></br>
                                                <input type="number" autocomplete="off" name="compra" placeholder="" required="required" value="1" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Valor:</label></br>
                                                <input type="text" autocomplete="off" name="valor" required="required" pattern="[0-9.,]{2,}"/>
                                            </div>

                                            <div class="">
                                                <label>Numero de Caixas:</label></br>
                                                <input type="number" min='0' autocomplete="off" name="quantidade" placeholder="" required="required"/>
                                            </div>

                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar"/>
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