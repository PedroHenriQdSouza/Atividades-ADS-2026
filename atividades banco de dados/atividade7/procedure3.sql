DELIMITER $$

CREATE PROCEDURE sp_atualizar_preco_por_demanda (
    IN p_idproduto INT
)
BEGIN
    -- Variável para guardar o total de itens vendidos
    DECLARE v_total_vendido INT DEFAULT 0;

    -- Soma as quantidades na tabela de vendas
    SELECT COALESCE(SUM(quantidade), 0) INTO v_total_vendido
    FROM venda_has_produto
    WHERE idproduto = p_idproduto;

    -- Se o produto teve vendas, aplicamos a porcentagem de aumento
    IF v_total_vendido > 0 THEN
        UPDATE produto
        SET preco = preco + (preco * (v_total_vendido / 100.0))
        WHERE idproduto = p_idproduto;
    END IF;
END $$

DELIMITER ;


CALL sp_atualizar_preco_por_demanda(1);