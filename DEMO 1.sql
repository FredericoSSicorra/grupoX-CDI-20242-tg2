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

SHOW TABLES;
