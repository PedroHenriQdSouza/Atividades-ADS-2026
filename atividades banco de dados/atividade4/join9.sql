SELECT vendas.data_venda, SUM(venda_has_produto.quantidade) AS qtd_total_vendida
FROM vendas
JOIN venda_has_produto ON vendas.idvenda = venda_has_produto.idvenda
GROUP BY vendas.data_venda
ORDER BY qtd_total_vendida ASC
LIMIT 1;