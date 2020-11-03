<?php

session_start();
require 'conexao.banco.php';



$sql = "SELECT MAX(id) FROM tb_log_delivery";
$sql = $pdo->query($sql);

if($sql->rowCount() > 0) {

    $orcamento = $sql->fetch();

    $orcamento = intVal($orcamento[0]);
    $orcamento = $orcamento + 1;    

    $_SESSION['orcamento'] = $orcamento;

}


var_dump($orcamento);
var_dump($_SESSION);
//session_destroy();





if(isset($_GET['adicionar'])) {

$idProduto = (int)$_GET['adicionar'];

$sql = "SELECT * FROM tb_produto WHERE id = $idProduto";    
$sql = $pdo->query($sql);                                    

if($sql->rowCount() > 0) {
    foreach($sql as $key => $value) {

           
    }


    if(isset($value['id']) == $idProduto) {
        if(isset($_SESSION['carrinho'][$idProduto])){
            $_SESSION['carrinho'][$idProduto]['quantidade']++;
        }else{
            $_SESSION['carrinho'][$idProduto] = array('quantidade'=>1, 'produto'=>$value['d_produto'], 'preco'=>$value['preco'], 'estoque'=>$value['estoque'], 'codigo'=>$value['c_produto'], 'id'=>$value['id']);
        }
        //echo '<script>alert("O item foi adicionado ao carrinho.");</script>';
    }else{
        die('voce nao pode adicionar um item que nao existe.');
    }

    
} 

}
?>