<?php    
    //Receber os arquivos
    //$arquivo = $_FILES['arquivo'];
    //var_dump($arquivo);

    $arquivo_tmp = $_FILES['arquivo'] ['tmp_name'];
    //var_dump($arquivo_tmp);

    //ler todo o arquivo  para um array
    $dados = file($arquivo_tmp);
    $sub = str_replace(",",".",$dados); // substitui a virgula por ponto.
    //var_dump($sub);


    foreach($sub as $linha) {
        $linha = trim($linha);
        $valor = explode(';', $linha);
        var_dump($valor);


        $prod_ean = $valor[3];
        $prod_produto= $valor[4];
        $prod_valor = $valor[6];
        $prod_estoque = $valor[5];

        $result_usuario = "INSERT INTO produto (prod_ean, prod_produto, prod_valor, prod_estoque) VALUES('$prod_ean', '$prod_produto', '$prod_valor', '$prod_estoque')"; //INSERE DADOS NA TABELA;
        //$result_usuario = "UPDATE produto SET prod_valor = '$prod_valor', prod_estoque = '$prod_estoque' WHERE prod_ean = '$prod_ean' "; // ATUALIZA OS DADOS;

        $resultado_usuario = mysqli_query($conn, $result_usuario);
    }            
?>

<?php

    if ($conn -> connect_error) {
        die("Falha na conexão: ".$conn->connect_error);
    }
    echo "Conexão Realizada com sucesso!";

    $arquivo = fopen("C:\wamp\www\dv\arquivos\produto.txt", "r");

    while(!feof($arquivo)){
        $linhas = fgets($arquivo);
        $dados = explode(";", $linhas);
        $sub = str_replace(",",".",$dados); // substitui a virgula por ponto.

        //var_dump($sub);

        $prod_ean = $sub[3];
        $prod_produto= $sub[4];
        $prod_valor = $sub[6];
        $prod_estoque = $sub[5];

        $result_usuarioAdicionar = "INSERT INTO produto (prod_ean, prod_produto, prod_valor, prod_estoque) VALUES('$prod_ean', '$prod_produto', '$prod_valor', '$prod_estoque')"; //INSERE DADOS NA TABELA;
        $result_usuarioAtualizar = "UPDATE produto SET prod_valor = '$prod_valor', prod_estoque = '$prod_estoque' WHERE prod_ean = '$prod_ean' "; // ATUALIZA OS DADOS;

        $result_usuarioAdicionar = mysqli_query($conn, $result_usuarioAdicionar);
        $result_usuarioAtualizar = mysqli_query($conn, $result_usuarioAtualizar);


    }
    fclose($arquivo);  
?>

<?php

    $tipo = glob('*.txt');
    echo '<pre>';
    print_r($tipo);  

    $filename = 'produto.txt';
    if (file_exists($filename)) {
    echo "$filename teve o ultimo acesso em: " . date ("F d Y H:i:s.", fileatime($filename));
    }

?>

<!-- 15/08-->

<?php                        

    if ($conn -> connect_error) {
        die("Falha na conexão: ".$conn->connect_error);
    }
    echo "Conexão Realizada com sucesso!";

    $listando = glob('arquivos/*.txt');
    $ultimo = end($listando);
    //var_dump($ultimo);

    $dados = file($ultimo);
    //var_dump($dados);

    foreach($dados as $linha) {
        $linha = trim($linha);
        $valor = explode(';', $linha);
        $sub = str_replace(",",".",$valor); // substitui a virgula por ponto.
        //var_dump($sub);
        unset($sub[0]);
        unset($sub[1]);
        unset($sub[2]);
        unset($sub[7]);

        $prod_ean = $sub[3];
        $prod_produto= $sub[4];
        $prod_valor = $sub[6];
        $prod_estoque = $sub[5];

        $result_usuarioAdicionar = "INSERT INTO produto (prod_ean, prod_produto, prod_valor, prod_estoque) VALUES('$prod_ean', '$prod_produto', '$prod_valor', '$prod_estoque')"; //INSERE DADOS NA TABELA;
        $result_usuarioAtualizar = "UPDATE produto SET prod_valor = '$prod_valor', prod_estoque = '$prod_estoque' WHERE prod_ean = '$prod_ean' "; // ATUALIZA OS DADOS;

        $result_usuarioAdicionar = mysqli_query($conn, $result_usuarioAdicionar);
        $result_usuarioAtualizar = mysqli_query($conn, $result_usuarioAtualizar);    

    }                             
?>






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


/*
    $arquivo_glob = glob('arquivos/*.txt'); //Lista os arquivos dentro da pasta.
    //$arquivo_glob = glob('//192.168.1.52/F/rel-david/*.txt'); //Lista os arquivos dentro da pasta.
    
    if(!empty($arquivo_glob)) {

        $arquivo_end = end($arquivo_glob); //Pega o ultimo arquivo.        
        $arquivo = file($arquivo_end); //Pega o arquivo e transforma em um array.
        $arquivo = array_unique($arquivo);
        //$arquivo = array_filter($arquivo, "impar"); // filtro para saber se o valor nao esta vazio.
        //$arquivo = array_values(array_filter($arquivo, "trim"));
        //array_values: retorna todos os valores de uma matrix.
        //array_filter: Filtra elementos de uma matriz usando uma função de retorno de chamada.
        //trim: tira os espaços em branco (ou outros caracteres) do início e do final de uma string.
        //var_dump($arquivo);

        foreach($arquivo as $linha) {
            $end = explode(';', $linha);
            $end_pos = end($end);
            $array_end[$end[3]][] = end($end);
            $lista = strrpos($linha, ';');
            $nova_lista[$end[3]] = substr($linha, 0, $lista);
        }
        foreach ($array_end as $k => $v) {
            if (array_key_exists($k, $nova_lista)) {
                $list[] = $nova_lista[$k].implode(';', $v);
            }
            $implode = implode(';',$v).'<br>';
            echo $k."<br>";
        }
        
        var_dump($list);                         
        
        $name_file = basename($arquivo_end);
        if (file_exists($arquivo_end)) {
            echo "</br></br>O ultimo arquivo utilizado foi: <strong>$name_file</strong> ";//. date ("d/m/Y", filectime($arquivo_end));
        } 
    } else {
        echo "NÃO EXISTE ARQUIVO PARA IMPORTAÇÃO.";
    }
    
    
 
# Agrega registros com colunas variáveis a um registro exclusivo
 
$w = array('1;Lima;45;1','1;Lima;45;13','1;Vieira;45;51','1;Lima;45;32','1;Lima;45;74','1;Vieira;45;99','1;Lima;45;19');
 
var_dump($w);
 
$j = agregado($w);
 
var_dump($j);
 
# Função
 
function agregado($a){
    # Array temporária
    $t = array();
    foreach($a as $b)
    {
        $linha = explode(";", $b);
        # Cada item será contado a partir do zero, vamos usar o Lima como key
        $key = $linha[1]; // Segundo item como key
        # Verifica se já está na nova array
        if(!array_key_exists($key, $t))
        {
            # Array padrão (colocar cada coluna que sua string tiver)
            $t[$key] = $linha[0] . ';' . $linha[1] . ';' . $linha[2] . ';' . $linha[3];
        }else{
            # Caso já exista, apenas adiciona o último item ao final da string
            $t[$key] .= ';' . end($linha);
        }
    }
    return $t;
}*/