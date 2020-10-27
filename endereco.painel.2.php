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

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Catalogo de Endereço</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/cesta-basica.css">
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
                                <a href="endereco.painel.php">Voltar</a>
                            </div>
                        </header>
                        <section class="page">
                            <div class="conteudo-Geral">

                                <div class="body-cesta">
                                    <div class="campo-inserir">
                                        <form class="cesta-area" id="cesta-area" name="buscar-form" method="POST" action="endereco.processo.adicionar.php">

                                            <div class="">
                                                <label>Cep:</label></br>
                                                <input type="number" min='0' autocomplete="off" name="cep" placeholder="00000-000" required pattern="\d{5}-\d{3}">
                                            </div>

                                            <div class="">
                                                <label>Cidade/Estado:</label></br>
                                                <input type="text" autocomplete="off" name="cidade" placeholder="Cidade/Estado" required="required">
                                            </div>

                                            <div class="">
                                                <label>Bairro:</label></br>
                                                <input type="text" autocomplete="off" name="bairro" placeholder="" required="required">
                                            </div>

                                            <div class="">
                                                <label>Longradouro:</label></br>
                                                <input type="text" autocomplete="off" name="logradouro" required="required"/>
                                            </div>

                                            <div class="">
                                                <label>Complemento:</label></br>
                                                <input type="text" autocomplete="off" name="complemento"/>
                                            </div>

                                            <div class="">
                                                <label>Região:</label></br>
                                                <input type="text" autocomplete="off" name="regiao"/>
                                            </div>

                                            <input class="input-botao" type="submit" name="botao-adicionar" value="Adicionar">
                                        </form>
                                    </div>

                                    <div class="tabela-titulo">

                                    </div>

                                    <div class="campo-listar">                
                                        <div class="tabela-lancamentos">

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