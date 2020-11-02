<?php

    $items = array(['nome'=>'Curso 1', 'imagem'=>'item1.png', 'preco'=>'200'],
                    ['nome'=>'Curso 1', 'imagem'=>'item1.png', 'preco'=>'200'],
                    ['nome'=>'Curso 1', 'imagem'=>'item1.png', 'preco'=>'200']);

    foreach($items as $key => $value) {

?>
    <div class="produto">
        <img src="<?php echo $value['imagem']?>"/>
        <a href="?adicionar=<?php echo $key ?>">Adicionar ao carrinho!</a>
    </div>

    <?php
}
?>

<?php

    if(isset($_GET['adicionar'])) {
        $idProduto = (int) $_GET['adicionar'];
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

<h2>Carrinho</h2>

<?php

    foreach($_SESSION['carrinho'] as $key=>$value) {
        //Nome do Produto
        //Quantidade
        //Preco
        echo '<div class="carrinho-item">';
        echo '<p>Nome: '.$value['nome'].' | Quantidade: '.$value['quantidade'].' | Preco: R$ '.($value['quantidade']*$value['preco']).',00</p>';
        echo '</div>';
    }

?>