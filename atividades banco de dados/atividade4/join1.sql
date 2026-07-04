SELECT COUNT(venda_has_produto.idvenda) AS total_venda_escovas
FROM venda_has_produto
JOIN produto ON venda_has_produto.idproduto = produto.idproduto
WHERE produto.descricao = 'escova dental';