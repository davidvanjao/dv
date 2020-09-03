<?php       
                        
    function impar($var){ // funcao usada para saber se o valor do arrey nao e zero. Retorna se o inteiro informado é impar
        return($var & 1);
    }  
    $arquivo_glob = glob('arquivos/*.txt'); //Lista os arquivos dentro da pasta.
    
    if(!empty($arquivo_glob)) {

        $arquivo_end = end($arquivo_glob); //Pega o ultimo arquivo.        
        $arquivo = file($arquivo_end); //Pega o arquivo e transforma em um array.
        $arquivo = array_filter($arquivo, "impar"); // filtro para saber se o valor nao esta vazio.
        $arquivo = array_values(array_filter($arquivo, "trim"));
        //array_values: retorna todos os valores de uma matrix.
        //array_filter: Filtra elementos de uma matriz usando uma função de retorno de chamada.
        //trim: tira os espaços em branco (ou outros caracteres) do início e do final de uma string.
        //var_dump($arquivo);

        foreach($arquivo as $linha) {
            $linha = trim($linha); 
            $linha = explode(';', $linha); //divide uma string por uma string.
            $linha = str_replace(",",".",$linha); // substitui a virgula por ponto.

            unset($linha[0]);
            unset($linha[1]);
            unset($linha[2]);
            unset($linha[7]);

            $prod_cod = $linha[3];
            $prod_produto= $linha[4];
            $prod_valor = $linha[6];
            $prod_estoque = $linha[5];

            $sql = "SELECT * FROM produto WHERE prod_ean = '$prod_cod'";
            $sql = $pdo->query($sql);                                   

            if($sql->rowCount() > 0) {                                
                //echo " dados iguais</br>";
                $atualizar = "UPDATE produto SET prod_produto = '$prod_produto', prod_valor = '$prod_valor', prod_estoque = '$prod_estoque' WHERE prod_ean = '$prod_cod' "; // ATUALIZA OS DADOS;
                $atualizar = $pdo->query($atualizar); 

            } else {
                //echo "dados diferentes.</br>";
                $adicionar = "INSERT INTO produto (prod_ean, prod_produto, prod_valor, prod_estoque) VALUES('$prod_cod', '$prod_produto', '$prod_valor', '$prod_estoque')";
                $adicionar = $pdo->query($adicionar); 
                $adicionar = "SELECT * FROM produto WHERE prod_ean = '$prod_cod'";
                $adicionar = $pdo->query($adicionar); 

                if($adicionar->rowCount() > 0) {
                    foreach($adicionar->fetchAll() as $produto) {

                        echo "<td style='width:50%;'>".$produto['prod_ean']. " - " .$produto['prod_produto']."</td></br>";

                    }
                } 
            }

        }                            
        
        $name_file = basename($arquivo_end);
        if (file_exists($arquivo_end)) {
            echo "</br></br>O último arquivo utilizado foi: <strong>$name_file</strong> ";//. date ("d/m/Y", filectime($arquivo_end));
        } 
    } else {
        echo "NÃO EXISTE ARQUIVO PARA IMPORTAÇÃO.";
    }
    
      
?>