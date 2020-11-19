<?php

require 'conexao.banco.php';
require 'classes/usuarios.class.php';

$html = "";


if(isset($_GET['orcamento'])) {

    $orcamento = addslashes($_GET['orcamento']);
    
    $sql = "SELECT a.id, a.nome, a.telefone, b.cidadeEstado, a.idEndereco, b.logradouro, a.numero, c.orcamento, c.dataPedido
    from tb_cliente a, tb_endereco b, tb_log_delivery c
    where c.orcamento = '$orcamento'
    and c.idCliente = a.id
    and c.idEndereco = b.id";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {        

        foreach($sql->fetchAll() as $cabecalho) { 
            $html .= $idNome = $cabecalho['id']. "<br>";
            $html .= $nome = $cabecalho['nome']. "<br>";
            $html .= $idEndereco = $cabecalho['idEndereco']. "<br>";
            $html .= $endereco = $cabecalho['logradouro']. "<br>";
            $html .= $numero = $cabecalho['numero']. "<br>";
            $html .= $orcamento = $cabecalho['orcamento']. "<hr>";     
        }   
                
    }
    
}
echo $html;

//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

//incluir arquivo de impressao
require_once("dompdf/autoload.inc.php") ;

//criando instancia
$dompdf = new DOMPDF();

//carrega o html
$dompdf->load_html('

            <!DOCTYPE html>
			<html lang="pt-br">
				<head>
					<meta charset="utf-8">
					<title>Celke</title>
                </head>
                <body>
					'.$html.'
				</body>
			</html>


');

//$dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper('A4', 'portrait');

//renderizar o html
$dompdf->render();

//exibir a página
$dompdf->stream(
    "relatorio_celke.pdf",
    array(
        "Attachment" => false //para realizar o dowload somente alterar para true
    )
);

?>

