DROP PROCEDURE IF EXISTS sp_aumento_geral_dez_porcento;

DELIMITER $$

CREATE PROCEDURE sp_aumento_geral_dez_porcento ()
BEGIN
    SET SQL_SAFE_UPDATES = 0;

    -- Aplica o aumento e arredonda para 2 casas decimais
    UPDATE produto
    SET preco = ROUND(preco * 1.10, 2);

    SET SQL_SAFE_UPDATES = 1;
END $$

DELIMITER ;

-- Executa a procedure corrigida
CALL sp_aumento_geral_dez_porcento();

