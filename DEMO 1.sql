CREATE DATABASE db_BibliotecaUniversitaria;
USE db_BibliotecaUniversitaria;

CREATE TABLE tbl_Usuarios (
    IdUsuario INT AUTO_INCREMENT,
    Email VARCHAR(100) NOT NULL,
    Telefone VARCHAR(15),
    Endereco VARCHAR(255),
    TipoUsuario ENUM('Aluno', 'Professor', 'Visitante') NOT NULL,
    Nome VARCHAR(100) NOT NULL,
    PRIMARY KEY (IdUsuario)
);

CREATE TABLE tbl_Aluno (
    IdUsuario INT,
    Curso VARCHAR(100),
    Matricula VARCHAR(20) UNIQUE,
    PRIMARY KEY (IdUsuario),
    FOREIGN KEY (IdUsuario) REFERENCES tbl_Usuarios(IdUsuario) ON DELETE CASCADE
);

CREATE TABLE tbl_Professor (
    IdUsuario INT,
    DataContratacao DATE,
    Departamento VARCHAR(100),
    PRIMARY KEY (IdUsuario),
    FOREIGN KEY (IdUsuario) REFERENCES tbl_Usuarios(IdUsuario) ON DELETE CASCADE
);

CREATE TABLE tbl_Visitante (
    IdUsuario INT,
    DataRegistro DATE,
    PRIMARY KEY (IdUsuario),
    FOREIGN KEY (IdUsuario) REFERENCES tbl_Usuarios(IdUsuario) ON DELETE CASCADE
);

CREATE TABLE tbl_Livros (
    IdLivro INT AUTO_INCREMENT,
    Titulo VARCHAR(150) NOT NULL,
    Genero VARCHAR(50),
    DataPublicacao DATE,
    NumeroCopias INT NOT NULL DEFAULT 1,
    PRIMARY KEY (IdLivro)
);

CREATE TABLE tbl_Emprestimos (
    IdEmprestimo INT AUTO_INCREMENT,
    IdUsuario INT,
    IdLivro INT,
    DataEmprestimo DATE NOT NULL,
    DataDevolucao DATE,
    PRIMARY KEY (IdEmprestimo),
    FOREIGN KEY (IdUsuario) REFERENCES tbl_Usuarios(IdUsuario) ON DELETE CASCADE,
    FOREIGN KEY (IdLivro) REFERENCES tbl_Livros(IdLivro) ON DELETE CASCADE
);

CREATE TABLE tbl_Reservas (
    IdReserva INT AUTO_INCREMENT,
    IdUsuario INT,
    IdLivro INT,
    DataReserva DATE NOT NULL,
    PRIMARY KEY (IdReserva),
    FOREIGN KEY (IdUsuario) REFERENCES tbl_Usuarios(IdUsuario) ON DELETE CASCADE,
    FOREIGN KEY (IdLivro) REFERENCES tbl_Livros(IdLivro) ON DELETE CASCADE
);

CREATE TABLE tbl_Multas (
    IdMulta INT AUTO_INCREMENT,
    IdEmprestimo INT,
    Valor DECIMAL(10,2) NOT NULL,
    DataMulta DATE NOT NULL,
    PRIMARY KEY (IdMulta),
    FOREIGN KEY (IdEmprestimo) REFERENCES tbl_Emprestimos(IdEmprestimo) ON DELETE CASCADE
);

-- Inserir registros na tabela Usuários
INSERT INTO tbl_Usuarios (Email, Telefone, Endereco, TipoUsuario, Nome) VALUES
('aluno1@universidade.edu', '51999999999', 'Rua das Flores, 123', 'Aluno', 'João Silva'),
('professor1@universidade.edu', '51988888888', 'Avenida Central, 456', 'Professor', 'Maria Oliveira'),
('visitante1@universidade.edu', '51977777777', 'Rua Nova, 789', 'Visitante', 'Carlos Souza');

-- Inserir registros na tabela Aluno
INSERT INTO tbl_Aluno (IdUsuario, Curso, Matricula) VALUES
(1, 'Engenharia da Computação', '20240001');

-- Inserir registros na tabela Professor
INSERT INTO tbl_Professor (IdUsuario, DataContratacao, Departamento) VALUES
(2, '2015-03-10', 'Departamento de Física');

-- Inserir registros na tabela Visitante
INSERT INTO tbl_Visitante (IdUsuario, DataRegistro) VALUES
(3, '2024-11-01');

-- Inserir registros na tabela Livros
INSERT INTO tbl_Livros (Titulo, Genero, DataPublicacao, NumeroCopias) VALUES
('Programação em Python', 'Informática', '2020-07-15', 5),
('Física para Cientistas e Engenheiros', 'Ciências', '2018-01-20', 3),
('Introdução à Filosofia', 'Filosofia', '2016-09-10', 2);

-- Inserir registros na tabela Empréstimos
INSERT INTO tbl_Emprestimos (IdUsuario, IdLivro, DataEmprestimo, DataDevolucao) VALUES
(1, 1, '2024-11-15', '2024-11-22'),
(2, 2, '2024-11-18', NULL);

-- Inserir registros na tabela Reservas
INSERT INTO tbl_Reservas (IdUsuario, IdLivro, DataReserva) VALUES
(3, 1, '2024-11-20'),
(1, 3, '2024-11-22');

-- Inserir registros na tabela Multas
INSERT INTO tbl_Multas (IdEmprestimo, Valor, DataMulta) VALUES
(1, 5.00, '2024-11-25');

SHOW TABLES;
