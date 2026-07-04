SELECT produto.descricao, SUM(venda_has_produto.quantidade) AS Total_de_Vendas
FROM venda_has_produto
JOIN produto ON venda_has_produto.idproduto = produto.idproduto
GROUP BY produto.idproduto, produto.descricao
ORDER BY Total_de_Vendas DESC
LIMIT 1;