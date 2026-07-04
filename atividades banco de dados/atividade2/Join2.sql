use mercado_phs;

SELECT produto.preco, categoria.descricao AS categoria_descricao
FROM produto
JOIN categoria
ON produto.idcategoria = categoria.idcategoria
WHERE categoria.descricao = 'limpeza';