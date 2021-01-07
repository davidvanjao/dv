<?php

session_start();
require 'conexao.banco.php';

$valor = "";

if(isset($_GET['p']) && !empty($_GET['p'])) {

    $valor = $_GET['p'];
    if($valor == 'acougue'){ require 'acougue.painel.1.php';}
    if($valor == 'cesta-basica1'){ require 'cesta-basica.painel.1.php';}
    if($valor == 'cesta-basica2'){ require 'cesta-basica.painel.2.php';}
} else {

    require 'index2.php';

}