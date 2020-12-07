<?php

$ora_user = "david";
$ora_senha = "XWzjTz9FGYAeLYX5";

$ora_bd = "(DESCRIPTION=
                        (ADDRESS_LIST=
                            (ADDRESS=(PROTOCOL=TCP)(HOST=192.168.1.62)(PORT=1521))
                      )
                     (CONNECT_DATA=
                            (SERVICE_NAME=bdsg)
                     )
                 )";

$ora_conexao = oci_connect($ora_user, $ora_senha, $ora_bd);

if ($ora_conexao == true) {
    echo "Conectado";
} else {
    echo "Não conectado!";
}
             
?>

                
