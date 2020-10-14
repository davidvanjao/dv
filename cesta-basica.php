<?php

session_start();
require 'conexao.php';
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

if(isset($_POST['data']) && empty($_POST['data']) == false) {
	$data = $_POST['data'];
    $responsavel = $_POST['responsavel'];
    $quantidade = $_POST['quantidade'];
    $valor = str_replace(",",".",$_POST['valor']);
    $tipoCesta = $_POST['tipoCesta'];
	$tipoPessoa = $_POST['tipoPessoa'];

	$sql = $pdo->prepare("INSERT INTO tb_cestabasica SET dataa = :dataa, responsavel = :responsavel, quantidade = :quantidade, valor = :valor, tipoCesta = :tipoCesta, tipoPessoa = :tipoPessoa");
	$sql->bindValue(":dataa", $data);
    $sql->bindValue(":responsavel", $responsavel);
    $sql->bindValue(":quantidade", $quantidade);
    $sql->bindValue(":valor", $valor);
    $sql->bindValue(":tipoCesta", $tipoCesta);
	$sql->bindValue(":tipoPessoa", $tipoPessoa);
    $sql->execute();
	
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
                <div class="menu-lateral">
                    <div class="painel-menu">
                        <div class="painel-menu-menu">
        
                            <?php if($usuarios->temPermissao('PES')): ?>
                                <div class="painel-menu-widget">
                                    <a href="pesquisa.php">
                                        <img src="assets/img/lupa2.svg">
                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>        
        
                            <?php if($usuarios->temPermissao('CONF')): ?>
                                <div class="painel-menu-widget">
                                    <a href="configuracao.php">
                                        <img src="assets/img/engrenagem2.svg">
                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>

                            <?php if($usuarios->temPermissao('PES')): ?>
                                <div class="painel-menu-widget">
                                    <a href="cesta-basica.php">
                                        <img src="assets/img/lupa2.svg">
                                        
                                    </a>                        
                                </div>
                            <?php endif; ?>            
                            
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
                                <a href="sair.php">Fazer Logoff</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-cesta">
                                    <div class="campo-inserir">
                                        <form class="cesta-area" id="cesta-area" name="buscar-form" method="POST">

                                            <div class="">
                                                <label>Data:</label></br>
                                                <input type="date" id="data" autocomplete="off" name="data" placeholder="" required="required">
                                            </div>

                                            <div class="">
                                                <label>Responsavel:</label></br>
                                                <select required="required" name="responsavel">
                                                    <option value="Equipe">Equipe</option>
                                                    <option value=""></option>
                                                </select>
                                            </div>

                                            <div class="">
                                                <label>Quantidade:</label></br>
                                                <input type="number" autocomplete="off" name="quantidade" placeholder="" required="required">
                                            </div>

                                            <div class="">
                                                <label>Valor:</label></br>
                                                <input type="text" autocomplete="off" name="valor" required="required" pattern="[0-9.,]{2,}"/>
                                            </div>

                                            <div class="">
                                                <label>Tipo de Cesta:</label></br>
                                                <select required="required" name="tipoCesta">
                                                    <option value=""></option>
                                                    <option value="Personalizada">Personalizada</option>
                                                    <option value="Venda 1">Venda 1</option>
                                                    <option value="Venda 2">Venda 2</option>
                                                    <option value="Venda 3">Venda 3</option>
                                                </select>
                                            </div>

                                            <div class="">
                                                <label>Tipo de Pessoa:</label></br>
                                                <select required="required" name="tipoPessoa">
                                                    <option value=""></option>
                                                    <option value="Fisica">Física</option>
                                                    <option value="Juridica">Jurídica</option>
                                                </select>
                                            </div>

                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
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
                                                $sql = "SELECT * FROM tb_cestabasica";
                                                $sql = $pdo->query($sql);   
                                                if($sql->rowCount() > 0) {
                                                    foreach($sql->fetchAll() as $cesta) {

                                                        echo "<tr>";
                                                        echo "<td style='width:10%;'>".$cesta['dataa']."</td>";
                                                        echo "<td style='width:10%;'>".$cesta['responsavel']."</td>";
                                                        echo "<td style='width:10%;'>".$cesta['quantidade']."</td>";
                                                        echo "<td style='width:10%;'>R$ ".$cesta['valor']."</td>";
                                                        echo "<td style='width:10%;'>".$cesta['tipoCesta']."</td>";
                                                        echo "<td style='width:10%;'>".$cesta['tipoPessoa']."</td>";                                   
                                                        echo '<td style="width:10%;"><a href="cesta-basica.excluir.php?id='.$cesta['id'].'">Excluir</a>';
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