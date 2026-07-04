DELIMITER $$

CREATE TRIGGER trg_valida_salario_inicial
BEFORE INSERT ON vendedor
FOR EACH ROW
BEGIN
    IF NEW.salario < 1200.00 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Erro: O salário inicial do vendedor não pode ser menor que R$ 1200,00.';
    END IF;
END $$

DELIMITER ;