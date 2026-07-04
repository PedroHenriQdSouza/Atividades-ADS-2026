USE mercado_phs;

SELECT categoria.descricao AS categoria_descricao,
produto.descricao AS produto_descricao, produto.preco
FROM categoria
LEFT JOIN produto
ON categoria.idcategoria = produto.idcategoria;