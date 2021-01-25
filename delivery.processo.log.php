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


//================================VARIAVEIS=========================================================================


//================================ATUALIZAR HORARIOS================================================================

if(isset($_GET['andamentoInicio']) && !empty($_GET['andamentoInicio'])) {

    $orcamento = $_GET['orcamento'];
    $inicio = $_GET['andamentoInicio'];
    $fim = $_GET['andamentoFim'];
    $quemFez = strtoupper($_GET['quemFez']);

    $sql = $pdo->prepare("UPDATE tb_horario_delivery SET andamentoInicio = :inicio, andamentoFim = :fim, quemFez = :quemFez WHERE orcamento = $orcamento");
    $sql->bindValue(":inicio", $inicio);
    $sql->bindValue(":fim", $fim);
    $sql->bindValue(":quemFez", $quemFez);
    $sql->execute(); 
 
    header("Location:/delivery.processo.php?andamento=$orcamento"); 
    exit;

}

if(isset($_GET['pdvInicio']) && !empty($_GET['pdvInicio'])) {

    $orcamento = $_GET['orcamento'];
    $inicio = $_GET['pdvInicio'];
    $fim = $_GET['pdvFim'];
    $quemConferiu = strtoupper($_GET['quemConferiu']);
    $quemPassou = strtoupper($_GET['quemPassou']);

    $sql = $pdo->prepare("UPDATE tb_horario_delivery SET pdvInicio = :inicio, pdvFim = :fim, quemConferiu = :quemConferiu, quemPassou = :quemPassou WHERE orcamento = $orcamento");
    $sql->bindValue(":inicio", $inicio);
    $sql->bindValue(":fim", $fim);
    $sql->bindValue(":quemConferiu", $quemConferiu);
    $sql->bindValue(":quemPassou", $quemPassou);
    $sql->execute(); 
 
    header("Location:/delivery.processo.php?liberado=$orcamento"); 
    exit;

}

if(isset($_GET['entregaInicio']) && !empty($_GET['entregaInicio'])) {

    $orcamento = $_GET['orcamento'];
    $inicio = $_GET['entregaInicio'];
    $fim = $_GET['entregaFim'];
    $quemEntregou = strtoupper($_GET['quemEntregou']);

    $sql = $pdo->prepare("UPDATE tb_horario_delivery SET entregaInicio = :inicio, entregaFim = :fim, quemEntregou = :quemEntregou WHERE orcamento = $orcamento");
    $sql->bindValue(":inicio", $inicio);
    $sql->bindValue(":fim", $fim);
    $sql->bindValue(":quemEntregou", $quemEntregou);
    $sql->execute(); 
 
    header("Location:/delivery.processo.php?saiu=$orcamento"); 
    exit;

}
