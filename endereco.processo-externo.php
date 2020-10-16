<?php
    session_start();
    require 'conexao.banco.php';
    require 'classes/usuarios.class.php';


    if (isset($_SESSION['logado']) && empty($_SESSION['logado']) == false) {
    } else {
        header("Location: login.php");
    }

    $usuarios = new Usuarios($pdo);
    $usuarios->setUsuario($_SESSION['logado']);

    if($usuarios->temPermissao('PES') == false) {
        header("Location:index.php");
        exit;
    }

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
            $arquivo = array_values(array_filter($arquivo, "trim"));
    
            foreach($arquivo as $endereco) {
                $endereco = trim($endereco);
                $endereco = explode('	', $endereco); //divide uma string por uma string.
                var_dump($endereco);


                $cep = $endereco[0];
                $cidadeEstado = $endereco[1];
                $bairro = $endereco[2];
                $logradouro = $endereco[3];
                $nomeEdificio = '';
                if(empty($endereco[4])) {
                    $nomeEdificio = "";
                } else {
                    $nomeEdificio = $endereco[4];
                }              
                            
    
                $sql = $pdo->prepare("INSERT INTO tb_endereco SET cep = :cep, cidadeEstado = :cidadeEstado, bairro = :bairro, logradouro = :logradouro, nomeEdificio = :nomeEdificio");
                $sql->bindValue(":cep", $cep);
                $sql->bindValue(":cidadeEstado", $cidadeEstado);
                $sql->bindValue(":bairro", $bairro);
                $sql->bindValue(":logradouro", $logradouro);
                $sql->bindValue(":nomeEdificio", $nomeEdificio);
                $sql->execute();

                

            }
        } 
    } 
  
?>
	