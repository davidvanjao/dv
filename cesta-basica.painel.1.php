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

$data = date('Y-m-d');

$data0 = date('Y-m-d', strtotime('0 days', strtotime(date('Y-m-d'))));
$data7 = date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));
$data15 = date('Y-m-d', strtotime('-15 days', strtotime(date('Y-m-d'))));
$data30 = date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))));

if(isset($_GET['filtroData']) && empty($_GET['filtroData']) == false) {

    $data = addslashes($_GET['filtroData']);
    
};

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Tela de Cesta Basica</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/cestaBasica.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="__nex">
            <div class="main_styled">
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">
            
                        <?php require 'menuLateral.php'; ?>
            
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

                                        <form name="form-adicionar" method="POST" action="cesta-basica.painel.2.php">
                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
                                        </form>

                                        <form method="GET">

                                            <select class="input-botao" required="required" name="filtroData"  onchange="this.form.submit()">
                                                <option value="<?php echo $data0;?>" <?php echo ($data0==$data)?'selected="selected"':'';?>>Hoje</option>
                                                <option value="<?php echo $data7;?>" <?php echo ($data==$data7)?'selected="selected"':'';?>>Últimos 7 dias</option>
                                                <option value="<?php echo $data15;?>" <?php echo ($data==$data15)?'selected="selected"':'';?>>Últimos 15 dias</option>
                                                <option value="<?php echo $data30;?>" <?php echo ($data==$data30)?'selected="selected"':'';?>>Últimos 30 dias</option>
                                            </select>
                                            
                                        </form>
                                        
                                    </div>

                                    <div class="tabela-titulo">
                                        <table>
                                            <tr>
                                                <th style="width:10%;">Data</th>
                                                <th style="width:10%;">Responsável</th>
                                                <th style="width:10%;">Quantidade</th>
                                                <th style="width:10%;">Valor</th>
                                                <th style="width:10%;">Tipo Cesta</th>
                                                <th style="width:10%;">Tipo Pessoa</th>
                                                <th style="width:10%;">Ações</th>
                                            </tr>
                                        </table> 
                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">
                                            <table>
                                                <?php
                                                $sql = "SELECT *, DATE_FORMAT(dataa,'%d/%m/%Y') as saida_data FROM tb_cestabasica WHERE dataa >= '$data'";
                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $cesta) {

                                                        echo "<tr>";
                                                        echo "<td style='width:10%;'>".$cesta['saida_data']."</td>";
                                                        echo "<td style='width:10%;'>".$cesta['responsavel']."</td>";
                                                        echo "<td style='width:10%;'>".$cesta['quantidade']."</td>";
                                                        echo "<td style='width:10%;'>R$ ".$cesta['valor']."</td>";
                                                        echo "<td style='width:10%;'>".$cesta['tipoCesta']."</td>";
                                                        echo "<td style='width:10%;'>".$cesta['tipoPessoa']."</td>";                                   
                                                        echo '<td style="width:10%;"><a href="cesta-basica.processo.php?id='.$cesta['id'].'">Excluir</a>';
                                                        echo "</tr>";  
                                                    }
                                                } else {
                                                        
                                                        echo "Nenhum lançamento encontrado.";
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
    </body>


</html>