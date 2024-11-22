-- /*
-- *   @author Camila Inocencio e Matheus Cuero
-- *   @version 2.0    
-- *   @file index.php
-- *   @description Banco de Dados
-- */


DROP DATABASE IF EXISTS banco_livro;
CREATE DATABASE banco_livro;
USE banco_livro;

CREATE TABLE `aluno` (
  `ID_ALUNO` INT NOT NULL AUTO_INCREMENT,
  `RA_ALUNO` INT NOT NULL,
  `CURSO_ALUNO` VARCHAR(50) NOT NULL,
  `NOME_ALUNO` VARCHAR(70) NOT NULL,
  `CPF_ALUNO` VARCHAR(11) NOT NULL UNIQUE,
  `GEN_ALUNO` CHAR(20) NOT NULL,
  `DTNASC_ALUNO` DATE NOT NULL,
  `DTCADASTRO_ALUNO` DATE NOT NULL DEFAULT CURRENT_DATE,
  `EMAIL_ALUNO` VARCHAR(120) NOT NULL UNIQUE,
  `SEN_ALUNO` VARCHAR(200) NOT NULL,
  `FOTO_ALUNO` VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (`ID_ALUNO`),
  UNIQUE (`ID_ALUNO`, `RA_ALUNO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `administrador` (
  `ID_ADMIN` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `NOME_ADMIN` VARCHAR(120) NOT NULL,
  `SEN_ADMIN` VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `bibliotecaria` (
  `ID_BIBLIOT` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `NOME_BIBLIOT` VARCHAR(70) NOT NULL,
  `CPF_BIBLIOT` VARCHAR(11) NOT NULL UNIQUE,
  `GEN_BIBLIOT` CHAR(1) NOT NULL,
  `DTNASC_BIBLIOT` DATE NOT NULL,
  `DTCADASTRO_BIBLIOT` DATE NOT NULL DEFAULT CURRENT_DATE,
  `EMAIL_BIBLIOT` VARCHAR(120) NOT NULL UNIQUE,
  `SEN_BIBLIOT` VARCHAR(200) NOT NULL,
  `TURNO_BIBLIOT` CHAR(1) NOT NULL,
  `FOTO_BIBLIOT` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `livro` (
  `TOMBO_LIV` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `PALAVCHAVE_LIV` VARCHAR(255) NOT NULL,
  `DISPON_LIV` CHAR(20) NOT NULL,
  `STATUS_LIV` CHAR(10) NOT NULL,
  `TITULO_LIV` VARCHAR(50) NOT NULL,
  `DTAQUISICAO_LIV` DATE NOT NULL,
  `TPAQUISICAO_LIV` CHAR(1) NOT NULL,
  `FORNECEDOR_LIV` VARCHAR(50) NOT NULL,
  `VALOR_LIV` DECIMAL(6,2) NOT NULL,
  `GENERO_LIV` VARCHAR(30) NOT NULL,
  `AUTOR_LIV` VARCHAR(70) NOT NULL,
  `EDICAO_LIV` VARCHAR(20) NOT NULL,
  `EDITORA_LIV` VARCHAR(50) NOT NULL,
  `DTLANCAM_LIV` DATE NOT NULL,
  `COMPLEM_LIV` VARCHAR(100) DEFAULT NULL,
  `CURSO_LIV` VARCHAR(50) DEFAULT NULL,
  `OBS_LIV` VARCHAR(100) DEFAULT NULL,
  `FOTO_LIV` VARCHAR(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `emprestimos` (
  `ID_EMPREST` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `FK_ID_ALUNO` INT NOT NULL, 
  `FK_RA_ALUNO` INT NOT NULL,
  `FK_ID_BIBLIOT` INT NOT NULL,
  `FK_TOMBO_LIV` INT NOT NULL,
  `DT_EMPREST` DATETIME NOT NULL,
  `DT_DEVOLUCAO` DATETIME NOT NULL,
  FOREIGN KEY (`FK_ID_ALUNO`, `FK_RA_ALUNO`) REFERENCES `aluno` (`ID_ALUNO`, `RA_ALUNO`),
  FOREIGN KEY (`FK_TOMBO_LIV`) REFERENCES `livro` (`TOMBO_LIV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `devolucao` (
  `ID_DEVOLUCAO` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `ID_EMPREST` INT NOT NULL,
  `DT_DEVOL` DATETIME NOT NULL,
  `PENALIDADE_DEVOL` CHAR(1) NOT NULL,
  `SUSPENSAO_DEVOL` INT NOT NULL DEFAULT 0,
  `RESERVAR_DEVOL` BIT(1) NOT NULL,
  `RENOVAR_DEVOL` BIT(1) NOT NULL,
  `OBS_DEVOL` VARCHAR(100) DEFAULT NULL,
  FOREIGN KEY (`ID_EMPREST`) REFERENCES `emprestimos` (`ID_EMPREST`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `fila` (
  `ID_FILA` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `TOMBO_LIV` INT NOT NULL,
  `ID_ALUNO` INT NOT NULL,
  `QUANT_ALUNO` INT NOT NULL,
  `POSICAO_ALUNO` INT NOT NULL,
  `DT_RESERVA` DATE NOT NULL,
  `DT_EXPIRACAO` DATE NOT NULL,
  FOREIGN KEY (`TOMBO_LIV`) REFERENCES `livro` (`TOMBO_LIV`),
  FOREIGN KEY (`ID_ALUNO`) REFERENCES `aluno` (`ID_ALUNO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `renovacao` (
  `ID_RENOVACAO` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `ID_ALUNO` INT NOT NULL,
  `ID_EMPREST` INT NOT NULL,
  `DT_RENOVACAO` DATE NOT NULL,
  FOREIGN KEY (`ID_ALUNO`) REFERENCES `aluno` (`ID_ALUNO`),
  FOREIGN KEY (`ID_EMPREST`) REFERENCES `emprestimos` (`ID_EMPREST`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `administrador` (NOME_ADMIN, SEN_ADMIN) VALUES 
('roberto', '123');


INSERT INTO `livro` (`PALAVCHAVE_LIV`, `DISPON_LIV`, `STATUS_LIV`, `TITULO_LIV`, `DTAQUISICAO_LIV`, `TPAQUISICAO_LIV`, `FORNECEDOR_LIV`, `VALOR_LIV`, `GENERO_LIV`, `AUTOR_LIV`, `EDICAO_LIV`, `EDITORA_LIV`, `DTLANCAM_LIV`, `COMPLEM_LIV`, `CURSO_LIV`, `OBS_LIV`) 
VALUES
('Programação, Java', 'Disponível', 'Usado', 'Java Programming Basics', '2023-02-15', 'C', 'Livraria ABC', 45.50, 'Tecnologia', 'Jane Smith', '2ª', 'Editora Tech', '2019-05-01', 'Programação', 'Desenvolvimento de Sistemas', 'Sem danos'),
('Banco de Dados, SQL', 'Disponível', 'Novo', 'SQL Mastery', '2023-06-01', 'B', 'Editora Z', 60.00, 'Tecnologia', 'Maria Garcia', '1ª', 'DB Experts', '2022-08-20', 'Banco de Dados', 'Desenvolvimento de Sistemas', 'Ótima leitura'),
('Redes de Computadores', 'Indisponível', 'Novo', 'Networking Essentials', '2022-11-12', 'A', 'Fornecedor Net', 75.00, 'Tecnologia', 'Carlos Neves', '3ª', 'Network Press', '2020-09-10', 'Redes', 'Redes de Computadores', NULL),
('Matemática, Cálculo', 'Disponível', 'Novo', 'Cálculo Diferencial', '2021-10-05', 'C', 'Livros & Cia', 50.90, 'Educação', 'Paulo Silva', '2ª', 'Matemática para Todos', '2018-03-15', 'Matemática', 'Engenharia', NULL),
('História, Idade Média', 'Disponível', 'Usado', 'A Idade Média', '2022-03-20', 'B', 'Livraria Clássica', 35.00, 'História', 'João Freitas', '1ª', 'Histórias Reais', '2007-07-07', 'História Geral', NULL, 'Envelhecimento natural'),
('Literatura, Clássicos', 'Disponível', 'Novo', 'Dom Quixote', '2023-01-18', 'A', 'Fornecedor Literário', 89.90, 'Literatura', 'Miguel de Cervantes', '4ª', 'Editora Grandes Clássicos', '2015-10-10', 'Clássicos da Literatura', NULL, 'Edição especial'),
('Ciência, Física', 'Disponível', 'Novo', 'Física Moderna', '2023-04-25', 'C', 'TechBooks', 70.00, 'Ciências', 'Albert Gomes', '5ª', 'Física Atual', '2021-12-12', 'Física', 'Física', NULL),
('Medicina, Anatomia', 'Indisponível', 'Novo', 'Anatomia Humana', '2022-07-30', 'B', 'Distribuidora Saúde', 150.00, 'Saúde', 'Dr. Ricardo', '3ª', 'Editora Saúde', '2021-01-15', 'Anatomia', 'Medicina', NULL),
('Engenharia, Eletrônica', 'Disponível', 'Novo', 'Eletrônica Básica', '2023-08-10', 'A', 'TecMundo', 40.00, 'Engenharia', 'Carlos Eduardo', '2ª', 'Editora Inovação', '2018-06-10', 'Eletrônica', 'Eletrônica', NULL),
('Psicologia, Comportamento', 'Disponível', 'Novo', 'Comportamento Humano', '2023-05-12', 'A', 'Livraria Central', 60.00, 'Psicologia', 'Ana Paula Costa', '1ª', 'PsicoBooks', '2020-03-08', 'Psicologia', 'Psicologia', NULL),
('Marketing, Digital', 'Disponível', 'Novo', 'Marketing Digital', '2023-09-01', 'A', 'BooksOnline', 95.50, 'Negócios', 'Lucas Santana', '1ª', 'MKT Books', '2022-02-01', 'Marketing', 'Administração', NULL),
('Química, Orgânica', 'Disponível', 'Novo', 'Química Orgânica', '2023-07-22', 'B', 'Editora Ciências', 65.00, 'Ciências', 'Fernanda Moreira', '2ª', 'Editora Acadêmica', '2019-12-11', 'Química', 'Química', NULL),
('Filosofia, Antiga', 'Disponível', 'Usado', 'Os Pensadores', '2021-11-30', 'C', 'Livraria Saber', 35.00, 'Filosofia', 'Aristóteles', '3ª', 'Editora Pensamento', '2010-10-01', 'Filosofia Antiga', NULL, 'Capas levemente desgastadas'),
('Programação, C++', 'Indisponível', 'Novo', 'Dominando C++', '2022-06-14', 'A', 'Livros & Bits', 50.00, 'Tecnologia', 'Roberto Dias', '1ª', 'Editora Code', '2021-04-15', 'Programação', 'Desenvolvimento de Sistemas', NULL),
('Arte, Pintura', 'Disponível', 'Novo', 'História da Pintura', '2021-10-10', 'A', 'Editora Artística', 80.00, 'Arte', 'Luiz Alberto', '2ª', 'Arte Universal', '2018-03-30', 'Arte e Pintura', NULL, 'Com imagens coloridas'),
('Educação, Pedagogia', 'Disponível', 'Novo', 'Pedagogia Moderna', '2023-01-25', 'C', 'Distribuidora Escolar', 70.00, 'Educação', 'Cláudia Souza', '4ª', 'Editora Educação', '2020-11-12', 'Pedagogia', 'Pedagogia', NULL),
('Ciência, Biologia', 'Disponível', 'Novo', 'Biologia Celular', '2023-03-17', 'B', 'Editora Ciências', 90.00, 'Ciências', 'Marcos Lima', '3ª', 'Biociências', '2019-09-05', 'Biologia', 'Biologia', NULL),
('Administração, Gestão', 'Disponível', 'Novo', 'Gestão de Projetos', '2023-06-20', 'A', 'BooksAdmin', 85.00, 'Negócios', 'Pedro Silva', '1ª', 'Editora Gestão', '2022-01-01', 'Administração', 'Administração', NULL),
('História, Brasil', 'Disponível', 'Usado', 'História do Brasil', '2021-09-15', 'C', 'História Nacional', 45.00, 'História', 'Jorge Almeida', '2ª', 'Histórias BR', '2017-06-20', 'História do Brasil', 'História', NULL),
('Literatura, Romance', 'Disponível', 'Novo', 'O Morro dos Ventos Uivantes', '2023-05-01', 'B', 'Livraria Romântica', 60.00, 'Literatura', 'Emily Brontë', '5ª', 'Romance Classics', '2020-02-20', 'Romance', NULL, 'Edição comemorativa'),
('Programação, Python', 'Disponível', 'Novo', 'Python Programming', '2021-08-12', 'A', 'Editora X', 59.90, 'Tecnologia', 'John Doe', '1ª', 'Tech Books', '2021-08-01', 'Programação', 'Desenvolvimento de Sistemas', 'Novo');

INSERT INTO `bibliotecaria` (`NOME_BIBLIOT`, `CPF_BIBLIOT`, `GEN_BIBLIOT`, `DTNASC_BIBLIOT`, `DTCADASTRO_BIBLIOT`, `EMAIL_BIBLIOT`, `SEN_BIBLIOT`, `TURNO_BIBLIOT`, `FOTO_BIBLIOT`) 
VALUES
('a', '1', 'M', '1111-11-11', '2024-11-07', 'a@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', 'M', 'a26d6a347d9784f5c8a178621708ab2f.jpg'),
('Flavia', '10987654321', 'F', '1985-03-12', '2022-05-05', 'maria.sousa@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', 'M', 'foto_maria.jpg');

INSERT INTO `aluno` (`RA_ALUNO`, `CURSO_ALUNO`, `NOME_ALUNO`, `CPF_ALUNO`, `GEN_ALUNO`, `DTNASC_ALUNO`, `DTCADASTRO_ALUNO`, `EMAIL_ALUNO`, `SEN_ALUNO`, `FOTO_ALUNO`) 
VALUES
(11342, 'Desenvolvimento de Sistemas', 'Ana Silva', '12345678910', 'F', '2001-02-15', '2023-02-10', 'ana.silva@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', NULL),
(83214, 'Eletrônica Automotiva', 'Nicoly Souza', '98765432100', 'F', '1999-08-22', '2024-01-08', 'nicoly.souza@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', NULL),
(10012, 'Desenvolvimento de Sistemas', 'Carlos Eduardo', '11223344556', 'M', '2000-05-20', '2023-06-15', 'carlos.edu@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', NULL),
(93124, 'Gestão Empresarial', 'Fernanda Ribeiro', '22334455678', 'F', '1998-11-30', '2022-11-10', 'fernanda.ribeiro@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', NULL);

INSERT INTO `emprestimos` (`FK_ID_ALUNO`, `FK_RA_ALUNO`, `FK_ID_BIBLIOT`, `FK_TOMBO_LIV`, `DT_EMPREST`, `DT_DEVOLUCAO`) 
VALUES 
(1, 11342, 1, 1, '2024-01-10 09:30:00', '2024-01-17 09:30:00'),
(2, 83214, 1, 1, '2024-01-15 10:00:00', '2024-01-22 10:00:00');

INSERT INTO `devolucao` (`ID_EMPREST`, `DT_DEVOL`, `PENALIDADE_DEVOL`, `SUSPENSAO_DEVOL`, `RESERVAR_DEVOL`, `RENOVAR_DEVOL`, `OBS_DEVOL`) 
VALUES 
(1, '2024-01-18 10:00:00', 'N', 0, 1, 0, 'Devolução sem penalidades');

INSERT INTO `fila` (`TOMBO_LIV`, `ID_ALUNO`, `QUANT_ALUNO`, `POSICAO_ALUNO`, `DT_RESERVA`, `DT_EXPIRACAO`) 
VALUES 
(1, 1, 3, 1, '2024-01-05', '2024-01-15');

INSERT INTO `renovacao` (`ID_ALUNO`, `ID_EMPREST`, `DT_RENOVACAO`) 
VALUES 
(1, 1, '2024-01-12');



USE banco_livro;

-- 1
SELECT * FROM aluno;

-- 2
SELECT * FROM bibliotecaria WHERE TURNO_BIBLIOT = 'M';

-- 3
SELECT TITULO_LIV, AUTOR_LIV, EDITORA_LIV FROM livro WHERE DISPON_LIV = 'Disponível';

-- 4
SELECT NOME_ALUNO, DT_EMPREST, DT_DEVOLUCAO FROM emprestimos INNER JOIN aluno ON emprestimos.FK_ID_ALUNO = aluno.ID_ALUNO;

-- 5
SELECT ID_EMPREST, PENALIDADE_DEVOL FROM devolucao WHERE SUSPENSAO_DEVOL > 0;