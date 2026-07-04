DELIMITER $$

CREATE PROCEDURE sp_atualizar_preco_produto (
    IN p_idproduto INT, 
    IN p_novo_preco DECIMAL(10,2)
)
BEGIN
    UPDATE produto
    SET preco = p_novo_preco
    WHERE idproduto = p_idproduto;
END $$

DELIMITER ;


CALL sp_atualizar_preco_produto(1, 4.50);