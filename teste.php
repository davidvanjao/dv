<?php      


session_start();
require 'conexao.php';
require 'classes/usuarios.class.php';


if (isset($_SESSION['logado']) && empty($_SESSION['logado']) == false) {
} else {
    header("Location: login.php");
}

$usuarios = new Usuarios($pdo);
$usuarios->setUsuario($_SESSION['logado']);

if($usuarios->temPermissao('CONF') == false) {
    header("Location:index.php");
    exit;
}


                        
    function impar($var){ // funcao usada para saber se o valor do arrey nao e zero. Retorna se o inteiro informado é impar
        return($var & 1);
    }  

    $arquivo_glob = glob('arquivos/*.txt'); //Lista os arquivos dentro da pasta.
    //$arquivo_glob = glob('//192.168.1.52/F/rel-david/*.txt'); //Lista os arquivos dentro da pasta.
    
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
            var_dump($linha);
            
            $prod_cod = $linha[3];
            $prod_int= $linha[8];


            $sql = "SELECT * FROM tb_prodcodigo WHERE cod_produto = '$prod_cod'";
            $sql = $pdo->query($sql);                                             

          
            $adicionar = "INSERT INTO tb_prodcodigo (codigo, cod_produto) VALUES('$prod_int', '$prod_cod')";
            $adicionar = $pdo->query($adicionar); 


        }                            
        
        $name_file = basename($arquivo_end);
        if (file_exists($arquivo_end)) {
            echo "</br></br>O último arquivo utilizado foi: <strong>$name_file</strong> ";//. date ("d/m/Y", filectime($arquivo_end));
        } 
    } else {
        echo "NÃO EXISTE ARQUIVO PARA IMPORTAÇÃO.";
    }
    
      

      
?>
