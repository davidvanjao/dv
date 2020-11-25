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

$array = array();

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
var_dump($array);

//echo json_encode ($array);

/*if(!empty($_POST['texto'])) { //se existir/ e ele nao estiver vazio.

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
}*/
