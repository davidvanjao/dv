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

if ($ora_conexao == true)) {
    //echo "Conectado";
} else {
echo "Não conectado!";
}
             
?>

                $db = " (DESCRIPTION =
                (ADDRESS = (PROTOCOL = TCP)(HOST = *seu_host_aqui*)(PORT = 1521))
                (CONNECT_DATA = (SID = *seu_sid_aqui*))
                )";
                $conn = OCILogon("seu_user","sua_senha", $db);


                 $sql_oracle = "select * from sua_tabela";
                 $resultado = OCIParse($ora_conexao, $sql_oracle);
                 
                 if(OCIExecute($resultado)){
                  $cont = 0;
                  while(OCIFetchInto($resultado, $linha, OCI_ASSOC)){
                   $cont++;
                   echo "Linha: ".$cont." - ".$linha['CAMPO_1'];
                  }
                 }else{
                  echo "Aconteceu um erro no resultado da consulta!"
                 }
