<?php
session_start();
require 'conexao.banco.php';
require 'classes/usuarios.class.php';

$usuarios = new Usuarios($pdo);

if(isset($_SESSION['logado']) && !empty($_SESSION['h_login'])) {
    $usuario = $_SESSION['logado'];
    $data_login = $_SESSION['h_login'];

    $usuarios->logSessaoSair($usuario, $data_login);

    unset($_SESSION['logado']);
    unset($_SESSION['h_login']);

    header("Location: index.php");
    exit;
} else {
    echo "Erro ao sair!";
}
