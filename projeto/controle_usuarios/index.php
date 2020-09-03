<?php
require 'config.php';
?>

<a href="adicionar.php">Adicionar Novo Usuario</a>

<table border="0" width="100%">
    <tr>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Acoes</th>  
    </tr>
    <?php

        $sql = "SELECT * FROM tb_usuarios";
        $sql = $pdo->query($sql);
        if($sql->rowCount() > 0) {
            //echo 'Ta tudo bem.';
            foreach($sql->fetchAll() as $usuario) {
                echo '<tr>';
                echo '<td>'.$usuario['nome'].'</td>';
                echo '<td>'.$usuario['usuario'].'</td>';
                echo '<td>'.$usuario['permissao'].'</td>';
                echo '<td><a href="editar.php?id='.$usuario['id'].'">Editar</a> - <td><a href="excluir.php?id='.$usuario['id'].'">Excluir</a></td>';

                echo '</tr>';
            }
        }


    ?>
</table>