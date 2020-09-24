<?php           
    require 'conexao.php';

    #variaveis
    #$pastaArquivo = 'arquivos';
    #$arquivo = glob('arquivos/*.txt'); //Lista os arquivos dentro da pasta.
    $pastaArquivo = '//192.168.1.52/F/rel-david/';
    $arquivo = glob('//192.168.1.52/F/rel-david/*.txt'); //Lista os arquivos dentro da pasta.   
    
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
                $produto = explode(';', $produto); //divide uma string por uma string.
    
                $loja = $produto[0];
                $n_gondola = $produto[1];
                $d_gondola = $produto[2];
                $c_produto = $produto[3];
                $d_produto = $produto[4];
                $estoque = $produto[5];
                $preco = $produto[6];
                $c_interno = $produto[8];
    
                $sql = "SELECT * FROM tb_produto WHERE c_produto = '$c_produto'";
                $sql = $pdo->query($sql);  
    
                if($sql->rowCount() > 0) {   

                    $atualizar = "UPDATE tb_produto SET
                        loja = '$loja',
                        n_gondola = '$n_gondola',
                        d_gondola = '$d_gondola',
                        d_produto = '$d_produto',
                        estoque = '$estoque', 
                        preco = '$preco' 
                    WHERE c_produto = '$c_produto' ";

                    $atualizar = $pdo->query($atualizar);

                } else {

                    $adicionar = "INSERT INTO tb_produto
                        (loja, n_gondola, d_gondola, c_produto, d_produto, estoque, preco)
                        VALUES
                        ('$loja', '$n_gondola', '$d_gondola', '$c_produto', '$d_produto', '$estoque', '$preco')";
                    $adicionar = $pdo->query($adicionar); 

                    $adicionar = "SELECT * FROM tb_produto WHERE c_produto = '$c_produto'"; //mostra na tela os itens adicionados
                    $adicionar = $pdo->query($adicionar); 
    
                    if($adicionar->rowCount() > 0) {
                        foreach($adicionar->fetchAll() as $produto) {
    
                            echo "<td style='width:50%;'>".$produto['c_produto']. " - " .$produto['d_produto']."</td></br>";
    
                        }
                    } 
                } 

                $sql = "SELECT * FROM tb_codigo WHERE c_interno = '$c_interno'";
                $sql = $pdo->query($sql);  
    
                if($sql->rowCount() > 0) {  
                    
                    #echo "nao aconteceu nada";
    
                }  else {
                    $adicionarCodigo = "INSERT INTO tb_codigo
                        (c_produto, c_interno)
                        VALUES
                        ('$c_produto', '$c_interno')";

                    $adicionarCodigo = $pdo->query($adicionarCodigo);  

                    
                }
                
            }


            $infoArquivo = pathinfo($arquivos); //informacoes do arquivo

            $pastaDestino = '//192.168.1.52/F/rel-david/destino';
            $destino = "//192.168.1.52/F/rel-david/destino/Lido - ".$infoArquivo['basename'].""; //destino do arquivo

            #$pastaDestino = 'arquivos/destino';
            #$destino = "arquivos/destino/Lido - ".$infoArquivo['basename'].""; //destino do arquivo
            
            
            if(file_exists($pastaDestino)) {
                #echo "A pasta de destino EXISTE!</br>";

                if(copy($arquivos, $destino)) {
                    echo "</br><strong>Copia Realizada com sucesso!</strong></br>";
                    unlink($arquivos);

                } else {

                    echo "Copia nao efetuada!</br>";
                }

            } else {
                #echo "A pasta destino NAO EXISTE!</br>";      

                if(mkdir($pastaDestino, 0777)) {

                    #echo "A pasta Destino foi CRIADA com sucesso!</br>";

                } else {

                    echo "Erro na criacao da pasta DESTINO!</br>";
                }
        
            }

    
        } else {
            echo "A pasta arquivo esta vazia! Aguarde a geracao de um novo arquivo!</br>";
        }

    } else {
        echo "A pasta onde esta localizado os arquivos nao existe! Verifique.</br>";
    }
  
?>