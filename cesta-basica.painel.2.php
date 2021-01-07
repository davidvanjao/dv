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

if($usuarios->temPermissao('CES') == false) {
    header("Location:index.php");
    exit;
}

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

                    </div>
                </div>

                <div class="conteudo-Central">
                    <div class="corpo">
                        <header class="desktop_header">
                            <div class="logo">
                                <img src="">
                            </div>
                            <div class="superiorMenu">
                                <a href="index.php?p=cesta-basica1">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-conteudo">
                                    <div class="campo-inserir">
                                        <form class="form-cesta-2" method="POST" action="cesta-basica.processo.php">

                                            <div class="">
                                                <label>Data:</label></br>
                                                <input type="date" value="<?php echo date('Y-m-d');?>" name="data" required="required">
                                            </div>

                                            <div class="">
                                                <label>Responsável:</label></br>
                                                <select required="required" name="responsavel">
                                                    <option value="Equipe">Equipe</option>
                                                </select>
                                            </div>

                                            <div class="">
                                                <label>Quantidade:</label></br>
                                                <input type="number" min='1' step="1" autocomplete="off" name="quantidade" placeholder="" required="required">
                                            </div>

                                            <div class="">
                                                <label>Valor:</label></br>
                                                <input type="text" autocomplete="off" name="valor" required="required" pattern="[0-9.,]{2,}"/>
                                            </div>

                                            <div class="">
                                                <label>Tipo de Cesta:</label></br>
                                                <select required="required" name="tipocesta">
                                                    <option value=""></option>
                                                    <option value="Personalizada">Personalizada</option>
                                                    <option value="Venda 1">Venda 1</option>
                                                    <option value="Venda 2">Venda 2</option>
                                                    <option value="Venda 3">Venda 3</option>
                                                </select>
                                            </div>

                                            <div class="">
                                                <label>Tipo de Pessoa:</label></br>
                                                <select required="required" name="tipopessoa">
                                                    <option value=""></option>
                                                    <option value="Fisica">Física</option>
                                                    <option value="Juridica">Jurídica</option>
                                                </select>
                                            </div>

                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
                                        </form>
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