DELIMITER $$

CREATE TRIGGER trg_salva_vendedor_desligado
AFTER DELETE ON vendedor
FOR EACH ROW
BEGIN
    INSERT INTO Vendedores_desligados (idvendedor, nome, salario)
    VALUES (OLD.idvendedor, OLD.nome, OLD.salario);
END $$

DELIMITER ;