SELECT produto.descricao, produto.preco 
FROM produto
WHERE produto.preco = (SELECT MAX(produto.preco) FROM produto);