use mercado_phs;

SELECT produto.*
FROM produto
JOIN categoria
ON produto.idcategoria = categoria.idcategoria
WHERE categoria.descricao = 'higiene pessoal';