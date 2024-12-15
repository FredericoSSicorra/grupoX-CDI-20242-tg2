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
    Data_Publicacao DATE,
    Numero_Copias INT,
    ID_Autor INT,
    ID_Categoria INT,
    FOREIGN KEY (ID_Autor) REFERENCES Autor(ID_Autor),
    FOREIGN KEY (ID_Categoria) REFERENCES Categoria(ID_Categoria)
);

CREATE TABLE Autor (
    ID_Autor INT PRIMARY KEY,
    Nome_Autor VARCHAR(255),
    Nacionalidade VARCHAR(255),
    Data_Nascimento DATE,
    ID_Editora INT,
    FOREIGN KEY (ID_Editora) REFERENCES Editora(ID_Editora)
);

CREATE TABLE Editora (
    ID_Editora INT PRIMARY KEY,
    Nome_Editora VARCHAR(255)
);

CREATE TABLE Reserva (
    ID_Reserva INT PRIMARY KEY,
    ID_Usuario INT,
    ID_Livro INT,
    FOREIGN KEY (ID_Usuario) REFERENCES Aluno(ID_Usuario),
    FOREIGN KEY (ID_Livro) REFERENCES Livro(ID_Livro)
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


CREATE VIEW vw_total_livros_por_autor AS
SELECT 
    a.Nome_Autor,
    COUNT(l.ID_Livro) AS Total_Livros
FROM 
    Autor a
JOIN 
    Livro l ON a.ID_Autor = l.ID_Autor
GROUP BY 
    a.Nome_Autor;

CREATE VIEW vw_emprestimos_por_mes AS
SELECT 
    MONTH(e.Data_Emprestimo) AS Mes,
    COUNT(e.ID_Emprestimo) AS Total_Emprestimos
FROM 
    Emprestimo e
GROUP BY 
    MONTH(e.Data_Emprestimo);
