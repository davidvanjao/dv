<?php

session_start();
require 'conexao.banco.php';
//require 'conexao.banco.oracle.php';
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
    $quemFez = $_GET['quemFez'];

    $sql = $pdo->prepare("UPDATE tb_horario_delivery SET andamentoInicio = :inicio, andamentoFim = :fim, quemFez = :quemFez WHERE orcamento = $orcamento");
    $sql->bindValue(":inicio", $inicio);
    $sql->bindValue(":fim", $fim);
    $sql->bindValue(":quemFez", $quemFez);
    $sql->execute(); 
 
    header("Location:/delivery.log.php?orcamento=$orcamento"); 
    exit;

}
