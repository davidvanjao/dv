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

}


//echo $orcamento;
//var_dump($_SESSION);
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


 //var_dump($_SESSION);


?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Pesquisa</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/modelo.css">
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
                                <a href="modelo.painel.1.php">Voltar</a>
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-busca">
                                    <div class="campo-inserir">

                                        <div class="formulario-cliente">                                   
                                            <form class="busca-area" name="buscar-form" method="POST" action="cliente.processo.adicionar.php">
                                                <div>
                                                    <label>Nome:</label></br>
                                                    <input class="input1" type="text" autocomplete="off" name="nome" placeholder="" required="required" value=""/>    
                                                </div>                                        

                                                <div>
                                                    <label>Telefone:</label></br>
                                                    <input class="input2" type="text" autocomplete="off" name="telefone" placeholder="" required="required" value=""/>   
                                                </div>                                              

                                                <div>
                                                    <label>Cidade/Estado:</label></br>
                                                    <input class="input3" type="text" autocomplete="off" name="cidade" placeholder="" required="required" value="" readonly="readonly"/>  
                                                </div> 

                                                <div>
                                                    <label>Longradouro:</label></br>
                                                    <input class="input4" type="text" autocomplete="off" name="logradouro" required="required" value="" readonly="readonly"/>    
                                                </div>                                         

                                                <div>
                                                    <label>Numero:</label></br>
                                                    <input class="input5" type="number" min='0' autocomplete="off" name="numero" required="required" value=""/>
                                                </div> 
                                            
                                                
                                                    <input class="input-botao" type="submit" name="botao-adicionar" value="Buscar"/>                                            

                                            </form>
                                        </div>

                                        <div class="formulario-documento">         

                                            <form class="busca-area" name="buscar-form" method="POST" action="">
                                                <div>
                                                    <label>N. Orcamento</label></br>
                                                    <input minlength="3" type="text" autocomplete="off" name="pesquisa" placeholder="buscar produto" value="<?php echo $orcamento ?>">
                                                </div> 

                                                <input type="submit" name="botao-pesquisar" value="Salvar">
                                            </form>

                                            <form class="busca-area" name="buscar-form" method="POST" action="">
                                                <input type="submit" name="botao-pesquisar" value="Limpar">
                                            </form>

                                        </div>

                                        <div class="formulario-busca">         
                                            
                                             <form class="busca-area" name="buscar-form" method="POST">
                                            
                                                <input id ="busca" minlength="3" type="text" autocomplete="off" name="pesquisa" placeholder="buscar produto">

                                                <!--<input type="submit" name="botao-pesquisar" value="Pesquisar">-->
                                            </form>

                                        </div>

                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Codigo</th>
                                                <th style="width:50%;">Produto</th>
                                                <th style="width:10%;">Quantidade</th>
                                                <th style="width:10%;">Preco</th>
                                                <th style="width:10%;">Estoque</th>
                                                <th style="width:10%;">Acoes</th>
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
                                                    echo '<td style="width:10%;"><a href="modelo.painel.excluir.php?excluir='.$value['id'].'">Excluir</a>';
                                                    echo "</tr>";  
  
                                                }        
                                                
                                                
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

        <script type="text/javascript" src="jquery.min.js"></script>
        <script type="text/javascript" src="script2.js"></script>

    </body>


</html>