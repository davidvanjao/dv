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




/*if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);

    $sql = "SELECT a.id, a.nome, a.telefone, b.cidadeEstado, b.bairro, b.logradouro, a.numero 
    from tb_cliente a, tb_endereco b 
    where a.id = '$id'
    and a.idEndereco = b.id";
 

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {

        $cliente = $sql->fetch();
        
        
    } else {

        //$cliente = "";

    }
} */

/*if(isset($_GET['id']) && empty($_GET['id']) == false) { 
    $idCliente = $valueCliente['id'];
    $nomeCliente = $valueCliente['nome'];
} else {
    $idCliente = "";
    $nomeCliente ="";
}*/





if(isset($_GET['adicionar'])) {

$idProduto = (int)$_GET['adicionar'];

$sql = "SELECT * FROM tb_produto WHERE id = $idProduto";    
$sql = $pdo->query($sql);                                    

if($sql->rowCount() > 0) {
    foreach($sql as $key => $value) {

        if(isset($value['id']) == $idProduto) {
            if(isset($_SESSION['orcamento'][$idProduto])){

                if(isset($_POST['quantProd'])) {


                    $prodQuantidade = $_POST['quantProd'];
                    $_SESSION['orcamento'][$idProduto]['quantidade'] = $prodQuantidade;                                        
                
                    
                }

                    //$_SESSION['orcamento'][$idProduto]['quantidade']++;

                    //echo '<script>alert("Esse produto já existe na lista!");</script>';

            }else{

                $_SESSION['orcamento'][$idProduto] = array('quantidade'=>1, 'produto'=>$value['d_produto'], 'preco'=>$value['preco'], 'estoque'=>$value['estoque'], 'codigo'=>$value['c_produto'], 'id'=>$value['id']);
            }
            
        }else{

            die('voce nao pode adicionar um item que nao existe.');
        }
    
                
    }   
    
    
} 

}
<!--<input value=".$quantidade." class='quantidade' type='number' min='0'  name='quantidade' required='required' onchange='this.form.submit()'>-->