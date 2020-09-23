# dv
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