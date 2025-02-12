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
    `DISPON_LIV` CHAR(1) NOT NULL,
    `STATUS_LIV` CHAR(20) NOT NULL,
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
    `DEVOLVIDO` varchar(1) DEFAULT "n",
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
  ('Programação, Java', 'd', 'Circulante', 'Java Programming Basics', '2023-02-15', 'C', 'Livraria ABC', 45.50, 'Tecnologia', 'Jane Smith', '2ª', 'Editora Tech', '2019-05-01', 'Programação', 'Desenvolvimento de Sistemas', 'Sem danos'),
  ('Banco de Dados, SQL', 'd', 'Circulante', 'SQL Mastery', '2023-06-01', 'M', 'Editora O', 60.00, 'Tecnologia', 'Maria Garcia', '1ª', 'DB Experts', '2022-08-20', 'Banco de Dados', 'Desenvolvimento de Sistemas', 'Ótima leitura'),
  ('Redes de Computadores', 'i', 'Circulante', 'Networking Essentials', '2022-11-12', 'P', 'Fornecedor Net', 75.00, 'Tecnologia', 'Carlos Neves', '3ª', 'Network Press', '2020-09-10', 'Redes', 'Redes de Computadores', NULL),
  ('Matemática, Cálculo', 'd', 'Circulante', 'Cálculo Diferencial', '2021-10-05', 'C', 'Livros & Cia', 50.90, 'Educação', 'Paulo Silva', '2ª', 'Matemática para Todos', '2018-03-15', 'Matemática', 'Engenharia', NULL),
  ('História, Idade Média', 'd', 'Circulante', 'A Idade Média', '2022-03-20', 'M', 'Livraria Clássica', 35.00, 'História', 'João Freitas', '1ª', 'Histórias Reais', '2007-07-07', 'História Geral', NULL, 'Envelhecimento natural'),
  ('Literatura, Clássicos', 'd', 'Circulante', 'Dom Quixote', '2023-01-18', 'P', 'Fornecedor Literário', 89.90, 'Literatura', 'Miguel de Cervantes', '4ª', 'Editora Grandes Clássicos', '2015-10-10', 'Clássicos da Literatura', NULL, 'Edição especial'),
  ('Ciência, Física', 'd', 'Circulante', 'Física Moderna', '2023-04-25', 'C', 'TechBooks', 70.00, 'Ciências', 'Albert Gomes', '5ª', 'Física Atual', '2021-12-12', 'Física', 'Física', NULL),
  ('Medicina, Anatomia', 'i', 'Circulante', 'Anatomia Humana', '2022-07-30', 'M', 'Distribuidora Saúde', 150.00, 'Saúde', 'Dr. Ricardo', '3ª', 'Editora Saúde', '2021-01-15', 'Anatomia', 'Medicina', NULL),
  ('Engenharia, Eletrônica', 'd', 'Circulante', 'Eletrônica Básica', '2023-08-10', 'P', 'TecMundo', 40.00, 'Engenharia', 'Carlos Eduardo', '2ª', 'Editora Inovação', '2018-06-10', 'Eletrônica', 'Eletrônica', NULL),
  ('Psicologia, Comportamento', 'd', 'Circulante', 'Comportamento Humano', '2023-05-12', 'P', 'Livraria Central', 60.00, 'Psicologia', 'Ana Paula Costa', '1ª', 'PsicoBooks', '2020-03-08', 'Psicologia', 'Psicologia', NULL),
  ('Marketing, Digital', 'd', 'Circulante', 'Marketing Digital', '2023-09-01', 'P', 'BooksOnline', 95.50, 'Negócios', 'Lucas Santana', '1ª', 'MKT Books', '2022-02-01', 'Marketing', 'Administração', NULL),
  ('Química, Orgânica', 'd', 'Circulante', 'Química Orgânica', '2023-07-22', 'M', 'Editora Ciências', 65.00, 'Ciências', 'Fernanda Moreira', '2ª', 'Editora Acadêmica', '2019-12-11', 'Química', 'Química', NULL),
  ('Filosofia, Antiga', 'd', 'Circulante', 'Os Pensadores', '2021-11-30', 'C', 'Livraria Saber', 35.00, 'Filosofia', 'Aristóteles', '3ª', 'Editora Pensamento', '2010-10-01', 'Filosofia Antiga', NULL, 'Capas levemente desgastadas'),
  ('Programação, C++', 'i', 'Consulta Local', 'Dominando C++', '2022-06-14', 'P', 'Livros & Bits', 50.00, 'Tecnologia', 'Roberto Dias', '1ª', 'Editora Code', '2021-04-15', 'Programação', 'Desenvolvimento de Sistemas', NULL),
  ('Arte, Pintura', 'd', 'Consulta Local', 'História da Pintura', '2021-10-10', 'P', 'Editora Artística', 80.00, 'Arte', 'Luiz Alberto', '2ª', 'Arte Universal', '2018-03-30', 'Arte e Pintura', NULL, 'Com imagens coloridas'),
  ('Educação, Pedagogia', 'd', 'Consulta Local', 'Pedagogia Moderna', '2023-01-25', 'C', 'Distribuidora Escolar', 70.00, 'Educação', 'Cláudia Souza', '4ª', 'Editora Educação', '2020-11-12', 'Pedagogia', 'Pedagogia', NULL),
  ('Ciência, Biologia', 'd', 'i', 'Biologia Celular', '2023-03-17', 'M', 'Editora Ciências', 90.00, 'Ciências', 'Marcos Lima', '3ª', 'Biociências', '2019-09-05', 'Biologia', 'Biologia', NULL),
  ('Administração, Gestão', 'd', 'i', 'Gestão de Projetos', '2023-06-20', 'P', 'BooksAdmin', 85.00, 'Negócios', 'Pedro Silva', '1ª', 'Editora Gestão', '2022-01-01', 'Administração', 'Administração', NULL),
  ('História, Brasil', 'd', 'Circulante', 'História do Brasil', '2021-09-15', 'C', 'História Nacional', 45.00, 'História', 'Jorge Almeida', '2ª', 'Histórias BR', '2017-06-20', 'História do Brasil', 'História', NULL),
  ('Literatura, Romance', 'd', 'i', 'O Morro dos Ventos Uivantes', '2023-05-01', 'M', 'Livraria Romântica', 60.00, 'Literatura', 'Emily Brontë', '5ª', 'Romance Classics', '2020-02-20', 'Romance', NULL, 'Edição comemorativa'),
  ('Programação, Python', 'd', 'i', 'Python Programming', '2021-08-12', 'P', 'Editora X', 59.90, 'Tecnologia', 'John Doe', '1ª', 'Tech Books', '2021-08-01', 'Programação', 'Desenvolvimento de Sistemas', 'i'),
  ('Programação, Python', 'd', 'Circulante', 'Automação com Python', '2023-02-10', 'C', 'Livraria ABC', 45.50, 'Tecnologia', 'João Tech', '2ª', 'CodeHouse', '2022-06-15', NULL, 'Desenvolvimento de Sistemas', NULL),
