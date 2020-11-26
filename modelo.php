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







if(!empty($_GET['adicionar'])) {

$idProduto = $_GET['adicionar'];

$sql = "SELECT n_gondola, c_produto, d_produto, preco, estoque FROM tb_produto WHERE c_produto = $idProduto";    
$sql = $pdo->query($sql);                                    

if($sql->rowCount() > 0) {
    foreach($sql as $key => $value) {

        if(isset($value['c_produto']) == $idProduto) {

            if(isset($_SESSION['lista'][$idProduto])){

                if(isset($_POST['quantidade'])) {

                    $quantProduto2 = $_POST['quantidade'];

                    $_SESSION['lista'][$idProduto]['quantidade'] = $quantProduto2;

                }

                //echo '<script>alert("O item já foi adicionado ao carrinho.");</script>';

            }else{

                $_SESSION['lista'][$idProduto] = array('quantidade'=>1, 'gondola'=>$value['n_gondola'], 'produto'=>$value['d_produto'], 'preco'=>floatval($value['preco']), 'estoque'=>$value['estoque'],
                'codigo'=>$value['c_produto']);
            }
            
        }
    
                
    }   
    
    
} else {
     echo "Não deu certo!";
}

}

ondblclick=location.href='modelo.painel.2.php?quantidade=".$value['codigo']."'







<table>
    <?php
        if(isset($_POST['pesquisa']) && empty($_POST['pesquisa']) == false) { //se existir/ e ele nao estiver vazio.

            $pesquisa = addslashes($_POST['pesquisa']);
            $sql = "SELECT * FROM tb_produto
            WHERE preco !='0' AND d_produto LIKE '".$pesquisa."%'";
            
            $sql = $pdo->query($sql);                                    

            if($sql->rowCount() > 0) {
                foreach($sql->fetchAll() as $produto) {
                    echo '<tr ondblclick=location.href="modelo.processo.php?produto='.$produto['c_produto'].'" style="cursor:pointer">';
                    echo "<td style='width:10%;'>".$produto['c_produto']."</td>";
                    echo "<td style='width:50%;'>".$produto['d_produto']."</td>";
                    echo "<td style='width:20%;'>R$ ".$produto['preco']."</td>";
                    echo "<td style='width:10%;'>".$produto['estoque']."</td>";
                    //echo '<td style="width:10%;"><a href="modelo.painel.2.php?adicionar='.$produto['c_produto'].'">Add</a>';
                    echo '</tr>';  
                }
            } 
        }
        
    ?>                                        
</table>


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

if(!empty($_POST['texto'])) { //se existir/ e ele nao estiver vazio.

	$texto = $_POST['texto'];
	$sql = "SELECT * FROM tb_produto WHERE preco !='0' AND d_produto LIKE '".$texto."%'";
	
	$sql = $pdo->query($sql);                                    

	if($sql->rowCount() > 0) {
		foreach($sql->fetchAll() as $produto) {
			echo '<tr ondblclick=location.href="modelo.processo.php?produto='.$produto['c_produto'].'" style="cursor:pointer">';
			echo "<td style='width:10%;'>".$produto['c_produto']."</td>";
			echo "<td style='width:50%;'>".$produto['d_produto']."</td>";
			echo "<td style='width:20%;'>R$ ".$produto['preco']."</td>";
			echo "<td style='width:10%;'>".$produto['estoque']."</td>";
			echo '</tr>';  
		}
	} 
}

/*$array = array();

if(!empty($_POST['texto'])) { //se existir/ e ele nao estiver vazio.

	$texto = $_POST['texto'];
	$sql = "SELECT * FROM tb_produto WHERE preco !='0' AND d_produto LIKE '".$texto."%'";
	
	$sql = $pdo->query($sql);                                    

	if($sql->rowCount() > 0) {
		foreach($sql->fetchAll() as $produto) {
			$array[] = array('codigo'=>$produto['c_produto'], 'produto'=>$produto['d_produto'], 'preco'=>$produto['preco'],'estoque'=>$produto['estoque']);
		}
	} 
}
var_dump($array);*/




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