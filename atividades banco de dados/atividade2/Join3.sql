use mercado_phs;

SELECT produto.descricao AS produto_descricao,
       produto.preco,
       categoria.descricao AS categoria_descricao
FROM produto
JOIN categoria
ON produto.idcategoria = categoria.idcategoria;