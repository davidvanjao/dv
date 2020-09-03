<?php
require 'config.php';

$id = 0;
if(isset($_GET['id']) && empty($_GET['id']) == false) {
    $id = addslashes($_GET['id']);

    if(isset($_POST['nome']) && empty($_POST['nome']) == false) {
        $nome = addslashes($_POST['nome']);
        $usuario = addslashes($_POST['usuario']);

        $sql = "UPDATE tb_usuarios SET nome = '$nome', usuario = '$usuario' WHERE id = '$id'";
        $pdo->query($sql);

        header("Location: index.php");

    }



    $sql = "SELECT * FROM tb_usuarios WHERE id = '$id'";
    $sql = $pdo->query($sql);
    if($sql->rowCount() > 0) {
        $dado = $sql->fetch();
    }

} else {
    header("Location: index.php");
}

?>
<form method="POST">
    Nome:<br/>
    <input type="text" name="nome" value="<?php echo $dado['nome'];?>"/><br/><br/>

    Usuario:<br/>
    <input type="text" name="usuario" value="<?php echo $dado['usuario'];?>"/><br/><br/>

    <input type="submit" value="Atualizar"/><br/>

</form>