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


    $sql = "SELECT a.id, a.dataa, b.nome, c.cidadeEstado, c.logradouro, b.numero, a.statuss
    from tb_log_delivery as a join tb_cliente as b join tb_endereco as c 
    on a.idCliente = b.id 
    and b.idEndereco = c.id
    where a.id = '$id'";

    $sql = $pdo->query($sql);
    if($sql->rowCount() > 0) {

        $log = $sql->fetch();
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
                                <a href="delivery.painel.3.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-cesta">
                                    <div class="campo-inserir">
                                        <form class="cesta-area" name="buscar-form" method="POST" action="delivery.processo.adicionar3.php">

                                            <input type="hidden" value="<?php echo $log['id'];?>" name="id" autocomplete="off" required="required"/>

                                            <div class="">
                                                <label>Data:</label></br>
                                                <input type="date" value="<?php echo $log['dataa'];?>" name="data" autocomplete="off" required="required"/>
                                            </div>

                                            <div class="">
                                                <label>Nome:</label></br>
                                                <input type="text" value="<?php echo $log['nome'];?>" autocomplete="off" name="nome" placeholder="" required="required" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Endereço:</label></br>
                                                <input type="text" value="<?php echo $log['logradouro'];?>" autocomplete="off" name="Endereco" placeholder="" required="required" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Numero:</label></br>
                                                <input type="number" value="<?php echo $log['numero'];?>" autocomplete="off" name="numero" required="required" readonly="readonly"/>
                                            </div>

                                            <div class="">
                                                <label>Cupom:</label></br>
                                                <input type="text" autocomplete="off" name="cupom" placeholder="" required="required"/>
                                            </div>

                                            <div class="">
                                                <label>Valor:</label></br>
                                                <input type="text" autocomplete="off" name="valor" placeholder="" required="required"/>
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