('Segurança da Informação', 'd', 'Circulante', 'Introdução à Segurança da Informação', '2023-03-12', 'M', 'TechSafe', 60.00, 'Tecnologia', 'Carla Souza', '1ª', 'Seguritech', '2021-11-20', NULL, 'Desenvolvimento de Sistemas', NULL),
('Logística, Gestão de Estoques', 'd', 'Circulante', 'Gestão de Estoques Eficiente', '2023-05-22', 'P', 'Livros Logísticos', 85.00, 'Negócios', 'Carlos Santos', '3ª', 'LogiBooks', '2019-03-15', NULL, 'Logística', 'Novo'),
('Transportes, Cadeia de Suprimentos', 'd', 'Circulante', 'Cadeia de Suprimentos Integrada', '2022-12-15', 'C', 'Distribuidora Global', 95.00, 'Negócios', 'Marta Oliveira', '2ª', 'SupplyChain Books', '2020-07-12', NULL, 'Logística', NULL),
('Metalurgia, Materiais', 'd', 'Consulta Local', 'Metalurgia dos Materiais Avançados', '2022-08-05', 'M', 'MetalBooks', 70.00, 'Engenharia', 'Roberto Lima', '1ª', 'Editora Metal', '2020-01-20', NULL, 'Metalurgia', 'Apenas consulta'),
('Metalurgia, Fundição', 'd', 'Circulante', 'Fundição Moderna', '2023-01-18', 'P', 'Livraria Técnica', 90.00, 'Engenharia', 'Ana Torres', '4ª', 'Tech Metalúrgica', '2019-05-01', NULL, 'Metalurgia', NULL),
('Mecânica, Termodinâmica', 'd', 'Circulante', 'Fundamentos de Termodinâmica', '2023-06-25', 'P', 'Distribuidora Mecânica', 120.00, 'Engenharia', 'Pedro Martins', '5ª', 'Editora Mecânica Atual', '2021-09-10', NULL, 'Mecânica', NULL),
('Máquinas, Mecânica', 'd', 'Consulta Local', 'Máquinas e Mecanismos', '2022-10-10', 'M', 'BooksTech', 75.00, 'Engenharia', 'Lucas Almeida', '3ª', 'TecPress', '2018-11-15', NULL, 'Mecânica', 'Uso restrito'),
('Programação, JavaScript', 'd', 'Circulante', 'JavaScript Avançado', '2023-07-15', 'C', 'Tech Store', 50.00, 'Tecnologia', 'André Souza', '1ª', 'Editora Code', '2021-10-15', NULL, 'Desenvolvimento de Sistemas', NULL),
('Banco de Dados, NoSQL', 'd', 'Circulante', 'Introdução ao MongoDB', '2023-05-10', 'P', 'Editora X', 75.00, 'Tecnologia', 'Lúcia Braga', '1ª', 'DataBooks', '2020-03-01', NULL, 'Desenvolvimento de Sistemas', 'Manual técnico'),
('DevOps, CI/CD', 'd', 'Consulta Local', 'DevOps Prático', '2023-02-18', 'D', 'Doação Empresa XYZ', 0.00, 'Tecnologia', 'Felipe Ramos', '2ª', 'DevBooks', '2019-07-15', NULL, 'Desenvolvimento de Sistemas', 'Obtido por doação'),
('Logística, Sustentável', 'd', 'Circulante', 'Gestão Logística Sustentável', '2023-03-01', 'D', 'ONG Logística Verde', 0.00, 'Negócios', 'Mariana Costa', '1ª', 'EcoBooks', '2020-09-10', NULL, 'Logística', 'Obtido por doação'),
('Transporte, Rodoviário', 'd', 'Circulante', 'Transportes no Brasil', '2023-01-10', 'C', 'Distribuidora Nacional', 80.00, 'Negócios', 'João Almeida', '3ª', 'Transporte Atual', '2018-04-15', NULL, 'Logística', NULL),
('Planejamento, Logístico', 'i', 'Consulta Local', 'Planejamento de Rotas', '2022-08-05', 'M', 'Editora Global', 60.00, 'Negócios', 'Renato Santos', '2ª', 'GeoLogística', '2019-11-30', NULL, 'Logística', 'Comodato com fornecedor'),
('Metalurgia, Soldagem', 'd', 'Circulante', 'Técnicas de Soldagem', '2023-04-15', 'D', 'Doação Associação de Metalurgia', 0.00, 'Engenharia', 'Júlio Tavares', '4ª', 'Metalúrgica Moderna', '2017-01-01', NULL, 'Metalurgia', 'Equipamento adicional no laboratório'),
('Metalurgia, Aços', 'd', 'Circulante', 'Processos em Aços Inoxidáveis', '2022-11-20', 'P', 'Fornecedor SteelBooks', 90.00, 'Engenharia', 'Amanda Soares', '1ª', 'TechSteel', '2020-08-08', NULL, 'Metalurgia', 'Livro técnico importante'),
('Metalurgia, Tratamento', 'i', 'Consulta Local', 'Tratamentos Térmicos', '2021-12-15', 'X', 'Origem desconhecida', 0.00, 'Engenharia', 'Roberto Dias', '3ª', 'Indústria Metalúrgica', '2015-03-20', NULL, 'Metalurgia', 'Envelhecido'),
('Mecânica, Fluidos', 'd', 'Consulta Local', 'Mecânica dos Fluidos', '2023-06-20', 'O', 'Editora Acadêmica', 125.00, 'Engenharia', 'Ana Ribeiro', '1ª', 'BooksPress', '2021-05-10', NULL, 'Mecânica', 'Doação com valor residual'),
('Máquinas, Automação', 'd', 'Circulante', 'Automação Mecânica', '2023-02-10', 'C', 'Livraria Engenheiros', 100.00, 'Engenharia', 'Carlos Souza', '2ª', 'Editora Mecânica', '2020-10-15', NULL, 'Mecânica', 'Estado novo'),
('Motores, Veículos', 'i', 'Consulta Local', 'Motores a Combustão Interna', '2022-07-05', 'M', 'Fornecedor Mecânico', 80.00, 'Engenharia', 'Marcos Oliveira', '5ª', 'TecMecânica', '2018-06-10', NULL, 'Mecânica', 'Obtido por comodato');

  INSERT INTO `bibliotecaria` (`NOME_BIBLIOT`, `CPF_BIBLIOT`, `GEN_BIBLIOT`, `DTNASC_BIBLIOT`, `DTCADASTRO_BIBLIOT`, `EMAIL_BIBLIOT`, `SEN_BIBLIOT`, `TURNO_BIBLIOT`, `FOTO_BIBLIOT`) 
  VALUES
  ('P', '1', 'M', '1111-11-11', '2024-11-07', 'a@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', 'M', 'a26d6a347d9784f5c8a178621708ab2f.jpg'),
  ('Flavia', '10987654321', 'F', '1985-03-12', '2022-05-05', 'maria.sousa@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', 'M', 'foto_maria.jpg');

  INSERT INTO `aluno` (`RA_ALUNO`, `CURSO_ALUNO`, `NOME_ALUNO`, `CPF_ALUNO`, `GEN_ALUNO`, `DTNASC_ALUNO`, `DTCADASTRO_ALUNO`, `EMAIL_ALUNO`, `SEN_ALUNO`, `FOTO_ALUNO`) 
  VALUES
  (11342, 'Desenvolvimento de Sistemas', 'Ana Silva', '12345678910', 'F', '2001-02-15', '2023-02-10', 'ana.silva@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', NULL),
  (83214, 'Eletrônica Automotiva', 'Nicoly Souza', '98765432100', 'F', '1999-08-22', '2024-01-08', 'nicoly.souza@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', NULL),
  (10012, 'Desenvolvimento de Sistemas', 'Carlos Eduardo', '11223344556', 'M', '2000-05-20', '2023-06-15', 'carlos.edu@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', NULL),
  (93124, 'Gestão Empresarial', 'Fernanda Ribeiro', '22334455678', 'F', '1998-11-30', '2022-11-10', 'fernanda.ribeiro@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$dUI0NkdSUjZyNVR4Q2k3MQ$cyMnQjdGMoZzSwORZm0JW5lE+SvhnKcBVQm/2klAwSA', NULL);