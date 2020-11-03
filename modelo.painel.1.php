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





$sql = "SELECT MAX(id) FROM tb_log_delivery";
$sql = $pdo->query($sql);

if($sql->rowCount() > 0) {

    $orcamento = $sql->fetch();

    $orcamento = $orcamento[0];
    $orcamento = $orcamento + '1';    

    $_SESSION['orcamento'] = $orcamento;

}


var_dump($orcamento);
var_dump($_SESSION);
//session_destroy();


if(isset($_GET['adicionar'])) {

$idProduto = (int)$_GET['adicionar'];

$sql = "SELECT * FROM tb_produto WHERE id = $idProduto";    
$sql = $pdo->query($sql);                                    

if($sql->rowCount() > 0) {
    foreach($sql as $key => $value) {

           
    }


    if(isset($value['id']) == $idProduto) {
        if(isset($_SESSION['orcamento'][$idProduto])){
            $_SESSION['orcamento'][$idProduto]['quantidade']++;
        }else{
            $_SESSION['orcamento'][$idProduto] = array('quantidade'=>1, 'produto'=>$value['d_produto'], 'preco'=>$value['preco'], 'estoque'=>$value['estoque'], 'codigo'=>$value['c_produto'], 'id'=>$value['id']);
        }
        //echo '<script>alert("O item foi adicionado ao carrinho.");</script>';
    }else{
        die('voce nao pode adicionar um item que nao existe.');
    }

    
} 

}


 var_dump($_SESSION);


?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Pesquisa</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/pesquisa.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">
        

                            
                        </div>
                    </div>
                </div>

                <div class="conteudo-Central">
                    <div class="corpo">
                        <header class="desktop_header">
                            <div class="logo">
                                <img src="">
                            </div>
                            <div class="superiorMenu">
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-busca">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST" action="modelo.painel.pesquisa.php">
                                            <input class="input-botao" type="submit" name="botao-pesquisar" value="Adicionar">
                                        </form>
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Código</th>
                                                <th style="width:50%;">Produto</th>
                                                <th style="width:10%;">Quantidade</th>
                                                <th style="width:10%;">Preço</th>
                                                <th style="width:10%;">Estoque</th>
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php                                 

                                                foreach($_SESSION['orcamento'] as $key=>$value) {
                                                    echo "<tr>";
                                                    echo "<td style='width:10%;'>".$value['codigo']."</td>";
                                                    echo "<td style='width:50%;'>".$value['produto']."</td>";
                                                    echo "<td style='width:10%;'>".$value['quantidade']."</td>";
                                                    echo "<td style='width:10%;'>".$value['preco']."</td>";
                                                    echo "<td style='width:10%;'>".$value['estoque']."</td>";                                                    
                                                    echo '<td style="width:10%;"><a href="?adicionar='.$value['id'].'">Excluir</a>';
                                                    echo "</tr>";  

                                                    //print_r($value);
                                                    //var_dump($value); 
                                                    //echo $value['id'];    
                                                }        
                                                
                                                //session_destroy();

                                                
                                            ?>                                        
                                        </table>
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