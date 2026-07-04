SELECT produto.*, categoria.descricao AS categoria_descricao
FROM produto
JOIN categoria ON produto.idcategoria = categoria.idcategoria
WHERE categoria.descricao = 'higiene pessoal' 
  AND produto.descricao LIKE '%dental';