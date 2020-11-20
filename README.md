03-09 WORK: Criacao do arquivo teste.php para teste no codigo do produto.
03-09 HOME: Criacao da nova tabela sql. O mesmo possui chave estrangeira.

-----------------------------------------------------------------------------
04-09 WORK: Leitura dos campos gerados.

1;1;RUA 01 G1 - OLEO;158631;SAL MARLIN CHURRASCO 1KG;1625;1.39;37;38203

NOME DO BANCO: bd_produto
TABELA: tb_produto

0 - ID - id - int(11)
1 - LOJA - loja - int(11)
2 - N° GONDOLA - n_gondola - int(11)
3 - NOME GONDOLA - d_gondola -  varchar(255)
4 - CODIGO PRODUTO - c_produto - int(11)
5 - DESCRIÇÃO DO PRODUTO - d_produto - varchar(255)
6 - ESTOQUE - estoque - int(11)
7 - VALOR - preco - decimal(8,2)
8 - DESCOBRIR - descobrir - int(11)
9 - CODIGO INTERNO - c_interno - varchar(15)

TABELA: tb_codigo

0 - ID - int(11)
1 - CODIGO PRODUTO - c_produto - int(11)
2 - CODIGO INTERNO - c_interno - varchar(15)


22-09 HOME: Indroducao ao novo arquivo.
23-09 WORK: Inserção dos caminhos para a leitura do arquivo.
24-09 HOME: Atualização do código para tarna-lo mais limpo.

-----------------------------------------------------------------------------
12-10 - CRIACAO DA TABELA CESTA BASICA

NOME DO BANCO: bd_produto
TABELA: tb_cestaBasica

0 - ID - id - int(11)
1 - DATA - data - date
2 - RESPONSAVEL - responsavel - varchar(255)
3 - QUANTIDADE - quantidade - int(11)
4 - VALOR - valor - decimal(8,2)
5 - TIPO DE CESTA - tipoCesta - varchar(255)
6 - TIPO PESSOA - tipoPessoa - varchar(255)

-----------------------------------------------------------------------------
14-10 - CRIACAO DA TABELA CESTA BASICA

NOME DO BANCO: bd_produto
TABELA: tb_endereco

0 - ID - id - int(11)
1 - CEP - cep - int(11)
2 - CIDADE ESTADO - cidadeEstado - varchar(255)
3 - BAIRRO - bairro - varchar(255)
4 - LOGRADOURO - logradouro - varchar(255)
5 - NOME DIFICIO - nomeEdificio - varchar(255)

-----------------------------------------------------------------------------
15-10 - CRIACAO DA TABELA ENTREGA

NOME DO BANCO: bd_produto
TABELA: tb_entrega

0 - ID - id - int(11)
1 - DATA - dataa - date
2 - CEP - cep - int(11)
3 - CIDADE ESTADO - cidadeEstado - varchar(255)
4 - BAIRRO - bairro - varchar(255)
5 - LOGRADOURO - logradouro - varchar(255)
6 - VALOR - valor - decimal(8,2)
7 - COMPRA - compra - int(11)
8 - NUMERO DE CAIXAS - nCaixas - int(11)

-----------------------------------------------------------------------------
23-10 - CRIACAO DA TABELA ENTREGA

NOME DO BANCO: bd_produto
TABELA: tb_cliente

0 - ID - id - int(11)
1 - NOME - nome - varchar(255)
2 - NUMERO - numero - int(11)
3 - TELEFONE - telefone - varchar(255)
4 - ID ENDERECO - idEndereco - int(11) - chave estrangeira

-----------------------------------------------------------------------------
23-10 - CRIACAO DA TABELA LOG DELIVERY

NOME DO BANCO: bd_produto
TABELA: tb_log_delivery

0 - ID - id - int(11)
1 - DATA - dataa - date
2 - ID CLIENTE - idCliente - int(11)
3 - CUPOM FISCAL - cupom - varchar(255)
4 - COMPRA - compra - int(11)
5 - VALOR - valor - decimal(8,2)
6 - STATUS - status - varchar(255)


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
                                  
                            $sql = "SELECT a.id, a.nome, a.idEndereco, b.logradouro, a.numero, a.telefone, b.cidadeEstado, c.orcamento, c.dataPedido, d.c_produto, e.d_produto, d.quantidade, d.valor_total
                            from tb_cliente a, tb_endereco b, tb_log_delivery c, tb_orcamento d, tb_produto e
                            where c.orcamento = '$orcamento'
                            and c.orcamento = d.orcamento
                            and d.c_produto = e.c_produto
                            and c.idCliente = a.id
                            and c.idEndereco = b.id";
                        
                            $sql = $pdo->query($sql);
                        
                            if($sql->rowCount() > 0) {       
                        
                                foreach($sql->fetchAll() as $deliverys) { 

                                    echo "<tr>";
                                    echo "<td style="width:5%;">'.$deliverys['c_produto'].'</td>";
                                    echo "<td style="width:10%;">'.$deliverys['d_produto'].'</td>";
                                    echo "<td style="width:10%;">'.$deliverys['quantidade'].'</td>";
                                    echo "<td style="width:10%;">'.$deliverys['valor_total'].'</td>";
                                    echo "</tr>";                                    
                        
                                }   
                                        
                            }
                        </table>


                    </div>
				</body>
			</html>