SELECT produto.* FROM produto
JOIN categoria ON produto.idcategoria = categoria.idcategoria
WHERE categoria.descricao IN ('higiene pessoal', 'limpeza');