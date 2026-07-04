SELECT produto.* FROM produto
JOIN categoria ON produto.idcategoria = categoria.idcategoria
WHERE categoria.descricao NOT IN ('cama, mesa e banho', 'limpeza');