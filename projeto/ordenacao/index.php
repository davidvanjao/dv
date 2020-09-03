<?php

try {
    $pdo = new PDO("mysql:dbname=banco_produto;host=localhost","root", "");
} catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;

}

if(isset($_GET['ordem']) && empty($_GET['ordem']) == false){
    $ordem = addslashes($_GET['ordem']);
    $sql = "SELECT * FROM produto ORDER BY ".$ordem;
} else {
    $ordem = '';
    $sql = "SELECT * FROM produto";
}

?>
<form method="GET">
    <select name="ordem" onchange="this.form.submit()">
        <option></option>
        <option value="prod_produto" <?php echo ($ordem=="prod_produto")?'selected="selected"':'';?>>Pelo Nome</option>
        <option value="prod_ean" <?php echo ($ordem=="prod_ean")?'selected="selected"':'';?>>Pelo Codigo</option>    
    </select>
</form>

<table border="1" width="400">
    <tr>
        <th>Codigo</th>
        <th>Produto</th>  
    </tr>

    <?php


        $sql = $pdo->query($sql);
        if($sql->rowCount() > 0){
            foreach($sql->fetchAll() as $produto):
    ?>
                <tr>
                    <td><?php echo $produto['prod_ean'];?></td>
                    <td><?php echo $produto['prod_produto'];?></td>
                </tr>
    <?php
    endforeach;
            
            
        }

    ?>
</table>