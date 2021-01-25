<?php

session_start();
require 'conexao.banco.php';
require 'conexao.banco.oracle.php';
require 'classes/usuarios.class.php';

if (isset($_SESSION['logado']) && empty($_SESSION['logado']) == false) {
} else {
    header("Location: login.php");
}

$usuarios = new Usuarios($pdo);
$usuarios->setUsuario($_SESSION['logado']);

if($usuarios->temPermissao('DEL') == false) {
    header("Location:index.php");
    exit;
}

//=================================================================================================================

$html = "";
$seq = "1";
$pagamento = "";
$total = "";
$valorTotal = floatval("00,00");
$dataHora = date('d/m/Y \à\s H:i:s', strtotime('-1 hour', strtotime(date('Y-m-d H:i:s'))) );

// DADOS DO CLIENTE - SISTEMA CONSINCO.

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

            $nome = @$cliente['NOMERAZAO'];
            $endereco = @$cliente['LOGRADOURO'];
            $numero = @$cliente['NROLOGRADOURO'];
            $cidade = @$cliente['CIDADE']; 
            $ddd = @$cliente['FONEDDD1']; 
            $telefone = @$cliente['FONENRO1']; 

    }
    
}

// DADOS COMO FORMA DE PAGAMENTO, DATA DO PEDIDO, NOME USUARIO
if(isset($_GET['orcamento']) && !empty($_GET['orcamento'])) {

    $sql = "SELECT a.pagamento, b.nome,  DATE_FORMAT(a.dataa,'%d/%m/%Y') as saida_data
    from 
    tb_log_delivery a,
    tb_usuarios b
    where   
    a.orcamento = '$orcamento'
    and a.usuario = b.id";

    $sql = $pdo->query($sql);

    if($sql->rowCount() > 0) {

        while ($dados = $sql->fetch(PDO::FETCH_ASSOC)) {

        $fPagamento = $dados['pagamento'];
        $dataPedido = $dados['saida_data'];
        $usuario = $dados['nome'];

        }

    }
    
}

// DADOS LISTA DE PRODUTOS
if(isset($orcamento) && !empty($orcamento)) {
    
    $sql = "SELECT ean, produto, medida, quantidade, valor_total, estoque, observacao
    from 
    tb_orcamento
    where   
    orcamento = '$orcamento'
    order by produto";

    $sql = $pdo->query($sql);

    $html .= '<table width=100%>';
    $html .= '<thead class="tabelaProduto">';
    $html .= '<tr>';
    $html .= '<th>N°</th>';
    $html .= '<th>CÓDIGO</th>';
    $html .= '<th>PRODUTO</th>';
    $html .= '<th>PREÇO</th>';
    $html .= '<th>QTD</th>';
    $html .= '<th>TOTAL</th>';
    $html .= '<th>ESTOQUE</th>';
    $html .= '<th>OBS</th>';
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
        $html .= '<td> R$ '.number_format($preco,2,",",".") .'</td>';
        $html .= '<td>'.number_format($linha['quantidade'],3,",",".").' '.$linha['medida'].'</td>';
        $html .= '<td> R$ '.number_format($resultado,2,",",".").'</td>';
        $html .= '<td>'.$linha['estoque'] .'</td>';
        $html .= '<td>'.$linha['observacao'] .'</td>';
        $html .= '</tr>';
        $html .='</tbody>';	

        $valorTotal += $resultado;
    }
    $html .='</table>';
    
}


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
                        <td><strong>NOME:</strong> '.$nome.'</td>
                        <td><strong>TEL:('.$ddd.') '.$telefone.' </strong></td>   
                        <td style="text-align:right;"><strong>ORC. Nº:<strong> '.$orcamento.'</td>
                    </tr>
                </table>
                <table width=100%;>
                    <tr>
                        <td><strong>END:</strong> '.$endereco.' <strong>N°:</strong>'.$numero.' </td>
                                             
                        <td style="text-align:right;"><strong>CIDADE:</strong>'.$cidade.'</strong></td>
                    </tr>
                </table>
                <table width=100%;>
                    <tr>
                        <td style="text-transform: capitalize"><strong>USUÁRIO:</strong> '.$usuario.'</td>
                        <td><strong>DATA:</strong> '.$dataPedido.'</td>
                        <td><strong>F. PAGAMENTO:</strong> '.$fPagamento.'</td>
                        <td style="text-align:right;"><strong>TOTAL:<strong> R$'.number_format($valorTotal,2,",",".").'</td>
                    </tr>
                </table>        
            </div>    

            <hr>

            <h2>LISTA DE COMPRA N° '.$orcamento.'</h2>


            <div class="produto">                

                '.$html.'

                <table style="width:100%; margin-top:10px; font-size:20px;">
                    <tr>
                        <td style="text-align:right;"><strong>TOTAL:<strong> R$'.number_format($valorTotal,2,",",".").'</td>
                    </tr>
                </table>  

            </div>

            <footer>
                <hr>
                <table style="width:100%;">
                    <tr>
                        <td style="font-size:12px;">Desenvolvido por: David Vanjão</td>
                        <td style="text-align:right; font-size:12px;">Impresso em: '.$dataHora.'</td>
                    </tr>
                </table>   
            </footer>

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

