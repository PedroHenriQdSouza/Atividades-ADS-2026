SELECT SUM(venda_has_produto.quantidade) AS total_produtos_periodo
FROM venda_has_produto
JOIN vendas ON venda_has_produto.idvenda = vendas.idvenda
WHERE vendas.data_venda BETWEEN '2021-07-08' AND '2021-07-10';