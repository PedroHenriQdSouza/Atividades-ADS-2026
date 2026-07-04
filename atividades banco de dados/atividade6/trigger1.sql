DELIMITER $$

CREATE TRIGGER trg_impede_reducao_salario
BEFORE UPDATE ON vendedor
FOR EACH ROW
BEGIN
    IF NEW.salario < OLD.salario THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Erro: O novo salário não pode ser menor do que o já cadastrado.';
    END IF;
END $$

DELIMITER ;