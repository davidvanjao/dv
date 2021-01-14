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

$tipoBusca = "produto";

if(isset($_POST['pesquisa'])) {

    $tipoBusca = $_POST['tipobusca'];

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
        
                        <?php require 'menuLateral.php'; ?>
                            
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
                                <a href="sair.php">Sair</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-busca">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST">

                                            <select class="input-tipoBusca" required="required" name="tipobusca">
                                                <option value="produto" <?php echo ($tipoBusca=="produto")?'selected="selected"':'';?>>Produto</option>
                                                <option value="codigo" <?php echo ($tipoBusca=="codigo")?'selected="selected"':'';?>>Código</option>
                                            </select>
                                            
                                            <input class="input-busca-produto" id="pesquisaProduto" minlength="3" type="text" autocomplete="off" name="pesquisa" placeholder="Digite sua busca">
                                            <input class="input-botao" type="submit" name="pesquisa-produto" value="Pesquisar">
                                        </form>                                     
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:5%;">EAN/BALANÇA  </th>
                                                <th style="width:5%;">CÓDIGO</th>
                                                <th style="width:20%;">PRODUTO</th>
                                                <th style="width:5%;">EMBALAGEM</th>
                                                <th style="width:5%;">PREÇO</th>
                                                <th style="width:5%;">ESTOQUE</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado" id="resultado"> 

                                    

                                    <table>
                                        <?php                                        
                                        
                                            if(isset($_POST['pesquisa']) && !empty($_POST['pesquisa'])) { //se existir e ele nao estiver vazio.

                                                $pesquisa = addslashes($_POST['pesquisa']);
                                                $pesquisa = strtoupper($pesquisa);

                                                if($_POST['tipobusca'] == 'produto') { //se existir e ele nao estiver vazio.


                                                    $consulta = "SELECT  d.codacesso, a.seqproduto, b.desccompleta, a.estqloja,
                                                    consinco.fprecoembnormal(a.seqproduto, 1, e.nrosegmentoprinc, a.nroempresa) preco,
                                                    consinco.fprecoembpromoc(a.seqproduto, 1, e.nrosegmentoprinc, a.nroempresa) precoprom,
                                                    a.estqloja
                                                    FROM
                                                    consinco.mrl_produtoempresa a, 
                                                    consinco.map_produto b, 
                                                    consinco.map_prodcodigo d,
                                                    consinco.max_empresa e
                                                    WHERE
                                                    a.nroempresa = '1'
                                                    AND e.nroempresa = '1'
                                                    AND a.seqproduto = b.seqproduto
                                                    AND a.seqproduto = d.seqproduto
                                                    AND d.tipcodigo IN ('E', 'B')
                                                    AND a.statuscompra = 'A'
                                                    AND b.desccompleta LIKE '%".$pesquisa."%'
                                                    ORDER BY b.desccompleta";

                                                } else {

                                                    $consulta = "SELECT  d.codacesso, a.seqproduto, b.desccompleta, a.estqloja,
                                                    consinco.fprecoembnormal(a.seqproduto, 1, e.nrosegmentoprinc, a.nroempresa) preco,
                                                    consinco.fprecoembpromoc(a.seqproduto, 1, e.nrosegmentoprinc, a.nroempresa) precoprom,
                                                    a.estqloja
                                                    FROM
                                                    consinco.mrl_produtoempresa a, 
                                                    consinco.map_produto b, 
                                                    consinco.map_prodcodigo d,
                                                    consinco.max_empresa e
                                                    WHERE
                                                    a.nroempresa = '1'
                                                    AND e.nroempresa = '1'
                                                    AND a.seqproduto = b.seqproduto
                                                    AND a.seqproduto = d.seqproduto
                                                    AND d.tipcodigo IN ('E', 'B')
                                                    AND a.statuscompra = 'A'
                                                    AND d.codacesso = '$pesquisa'
                                                    ORDER BY b.desccompleta";

                                                }
                                                
                                                //prepara uma instrucao para execulsao
                                                $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                                //Executa os comandos SQL
                                                oci_execute($resultado);

                                                while (($produto = oci_fetch_array($resultado, OCI_ASSOC)) != false) {                                                    

                                                    echo "<tr>";
                                                    echo "<td style='width:5%;'>".$produto['CODACESSO']."</td>";
                                                    echo "<td style='width:5%;'>".$produto['SEQPRODUTO']."</td>";
                                                    echo "<td style='width:20%;'>".$produto['DESCCOMPLETA']."</td>";  

                                                    echo "<td style='width:5%;'>";
                                                        echo "<select name='tipocesta' style='width:50%; background-color:transparent; border:none;'>";

                                                            if($produto['SEQPRODUTO']) { //se existir e ele nao estiver vazio.
                                                                $codigo = $produto['SEQPRODUTO'];                                                        

                                                                $consulta2 = "SELECT a.seqproduto, a.seqfamilia, b.qtdembalagem, b.embalagem
                                                                FROM
                                                                consinco.map_produto a, 
                                                                consinco.map_famembalagem b
                                                                WHERE
                                                                a.seqfamilia = b.seqfamilia
                                                                AND a.seqproduto = '$codigo'
                                                                ORDER BY b.qtdembalagem";

                                                                //prepara uma instrucao para execulsao
                                                                $resultado2 = oci_parse($ora_conexao, $consulta2) or die ("erro");

                                                                //Executa os comandos SQL
                                                                oci_execute($resultado2);

                                                                while (($quantidade = oci_fetch_array($resultado2, OCI_ASSOC)) != false) { 

                                                                    echo "<option>".$quantidade['QTDEMBALAGEM']." ".$quantidade['EMBALAGEM']."</option>";

                                                                } 
                                                            }
                                                        echo "</select>";
                                                    echo "</td>";  


                                                if($produto['PRECOPROM'] > '0') {                                                    
                                                echo "<td style='width:5%; background-color:#ffff00; font-weight:bold;'>R$ ".number_format($produto['PRECOPROM'],2,",",".")."</td>";
                                                } else {                                                    
                                                echo "<td style='width:5%;'>R$ ".number_format($produto['PRECO'],2,",",".")."</td>";
                                                }
                                                echo "<td style='width:5%;'>".number_format($produto['ESTQLOJA'],3,".",".")."</td>";                                    
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