
use mercado_phs;

CREATE TABLE vendedor (
  idvendedor INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  salario DECIMAL(10,2) NOT NULL
);

CREATE TABLE Vendedores_desligados (
  idvendedor INT,
  nome VARCHAR(100),
  salario DECIMAL(10,2),
  data_exclusao DATETIME DEFAULT CURRENT_TIMESTAMP
);