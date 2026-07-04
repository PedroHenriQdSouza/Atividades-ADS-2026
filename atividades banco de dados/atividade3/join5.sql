SELECT DISTINCT vendas.* FROM vendas
JOIN venda_has_produto ON vendas.idvenda = venda_has_produto.idvenda
JOIN produto ON venda_has_produto.idproduto = produto.idproduto
JOIN categoria ON produto.idcategoria = categoria.idcategoria
WHERE categoria.descricao <> 'higiene pessoal';