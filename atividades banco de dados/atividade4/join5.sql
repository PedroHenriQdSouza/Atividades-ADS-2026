SELECT AVG(produto.preco) AS media_produtos
FROM produto
JOIN venda_has_produto ON produto.idproduto = venda_has_produto.idproduto
JOIN vendas ON venda_has_produto.idvenda = vendas.idvenda
WHERE vendas.data_venda = '2021-01-23';