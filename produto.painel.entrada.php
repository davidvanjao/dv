<?php

session_start();
require 'conexao.banco.php';
require 'conexao.banco.oracle.php';
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

//====================================================================================================

if(isset($_GET['codigo']) && !empty($_GET['codigo'])) { //se existir e ele nao estiver vazio.

    $codigo = addslashes($_GET['codigo']);                                        

    $consulta = "SELECT  a.seqproduto, a.desccompleta
    FROM
    consinco.map_produto a 
    WHERE
    a.seqproduto = '$codigo'";                                      
    
    //prepara uma instrucao para execulsao
    $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

    //Executa os comandos SQL
    oci_execute($resultado);

    while (($produto = oci_fetch_array($resultado, OCI_ASSOC)) != false) {
        $descProduto = $produto['DESCCOMPLETA'];

    }

}

//var_dump($_POST);
//var_dump($tipoBusca);
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
        
                        <div class="painel-menu-menu">
        
                            
                        </div>
                            
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
                                <a href="produto.painel.pesquisa.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <h1>PRODUTO: <?php echo $descProduto ?><h1>
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:5%;">CÓDIGO</th>
                                                <th style="width:5%;">CGO</th>
                                                <th style="width:5%;">QUANTIDADE</th>
                                                <th style="width:5%;">DATA ENTRADA</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado" id="resultado"> 

                                    

                                    <table>
                                        <?php                                        
                                        
                                            if(isset($_GET['codigo']) && !empty($_GET['codigo'])) { //se existir e ele nao estiver vazio.

                                                $codigo = addslashes($_GET['codigo']);

                                                $consulta = "SELECT *
                                                FROM 
                                                (SELECT seqproduto, codgeraloper, qtdlancto, TO_CHAR(dtaentradasaida, 'DD/MM/YYYY') AS data_entrada FROM consinco.mrl_lanctoestoque WHERE seqproduto = '$codigo' AND codgeraloper IN ('111', '300') ORDER BY dtaentradasaida DESC) 
                                                WHERE rownum <= 5";
                                                
                                                
                                                //prepara uma instrucao para execulsao
                                                $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                                //Executa os comandos SQL
                                                oci_execute($resultado);

                                                while (($entrada = oci_fetch_array($resultado, OCI_ASSOC)) != false) {                                                    

                                                    echo "<tr>";
                                                    echo "<td style='width:5%;'>".$entrada['SEQPRODUTO']."</td>";
                                                    echo "<td style='width:5%;'>".$entrada['CODGERALOPER']."</td>";
                                                    echo "<td style='width:5%;'>".$entrada['QTDLANCTO']."</td>";  
                                                    echo "<td style='width:5%;'>".$entrada['DATA_ENTRADA']."</td>"; 
                                                    echo "</tr>"; 
                                                }

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
    </body>


</html>