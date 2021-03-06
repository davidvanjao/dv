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

if($usuarios->temPermissao('DEL') == false) {
    header("Location:index.php");
    exit;
}

$orcamento = "";
$andamentoInicio = "";
$andamentoFim = "";
$quemFez = "";
$pdvInicio = "";
$pdvFim = "";
$quemConferiu = "";
$quemPassou = "";
$entregaInicio = "";
$entregaFim = "";
$quemEntregou = "";

if(isset($_GET['orcamento']) && !empty($_GET['orcamento'])) {
    $orcamento = addslashes($_GET['orcamento']);

    $sql = "SELECT *
            FROM 
            tb_horario_delivery
            WHERE 
            orcamento = '$orcamento'";

            $sql = $pdo->query($sql);   
            if($sql->rowCount() > 0) {
                foreach($sql->fetchAll() as $horario) {
                    
                    $andamentoInicio = $horario['andamentoInicio'];
                    $andamentoFim = $horario['andamentoFim'];
                    $quemFez = $horario['quemFez'];
                    $pdvInicio = $horario['pdvInicio'];
                    $pdvFim = $horario['pdvFim'];
                    $quemConferiu = $horario['quemConferiu'];
                    $quemPassou = $horario['quemPassou'];
                    $entregaInicio = $horario['entregaInicio'];
                    $entregaFim = $horario['entregaFim'];
                    $quemEntregou = $horario['quemEntregou'];
                
                }

            }
}

//=================================================================================================================

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Pesquisa</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/delivery.log.css">
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
                                <a href="delivery.painel.3.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">

                                    <h1>ORCAMENTO N° <?php echo $orcamento; ?><h1>
                                        
                                    </div>
                                    
                                    <div class="tabela-titulo">
                                        <table>

                                        </table> 
                                    </div>                                    
                                    <div class="busca-resultado"> 

                                        <div class="estrutura">
                                            <h4>PROCESSO DE COMPRA</h4>
                                            <form class="box-separacao" method="GET" action="delivery.processo.log.php">
                                                <input value="<?php echo $orcamento; ?>" type='hidden' name='orcamento'>

                                                <div class="controle">
                                                    <div>
                                                        <div class="horario">
                                                            <div class="horarioInicio">
                                                                <label>INICIO</label></br>
                                                                <input type="time" class="" value="<?php echo $andamentoInicio; ?>" name="andamentoInicio"/>   
                                                            </div>    
                                                            <div class="horarioFim">
                                                                <label>FIM</label></br>
                                                                <input type="time" class="" value="<?php echo $andamentoFim; ?>" name="andamentoFim"/>   
                                                            </div>  
                                                        </div>  
                                                        <div class="nome">
                                                            <label>NOME</label></br>
                                                            <input type="text" class="" value="<?php echo $quemFez; ?>" name="quemFez"/>   
                                                        </div> 
                                                    </div>                                                
                                                    <div class="botao-salvar">
                                                        <input value="SALVAR" type='submit' name=''>  
                                                    </div> 
                                                </div> 

                                            </form>                                        
                                        </div>

                                        <div class="estrutura">
                                            <h4>PROCESSO NO CAIXA </h4>
                                            <form method="GET" action="delivery.processo.log.php">
                                                <input value="<?php echo $orcamento; ?>" type='hidden' name='orcamento'>
                                                <div class="controle">
                                                    <div>
                                                        <div class="horario">
                                                            <div class="horarioInicio">
                                                                <label>INICIO</label></br>
                                                                <input type="time" class="" value="<?php echo $pdvInicio; ?>" name="pdvInicio"/>   
                                                            </div>    
                                                            <div class="horarioFim">
                                                                <label>FIM</label></br>
                                                                <input type="time" class="" value="<?php echo $pdvFim; ?>" name="pdvFim"/>   
                                                            </div>  
                                                        </div>  
                                                        <div class="nome">
                                                            <label>NOME</label></br>
                                                            <input type="text" class="" value="<?php echo $quemConferiu; ?>" name="quemConferiu" placeholder="CONFERENTE"/>   
                                                            <input type="text" class="" value="<?php echo $quemPassou; ?>" name="quemPassou" placeholder="OPERADOR"/>   
                                                        </div>  
                                                    </div>
                                                    <div class="botao-salvar">
                                                        <input value="SALVAR" type='submit' name=''>  
                                                    </div> 
                                                </div>                               
                                            </form>                                        
                                        </div>

                                        <div class="estrutura">
                                            <h4>PROCESSO DE ENTREGA</h4>
                                            <form method="GET" action="delivery.processo.log.php">
                                                <input value="<?php echo $orcamento; ?>" type='hidden' name='orcamento'>

                                                <div class="controle">
                                                    <div>
                                                        <div class="horario">
                                                            <div class="horarioInicio">
                                                                <label>INICIO</label></br>
                                                                <input type="time" class="" value="<?php echo $entregaInicio; ?>" name="entregaInicio"/>   
                                                            </div>    
                                                            <div class="horarioFim">
                                                                <label>FIM</label></br>
                                                                <input type="time" class="" value="<?php echo $entregaFim; ?>" name="entregaFim"/>   
                                                            </div>  
                                                        </div>  
                                                        <div class="nome">
                                                            <label>NOME</label></br>
                                                            <input type="text" class="" value="<?php echo $quemEntregou; ?>" name="quemEntregou"/>   
                                                        </div> 
                                                    </div>
                                                    <div class="botao-salvar">
                                                        <input value="SALVAR" type='submit' name=''>  
                                                    </div>  
                                                </div>                                     
                                            </form>                                        
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