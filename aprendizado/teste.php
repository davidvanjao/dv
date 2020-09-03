<?php  

/*   

$listando = glob('arquivos/*.txt');
$ultimo = end($listando);
//var_dump($ultimo);

$arquivo = fopen($ultimo, "r");

while(!feof($arquivo)){
    $linhas = fgets($arquivo);
    $dados = explode(";", $linhas);
    $sub = str_replace(",",".",$dados); // substitui a virgula por ponto.
    $limpo = array_filter($sub);
    unset($limpo[0]);
    unset($limpo[1]);
    unset($limpo[2]);
    unset($limpo[7]);

    //var_dump($limpo);
}

*/

/*

$listando = glob('arquivos/*.txt');
$ultimo = end($listando);
//var_dump($ultimo);

$arquivo = fopen($ultimo, "r");

while(!feof($arquivo)){
    $linhas = fgets($arquivo);
    $dados = explode(";", $linhas);
    $sub = str_replace(",",".",$dados); // substitui a virgula por ponto.
    $limpo = array_filter($sub);
    unset($limpo[0]);
    unset($limpo[1]);
    unset($limpo[2]);
    unset($limpo[7]);

    var_dump($limpo);

}
*/
function impar($var){
    // retorna se o inteiro informado é impar
    return($var & 1);
}                    
                            
$listando_Arquivos = glob('arquivos/*.txt'); //Lista os arquivos dentro da pasta.
$pega_Arquivo_Ultimo = end($listando_Arquivos); //Pega o ultimo arquivo.
$pega_Arquivo_Array = file($pega_Arquivo_Ultimo); //Pega o arquivo e transforma em um array.




$pega_Arquivo_Limpa = array_filter($pega_Arquivo_Array, "impar"); // filtro para saber se o valor nao esta vazio.
$pega_Arquivo_Limpa = array_values(array_filter($pega_Arquivo_Limpa, "trim"));

//$teste = array_fill($pega_Arquivo_Limpa, "");
//var_dump($teste);
//array_values: retorna todos os valores de uma matrix.
//array_filter: Filtra elementos de uma matriz usando uma função de retorno de chamada.
//trim: tira os espaços em branco (ou outros caracteres) do início e do final de uma string.


//var_dump($listando_Arquivos);
//var_dump($pega_Arquivo_Ultimo);
//var_dump($pega_Arquivo_Array);
//var_dump($pega_Arquivo_Limpa);
//var_dump($pega_Arquivo_Limpa);
//echo count($pega_Arquivo_Limpa);


foreach($pega_Arquivo_Limpa as $linha) {
    $linha = trim($linha); 
    $linha = explode(';', $linha); //divide uma string por uma string.
    $linha = str_replace(",",".",$linha); // substitui a virgula por ponto.
    //$linha= array_filter($linha, "trim");
    
    unset($linha[0]);
    unset($linha[1]);
    unset($linha[2]);
    unset($linha[7]);
    

/*
    $prod_cod = $linha[3];
    $prod_produto= $linha[4];
    $prod_valor = $linha[6];
    $prod_estoque = $linha[5];
*/
    var_dump($linha);


}

/*
    $listando = glob('arquivos/*.txt');
    $ultimo = end($listando);
    //var_dump($ultimo);

    $arquivo = fopen($ultimo, "r");

    while(!feof($arquivo)){
        $linhas = fgets($arquivo);
        $dados = explode(";", $linhas); // separa os conteudos.
        $sub = str_replace(",",".",$dados); // substitui a virgula por ponto.
        unset($sub[0]); //Exclui a chave da variavel.
        unset($sub[1]); //Exclui a chave da variavel.
        unset($sub[2]); //Exclui a chave da variavel.
        unset($sub[7]); //Exclui a chave da variavel.

        $prod_ean = $sub[3];
        $prod_produto= $sub[4];
        $prod_valor = $sub[6];
        $prod_estoque = $sub[5];

        var_dump($sub);

        }
    fclose($arquivo); 
*/

?>

=================================================================

<?php                        

                        if ($conn -> connect_error) {
                            die("Falha na conexão: ".$conn->connect_error);
                        }
                        echo "Conexão com o banco realizada com sucesso!</br></br>";

                        

                        function impar($var){ // funcao usada para saber se o valor do arrey nao e zero. Retorna se o inteiro informado é impar
                            return($var & 1);
                        }  

                        $arquivo_glob = glob('arquivos/*.txt'); //Lista os arquivos dentro da pasta.
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



                            $result_usuarioAdicionar = "INSERT INTO produto (prod_ean, prod_produto, prod_valor, prod_estoque) VALUES('$prod_cod', '$prod_produto', '$prod_valor', '$prod_estoque')"; //INSERE DADOS NA TABELA;
                            $result_usuarioAtualizar = "UPDATE produto SET prod_valor = '$prod_valor', prod_estoque = '$prod_estoque' WHERE prod_ean = '$prod_cod' "; // ATUALIZA OS DADOS;

                            $result_usuarioAdicionar = mysqli_query($conn, $result_usuarioAdicionar);
                            $result_usuarioAtualizar = mysqli_query($conn, $result_usuarioAtualizar);    

                        }                            
                        
                        $name_file = basename($arquivo_end);
                        if (file_exists($arquivo_end)) {
                            echo "O último arquivo utilizado foi: <strong>$name_file</strong> ";//. date ("d/m/Y", filectime($arquivo_end));
                        }            
                    ?>