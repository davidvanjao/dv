<?php

    if(isset($_GET['adicionar'])) {
        $idProduto = (int)$_GET['adicionar'];
        if(isset($items[$idProduto])) {
            if(isset($_SESSION['carrinho'][$idProduto])){
                $_SESSION['carrinho'][$idProduto]['quantidade']++;
            }else{
                $_SESSION['carrinho'][$idProduto] = array('quantidade'=1, 'nome'=>$items[$idProduto]['nome'], 'preco'=>$items[$idProduto]['preco'] );
            }
            echo '<script>alert("O item foi adicionado ao carrinho.");</script>';
        }else{
            die('voce nao pode adicionar um item que nao existe.');
        }
    }

?>
