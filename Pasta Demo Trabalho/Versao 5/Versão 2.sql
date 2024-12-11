CREATE DATABASE db_BibliotecaUFSM01;
SHOW databases;
USE db_BibliotecaUFSM01;
SELECT DATABASE();

CREATE TABLE Aluno (
    ID_Usuario INT PRIMARY KEY,
    Curso VARCHAR(255),
    Matricula VARCHAR(50),
    Email VARCHAR(255),
    Telefone VARCHAR(20),
    Endereco VARCHAR(255),
    Nome VARCHAR(255)
);

CREATE TABLE Professor (
    ID_Usuario INT PRIMARY KEY,
    Departamento VARCHAR(255),
    Data_Contratacao DATE,
    Email VARCHAR(255),
    Telefone VARCHAR(20),
    Endereco VARCHAR(255),
    Nome VARCHAR(255)
);

CREATE TABLE Visitante (
    ID_Usuario INT PRIMARY KEY,
    Data_Registro DATE,
    Email VARCHAR(255),
    Telefone VARCHAR(20),
    Endereco VARCHAR(255),
    Nome VARCHAR(255)
);

CREATE TABLE Categoria (
    ID_Categoria INT PRIMARY KEY,
    Nome_Categoria VARCHAR(255)
);

CREATE TABLE Livro (
    ID_Livro INT PRIMARY KEY,
    Titulo VARCHAR(255),
    Genero VARCHAR(255),
    Data_Publicacao DATE,
    Numero_Copias INT
);

CREATE TABLE Autor (
    ID_Autor INT PRIMARY KEY,
    Nome_Autor VARCHAR(255),
    Nacionalidade VARCHAR(255),
    Data_Nascimento DATE
);

CREATE TABLE Editora (
    ID_Editora INT PRIMARY KEY,
    Nome_Editora VARCHAR(255)
);

CREATE TABLE Reserva (
    ID_Reserva INT PRIMARY KEY,
    ID_Usuario INT,
    FOREIGN KEY (ID_Usuario) REFERENCES Aluno(ID_Usuario)
);

CREATE TABLE Emprestimo (
    ID_Emprestimo INT PRIMARY KEY,
    Data_Emprestimo DATE,
    Data_Devolucao DATE,
    ID_Livro INT,
    FOREIGN KEY (ID_Livro) REFERENCES Livro(ID_Livro)
);

CREATE TABLE Multa (
    ID_Multa INT PRIMARY KEY,
    Valor DECIMAL(10,2),
    Data_Multa DATE,
    ID_Emprestimo INT,
    FOREIGN KEY (ID_Emprestimo) REFERENCES Emprestimo(ID_Emprestimo)
);

CREATE TABLE Multa_Emprestimo (
    ID_Multa INT,
    ID_Emprestimo INT,
    PRIMARY KEY (ID_Multa, ID_Emprestimo),
    FOREIGN KEY (ID_Multa) REFERENCES Multa(ID_Multa),
    FOREIGN KEY (ID_Emprestimo) REFERENCES Emprestimo(ID_Emprestimo)
);

CREATE TABLE Reserva_Livro (
    ID_Reserva INT,
    ID_Livro INT,
    PRIMARY KEY (ID_Reserva, ID_Livro),
    FOREIGN KEY (ID_Reserva) REFERENCES Reserva(ID_Reserva),
    FOREIGN KEY (ID_Livro) REFERENCES Livro(ID_Livro)
);

CREATE TABLE Livro_Emprestimo (
    ID_Livro INT,
    ID_Emprestimo INT,
    PRIMARY KEY (ID_Livro, ID_Emprestimo),
    FOREIGN KEY (ID_Livro) REFERENCES Livro(ID_Livro),
    FOREIGN KEY (ID_Emprestimo) REFERENCES Emprestimo(ID_Emprestimo)
);

CREATE TABLE Editora_Livro (
    ID_Editora INT,
    ID_Livro INT,
    PRIMARY KEY (ID_Editora, ID_Livro),
    FOREIGN KEY (ID_Editora) REFERENCES Editora(ID_Editora),
    FOREIGN KEY (ID_Livro) REFERENCES Livro(ID_Livro)
);

CREATE TABLE Editora_Autor (
    ID_Editora INT,
    ID_Autor INT,
    PRIMARY KEY (ID_Editora, ID_Autor),
    FOREIGN KEY (ID_Editora) REFERENCES Editora(ID_Editora),
    FOREIGN KEY (ID_Autor) REFERENCES Autor(ID_Autor)
);

CREATE TABLE Escreve (
    ID_Autor INT,
    ID_Livro INT,
    PRIMARY KEY (ID_Autor, ID_Livro),
    FOREIGN KEY (ID_Autor) REFERENCES Autor(ID_Autor),
    FOREIGN KEY (ID_Livro) REFERENCES Livro(ID_Livro)
);

CREATE TABLE Pertence (
    ID_Categoria INT,
    ID_Livro INT,
    PRIMARY KEY (ID_Categoria, ID_Livro),
    FOREIGN KEY (ID_Categoria) REFERENCES Categoria(ID_Categoria),
    FOREIGN KEY (ID_Livro) REFERENCES Livro(ID_Livro)
);
