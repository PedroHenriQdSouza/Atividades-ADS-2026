use mercado_phs;

SELECT vendas.data_venda 
FROM vendas
JOIN venda_has_produto ON vendas.idvenda = venda_has_produto.idvenda
JOIN produto ON venda_has_produto.idproduto = produto.idproduto
WHERE produto.descricao = 'creme dental';