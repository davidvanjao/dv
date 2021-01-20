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

if($usuarios->temPermissao('ORC') == false) {
    header("Location:index.php");
    exit;
}

$usuario = $_SESSION['logado'];

//=================================================================================================================

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Orçamento</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/delivery.css">
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
                                <a href="index.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST" action="orcamento.processo.php">
                                            <input class="input-botao" type="submit" name="adicionarOrcamento" value="Criar Orçamento">
                                        </form>
                                    </div>
                                    
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">ORCAMENTO</th>
                                                <th style="width:10%;">DATA</th>
                                                <th style="width:10%;">NOME</th>
                                                <th style="width:10%;">AÇÕES</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 
                                        <table>
                                            <?php                                 

                                            $sql = "SELECT a.id, a.orcamento, a.idCliente, DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
                                            FROM 
                                            tb_log_delivery a
                                            WHERE 
                                            a.tipo = 'O'
                                            and a.usuario = '$usuario'
                                            ORDER BY a.orcamento";

                                            $sql = $pdo->query($sql);   
                                            if($sql->rowCount() > 0) {
                                                foreach($sql->fetchAll() as $orcamento) {

                                                    $codCliente = $orcamento['idCliente'];

                                                    echo "<tr>";
                                                    echo "<td style='width:10%;'><strong>".str_pad($orcamento['orcamento'], 4, 0, STR_PAD_LEFT)."</strong></td>";
                                                    echo "<td style='width:10%;'>".$orcamento['saida_data']."</td>";

                                                    $consulta = "SELECT a.seqpessoa, a.nomerazao
                                                    FROM 
                                                    CONSINCO.GE_PESSOA a
                                                    WHERE
                                                    a.seqpessoa = '$codCliente'";

                                                     //prepara uma instrucao para execulsao
                                                    $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                                    //Executa os comandos SQL
                                                    oci_execute($resultado);

                                                    while (($cliente = oci_fetch_array($resultado, OCI_ASSOC)) != false) {

                                                        echo "<td style='width:10%;'>".$cliente['NOMERAZAO']."</td>";

                                                    }
                                                    echo '<td style="width:5%;"><a href="orcamento.impressao.php?orcamento='.$orcamento['orcamento'].'&cliente='.$orcamento['idCliente'].'" target="_blank">Imprimir</a></td>';   
                                                    echo '<td style="width:5%;"><a href="orcamento.editar.php?orcamento='.$orcamento['orcamento'].'">Editar</a></td>';           
                                                    echo "</tr>";  

                                                
                                                }
                                            } else {   

                                                echo "NÃO EXISTE NENHUM ORÇAMENTO.";
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