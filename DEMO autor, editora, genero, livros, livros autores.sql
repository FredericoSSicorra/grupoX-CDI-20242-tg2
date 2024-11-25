CREATE DATABASE db_BibliotecaUFSM;
SHOW databases;
USE db_BibliotecaUFSM;
SELECT DATABASE();

#Criar Tabela de Autores
CREATE TABLE tbl_Autores (
IdAutor SMALLINT AUTO_INCREMENT,
NomeAutor VARCHAR(50) NOT NULL,
SobrenomeAutor VARCHAR(60) NOT NULL,
CONSTRAINT pk_id_autor PRIMARY KEY (IdAutor) 
);

DESCRIBE tbl_autores;

#Criar Tabela de Editoras
CREATE TABLE tbl_Editora(
IdEditora SMALLINT PRIMARY KEY AUTO_INCREMENT,
NomeEditora VARCHAR(50) NOT NULL
);

DESCRIBE tbl_editora;

#Criar Tabela de Gênero
CREATE TABLE tbl_Genero(
idGenero Tinyint AUTO_INCREMENT,
Genero VARCHAR(30) NOT NULL,
CONSTRAINT pk_id_genero PRIMARY KEY (IdGenero)
);

DESCRIBE tbl_genero;

#Criar Tabela Livros
CREATE TABLE tbl_Livros(
IdLivro SMALLINT NOT NULL AUTO_INCREMENT,
NomeLivro VARCHAR(70) NOT NULL,
ISBN13 VARCHAR(13) NOT NULL,
DataPub DATE,
PrecoLivro DECIMAL(10,2) NOT NULL,
NumeroPaginas SMALLINT NOT NULL,
IdEditora SMALLINT NOT NULL,
IdGenero Tinyint NOT NULL,
#Relacionamentos das tabelas
CONSTRAINT pk_id_livro PRIMARY KEY (idLivro),
CONSTRAINT fk_id_editora FOREIGN KEY (IdEditora) REFERENCES tbl_Editora (IdEditora) ON DELETE CASCADE, #Se eu excluir uma editora, exclui o livro também
CONSTRAINT fk_id_genero FOREIGN KEY (IdGenero) REFERENCES tbl_Genero (IdGenero) ON DELETE CASCADE
);

DESCRIBE tbl_livros;

#Criar Tabela LivrosAutores um livro vários autores, um autor vários livros
CREATE TABLE tbl_LivrosAutores (
IdLivro SMALLINT NOT NULL,
IdAutor SMALLINT NOT NULL,
#Relacionamento 
CONSTRAINT pk_id_livro_autor PRIMARY KEY (IdLivro, IdAutor),
CONSTRAINT fk_id_livros FOREIGN KEY (IdLivro) REFERENCES tbl_Livros (IdLivro),
CONSTRAINT fk_id_autores FOREIGN KEY (IdAutor) REFERENCES tbl_Autores (IdAutor)
);

#Criar Tabela Emprestimo
CREATE TABLE Tbl_Emprestimo (
IdEmprestimo TINYINT PRIMARY KEY,
NomeLivro VARCHAR(60) NOT NULL,
NomeEmprestador VARCHAR (50) NOT NULL,
DataEmprestimo DATE NOT NULL,
Duracao TINYINT NOT NULL
);

ALTER TABLE tbl_livros
ADD Edicao TINYINT;

DESCRIBE tbl_livros;
ALTER TABLE tbl_livros;
DROP COLUMN Edicao;

ALTER TABLE tbl_Emprestimo
MODIFY COLUMN IdEmprestimo SMALLINT;

ALTER TABLE tbl_Livros AUTO_INCREMENT=100;

DESCRIBE tbl_livros;

SHOW TABLES;



