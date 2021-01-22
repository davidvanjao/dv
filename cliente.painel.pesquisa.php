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

if($usuarios->temPermissao('CLI') == false) {
    header("Location:index.php");
    exit;
}

//=================================================================================================================


$tipoBusca = "nome";

if(isset($_POST['pesquisa'])) {

    $tipoBusca = $_POST['tipobusca'];

}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Pesquisa</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/cadastroCliente.css">
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

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <form class="busca-area" name="buscar-form" method="POST">

                                            <select class="input-tipoBusca" required="required" name="tipobusca">
                                                <option value="nome" <?php echo ($tipoBusca=="nome")?'selected="selected"':'';?>>Nome</option>
                                                <option value="cpf" <?php echo ($tipoBusca=="cpf")?'selected="selected"':'';?>>CPF/CNPJ</option>
                                            </select>
                                            
                                            <input class="input-busca-produto" id="pesquisaProduto" minlength="3" type="text" autocomplete="off" name="pesquisa" placeholder="Digite sua busca">
                                            <input class="input-botao" type="submit" name="pesquisa-produto" value="Pesquisar">
                                        </form>                                     
                                    </div>
                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:5%;">CÓDIGO</th>
                                                <th style="width:20%;">CLIENTE</th>
                                                <th style="width:2%;">PESSOA</th>
                                                <th style="width:5%;">CPF/CNPJ</th>
                                                <th style="width:2%;">STATUS</th>
                                                <th style="width:5%;">TELEFONE</th>
                                            </tr>
                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado" id="resultado"> 

                                    

                                    <table>
                                        <?php                                        
                                        
                                            if(isset($_POST['pesquisa']) && !empty($_POST['pesquisa'])) { //se existir e ele nao estiver vazio.

                                                $pesquisa = addslashes($_POST['pesquisa']);
                                                $pesquisa = strtoupper($pesquisa);                                               


                                                if($_POST['tipobusca'] == 'nome') { //se existir e ele nao estiver vazio.

                                                    $consulta = "SELECT a.seqpessoa, a.nomerazao, a.fisicajuridica, a.nrocgccpf, a.digcgccpf, a.status, a.foneddd1, a.fonenro1
                                                    FROM 
                                                    CONSINCO.GE_PESSOA a
                                                    WHERE
                                                    a.nomerazao LIKE '%".$pesquisa."%'
                                                    ORDER BY a.nomerazao";

                                                } else {

                                                    $consulta = "SELECT a.seqpessoa, a.nomerazao, a.fisicajuridica, a.nrocgccpf, a.digcgccpf, a.status, a.foneddd1, a.fonenro1
                                                    FROM 
                                                    CONSINCO.GE_PESSOA a
                                                    WHERE
                                                    a.nrocgccpf LIKE '$pesquisa'
                                                    ORDER BY a.nomerazao";


                                                }
                                                
                                                //prepara uma instrucao para execulsao
                                                $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

                                                //Executa os comandos SQL
                                                oci_execute($resultado);

                                                while (($cliente = oci_fetch_array($resultado, OCI_ASSOC)) != false) {

                                                echo "<tr onclick=location.href='cliente.painel.resultado.php?cliente=".@$cliente['SEQPESSOA']."' style='cursor:pointer'>";
                                                echo "<td style='width:5%;'>".@$cliente['SEQPESSOA']."</td>";
                                                echo "<td style='width:20%;'>".@$cliente['NOMERAZAO']."</td>";
                                                
                                                if(@$cliente['FISICAJURIDICA'] == 'F') {
                                                    echo "<td style='width:2%;'>FISÍCA</td>";
                                                } else {
                                                    echo "<td style='width:2%;'>JURÍDICA</td>";
                                                }
                                                echo "<td style='width:5%;'>".@$cliente['NROCGCCPF'].'-'.@$cliente['DIGCGCCPF']."</td>"; 

                                                if(@$cliente['STATUS'] == 'A') {
                                                    echo "<td style='width:2%;'>ATIVO</td>";
                                                } else {
                                                    echo "<td style='width:2%;'>INATIVO</td>";
                                                }   

                                                if(empty(@$cliente['FONEDDD1']) && !empty($cliente['FONENRO1'])) {

                                                    echo "<td style='width:5%;'>".$cliente['FONENRO1']."</td>";  
                                                    
                                                } elseif(empty(@$cliente['FONENRO1']) && !empty($cliente['FONEDDD1'])) {

                                                    echo "<td style='width:5%;'>".@$cliente['FONEDDD1']."</td>";     
                                                    
                                                } elseif(!empty(@$cliente['FONENRO1']) && !empty($cliente['FONEDDD1'])){

                                                    echo "<td style='width:5%;'>".@$cliente['FONEDDD1'].'-'.$cliente['FONENRO1']."</td>";   

                                                } else {

                                                    echo "<td style='width:5%;'></td>";  

                                                }
                                                
                                                
                                                                           
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