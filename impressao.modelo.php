<?php

require 'conexao.banco.php';
require 'classes/usuarios.class.php';

$html = "";


if(isset($_GET['orcamento'])) {

    $orcamento = addslashes($_GET['orcamento']);
    
    $sql = "SELECT a.id, a.nome, a.idEndereco, b.logradouro, a.numero, a.telefone, b.cidadeEstado, c.orcamento, c.dataPedido, d.c_produto, e.d_produto, d.quantidade, d.valor_total
    from tb_cliente a, tb_endereco b, tb_log_delivery c, tb_orcamento d, tb_produto e
    where c.orcamento = '$orcamento'
    and c.orcamento = d.orcamento
    and d.c_produto = e.c_produto
    and c.idCliente = a.id
    and c.idEndereco = b.id";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {        

        foreach($sql->fetchAll() as $delivery) { 
            $idNome = $delivery['id'];
            $nome = $delivery['nome'];
            $idEndereco = $delivery['idEndereco'];
            $endereco = $delivery['logradouro'];
            $numero = $delivery['numero'];
            $orcamento = $delivery['orcamento'];
            $dataPedido = $delivery['dataPedido'];  
            
            $cProduto = $delivery['c_produto'];
            $dProduto = $delivery['d_produto'];
            $quantidade = $delivery['quantidade'];
            $valor = $delivery['valor_total'];
            

        }   
                
    }
    
}


//var_dump($delivery);


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
                    <div class="cabecalho">
                        <h3>'.$nome.'</h3>
                        <h3>'.$endereco.'</h3>
                        <h3>'.$numero.'</h3>
                        <h3>'.$orcamento.'</h3>
                        <h3>'.$dataPedido.'</h3>
                        <hr>
                    </div>
                    <div class="listaProduto>

                    <div class="tabela-titulo">
                        <table>
                            <tr>

                                <th style="width:5%;">Codigo</th>
                                <th style="width:10%;">Produto</th>
                                <th style="width:10%;">Quantidade</th>
                                <th style="width:10%;">Valor</th>

                            </tr>
                        </table> 

                        <table>                            

                            echo "<tr>";
                            echo "<td style="width:5%;">'.$cProduto.'</td>";
                            echo "<td style="width:10%;">'.$dProduto.'</td>";
                            echo "<td style="width:10%;">'.$quantidade.'</td>";
                            echo "<td style="width:10%;">'.$valor.'</td>";
                            echo "</tr>";  
                                     
                        </table>


                    </div>
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

