<?php

require 'conexao.banco.php';
require 'classes/usuarios.class.php';

$html = "";
$seq = "1";


if(isset($_GET['orcamento'])) {

    $orcamento = addslashes($_GET['orcamento']);
    
    $sql = "SELECT a.id, a.nome, a.idEndereco, b.logradouro, a.numero, b.cidadeEstado, a.telefone, b.cidadeEstado, c.orcamento, c.pagamento, d.usuario, DATE_FORMAT(c.dataPedido,'%d/%m/%Y %H:%i') as saida_data
    from tb_cliente a, tb_endereco b, tb_log_delivery c, tb_usuarios d
    where c.orcamento = '$orcamento'
    and c.idCliente = a.id
    and c.usuario = d.id
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
            $dataPedido = $delivery['saida_data'];  
            $usuario  = explode(".", $delivery['usuario']);
            $pagamento = $delivery['pagamento']; 
            $cidade = $delivery['cidadeEstado']; 


        }   
                
    }
}
$total = "";
$valorTotal = "00,00";

if(!empty($orcamento)) {
    
    $sql = "SELECT d.c_produto, e.d_produto, d.quantidade, e.preco, e.estoque, d.observacao
    from tb_log_delivery c, tb_orcamento d, tb_produto e
    where c.orcamento = '$orcamento'
    and c.orcamento = d.orcamento
    and d.c_produto = e.c_produto";

    $sql = $pdo->query($sql);

    $html .= '<table width=100%>';
    $html .= '<thead class="tabelaProduto">';
    $html .= '<tr>';
    $html .= '<th>Seq</th>';
    $html .= '<th>Cod</th>';
    $html .= '<th>Produto</th>';
    $html .= '<th>Qtd</th>';
    $html .= '<th>Un</th>';
    $html .= '<th>Total</th>';
    $html .= '<th>Estoque</th>';
    $html .= '<th>Obs</th>';
    $html .= '</tr>';
    $html .= '</thead>';


    while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
        
        $preco = $linha['preco'];
        $quantidade = $linha['quantidade'];
        $resultado = number_format($preco*$quantidade,2,",",".");


        $html .='<tbody class="tabelaProduto">';
        $html .= '<tr>';
        $html .= '<td>'.$seq++.'</td>';
        $html .= '<td>'.$linha['c_produto'] .'</td>';
        $html .= '<td>'.$linha['d_produto'] .'</td>';
        $html .= '<td>'.$linha['quantidade'] .'</td>';
        $html .= '<td> R$ '.$linha['preco'] .'</td>';
        $html .= '<td> R$ '.$resultado.'</td>';
        $html .= '<td>'.$linha['estoque'] .'</td>';
        $html .= '<td>'.$linha['observacao'] .'</td>';
        $html .= '</tr>';
        $html .='</tbody>';	

        $valorTotal += $resultado;
    }
    $html .='</table>';
    
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

    <html lang="pt-br">
        <head>
            <meta charset="utf-8">
            <title>Impressao</title>
            <link rel="stylesheet" href="assets/css/impressao.css">

        </head>
        <body>

            <div class="cabecalho">
            <table width=100%;>
                <tr>
                    <td style="width:70%;"><strong>Nome:</strong> '.$nome.'</td>
                    <td style="text-align:right;"><strong>Orcamento Nº:</strong> '.$orcamento.'</td>
                </tr>
            </table>
            <table width=100%;>
                <tr>
                    <td style="width:50%;"><strong>Endereco:</strong> '.$endereco.' <strong>N°:</strong>'.$numero.' </td>
                    
                    <td style="text-align:right;"><strong>Cidade:</strong> '.$cidade.'</td>
                </tr>
            </table>
            <table width=100%;>
                <tr>
                    <td ><strong>Usuario:</strong> '.$usuario['0'].'</td>
                    <td><strong>Data:</strong> '.$dataPedido.'</td>
                    <td><strong>F. Pagamento</strong> '.$pagamento.'</td>
                    <td style="text-align:right;"><strong>Total:</strong> R$'.number_format($valorTotal,2,",",".").'</td>
                </tr>
            </table>           

            </div>    

            <hr>
            <div class="produto">

                

                '.$html.'
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

