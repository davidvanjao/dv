<?php

require 'conexao.banco.php';
require 'conexao.banco.oracle.php';
require 'classes/usuarios.class.php';

$html = "";
$seq = "1";
$pagamento = "";
$total = "";
$valorTotal = floatval("00,00");

if(isset($_GET['orcamento']) && !empty($_GET['orcamento'])) {
    
}


if(isset($_GET['orcamento']) && !empty($_GET['orcamento'])) {

    $orcamento = addslashes($_GET['orcamento']);
    $codCliente = addslashes($_GET['cliente']);
    
    $consulta = "SELECT NOMERAZAO, LOGRADOURO, NROLOGRADOURO, CIDADE, FONEDDD1, FONENRO1
    FROM 
    CONSINCO.GE_PESSOA 
    WHERE 
    SEQPESSOA = '$codCliente'";                                         
    
    //prepara uma instrucao para execulsao
    $resultado = oci_parse($ora_conexao, $consulta) or die ("erro");

    //Executa os comandos SQL
    oci_execute($resultado);

    while (($cliente = oci_fetch_array($resultado, OCI_ASSOC)) != false) {

            $nome = $cliente['NOMERAZAO'];
            $endereco = $cliente['LOGRADOURO'];
            $numero = $cliente['NROLOGRADOURO'];
            $cidade = $cliente['CIDADE']; 
            $ddd = $cliente['FONEDDD1']; 
            $telefone = $cliente['FONENRO1']; 

    }
    
}

if(isset($orcamento) && !empty($orcamento)) {
    
    $sql = "SELECT ean, produto, medida, quantidade, valor_total, estoque, observacao
    from 
    tb_orcamento
    where   
    orcamento = '$orcamento'";

    $sql = $pdo->query($sql);

    $html .= '<table width=100%>';
    $html .= '<thead class="tabelaProduto">';
    $html .= '<tr>';
    $html .= '<th>Seq</th>';
    $html .= '<th>Cod</th>';
    $html .= '<th>Produto</th>';
    $html .= '<th>Med</th>';
    $html .= '<th>Qtd</th>';
    $html .= '<th>Un</th>';
    $html .= '<th>Total</th>';
    $html .= '<th>Estoque</th>';
    $html .= '<th>Obs</th>';
    $html .= '</tr>';
    $html .= '</thead>';

    while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
        
        $preco = floatval($linha['valor_total']);
        $quantidade = floatval($linha['quantidade']);
        $resultado = $preco*$quantidade;


        $html .='<tbody class="tabelaProduto">';
        $html .= '<tr>';
        $html .= '<td>'.$seq++.'</td>';
        $html .= '<td>'.$linha['ean'] .'</td>';
        $html .= '<td>'.$linha['produto'] .'</td>';
        $html .= '<td>'.$linha['medida'] .'</td>';
        $html .= '<td>'.$linha['quantidade'] .'</td>';
        $html .= '<td> R$ '.number_format($preco,2,",",".") .'</td>';
        $html .= '<td> R$ '.number_format($resultado,2,",",".").'</td>';
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
                        <td><strong>Nome:</strong> '.$nome.'</td>
                        <td><strong>Tel:('.$ddd.') '.$telefone.' </strong></td>   
                        <td style="text-align:right; font-size:20px;"><strong>Orç. Nº: '.$orcamento.'</strong></td>
                    </tr>
                </table>
                <table width=100%;>
                    <tr>
                        <td><strong>Endereco:</strong> '.$endereco.' <strong>N°:</strong>'.$numero.' </td>
                                             
                        <td style="text-align:right;"><strong>Cidade: '.$cidade.'</strong></td>
                    </tr>
                </table>
                <table width=100%;>
                    <tr>
                        <td style="text-transform: capitalize"><strong>Usuario:</strong></td>
                        <td><strong>Data:</strong></td>
                        <td><strong>F. Pagamento:</strong></td>
                        <td style="text-align:right; font-size:20px;"><strong>Total: R$'.number_format($valorTotal,2,",",".").'</strong></td>
                    </tr>
                </table>        
            </div>    

            <hr>
            <div class="produto">                

                '.$html.'
            </div>

            <script type="text/php">
            if (isset($dompdf)) 
            {               
                $dompdf = utf8_encode("Página {PAGE_NUM} de {PAGE_COUNT} ") ;
                
            }
            </script>


        </body>

    </html>


');

//$dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper('A4', 'portrait');

//renderizar o html
$dompdf->render();

//exibir a página
$dompdf->stream(
    "relatorio_orcamento.pdf",
    array(
        "Attachment" => false //para realizar o dowload somente alterar para true
    )
);

//$dompdf->getDOMPdf()->set_option('isPhpEnabled', true);


?>

