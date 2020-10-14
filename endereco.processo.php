<?php           
    require 'conexao.php';

    #variaveis
    $pastaArquivo = 'arquivos';
    $arquivo = glob('arquivos/*.txt'); //Lista os arquivos dentro da pasta.
    
    #funcoes
    function impar($var){ //funcao usada para saber se o valor do arrey nao e zero. Retorna se o inteiro informado é impar
        return($var & 1);
    } 

    if(file_exists($pastaArquivo)) {
        if(!empty($arquivo)) {
            $arquivos = reset($arquivo); //Pega o primeiro arquivo.
            $arquivo = file($arquivos); //Pega o arquivo e transforma em um array.
            $arquivo = array_filter($arquivo, "impar"); // filtro para saber se o valor nao esta vazio.
            $arquivo = array_values(array_filter($arquivo, "trim"));
    
            foreach($arquivo as $produto) {
                $produto = trim($produto);
                $produto = explode('	', $produto); //divide uma string por uma string.
                var_dump($produto);

            }
        } 
    } 
  
?>
	