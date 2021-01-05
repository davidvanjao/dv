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


-----------------------------------------------------------------------------
30-11 - ALTERAÇÕES NA TABELA

alter table tb_orcamento modify column quantidade decimal(12,3);

-----------------------------------------------------------------------------
04-01 - ALTERAÇÕES NA TABELA CESTABASICA

CREATE TABLE tb_cestabasica(
    id	int	not null auto_increment,	
    data_criacao date,	
    responsavel	varchar(20),		
    quantidade 	int(4),		
    valor	decimal(5,2),		
    tipocesta	varchar(20),		
    tipopessoa varchar(20),	
    usuario varchar(20),	
    data_entrada varchar(20),	
    primary key(id))
    default charset = utf8;	
