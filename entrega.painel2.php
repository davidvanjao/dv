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

if($usuarios->temPermissao('PES') == false) {
    header("Location:index.php");
    exit;
}


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
        <title>Tela de Cesta Basica</title>
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
                                <a href="sair.php">Fazer Logoff</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-cesta">
                                    <div class="campo-inserir">
                                        <form class="cesta-area" id="cesta-area" name="buscar-form" method="POST" action="entrega.adicionar.php">

                                            <div class="">
                                                <label>Data:</label></br>
                                                <input type="date" id="data" autocomplete="off" name="data" placeholder="" required="required">
                                            </div>

                                            <div class="">
                                                <label>Cep:</label></br>
                                                <input type="text" id="cep" autocomplete="off" name="cep" placeholder="" required="required" value="<?php echo $endereco['cep'];?>">
                                            </div>

                                            <div class="">
                                                <label>Cidade/Estado:</label></br>
                                                <input type="text" id="cidade" autocomplete="off" name="cidade" placeholder="" required="required" value="<?php echo $endereco['cidadeEstado'];?>"/>
                                            </div>

                                            <div class="">
                                                <label>Bairro:</label></br>
                                                <input type="text" autocomplete="off" name="bairro" placeholder="" required="required" value="<?php echo $endereco['bairro'];?>"/>
                                            </div>

                                            <div class="">
                                                <label>Longradouro:</label></br>
                                                <input type="text" autocomplete="off" name="logradouro" required="required" value="<?php echo $endereco['logradouro'];?>"/>
                                            </div>

                                            <div class="">
                                                <label>Valor:</label></br>
                                                <input type="text" autocomplete="off" name="valor" required="required" pattern="[0-9.,]{2,}"/>
                                            </div>

                                            <div class="">
                                                <label>Compras:</label></br>
                                                <input type="number" autocomplete="off" name="compra" placeholder="" required="required" value="1">
                                            </div>

                                            <div class="">
                                                <label>Numero de Caixas:</label></br>
                                                <input type="number" autocomplete="off" name="quantidade" placeholder="" required="required">
                                            </div>

                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
                                        </form>

                                        <form class="" id="" name="" method="POST" action="endereco.pesquisa.php">
                                            <input class="" type="submit" name="botao-endereco" value="Buscar Endereço">
                                        </form>

                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Data</th>
                                                <th style="width:10%;">Cidade</th>
                                                <th style="width:10%;">Endereço</th>
                                                <th style="width:10%;">Valor</th>
                                                <th style="width:10%;">Compra</th>
                                                <th style="width:10%;">Numero de Caixas</th>
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php
                                                $sql = "SELECT * FROM tb_entrega";
                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $entrega) {

                                                        echo "<tr>";
                                                        echo "<td style='width:10%;'>".$entrega['dataa']."</td>";
                                                        echo "<td style='width:10%;'>".$entrega['cidadeEstado']."</td>";
                                                        echo "<td style='width:10%;'>".$entrega['logradouro']."</td>";
                                                        echo "<td style='width:10%;'>".$entrega['valor']."</td>";  
                                                        echo "<td style='width:10%;'>".$entrega['compra']."</td>"; 
                                                        echo "<td style='width:10%;'>".$entrega['nCaixas']."</td>";                                  
                                                        echo '<td style="width:10%;"><a href="cesta-basica.excluir.php?id='.$entrega['id'].'">Excluir</a>';
                                                        echo "</tr>";  
                                                    }
                                                } else {
                                                        
                                                        echo "Nenhum produto encontrado.";
                                                    }
                                                ?>                                             

                                            </table>
                                        </div>
                                    </div>                                    
                                </div> 

                            </div> 
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            parent.document.getElementById("cesta-area").reset();
            parent.document.getElementById("data").value = '';
        </script>

    </body>


</html>