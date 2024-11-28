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


############################# teste interface demo 01 ##########################################

    
import tkinter as tk
from tkinter import messagebox
from tkinter import ttk
import mysql.connector


# Função para conectar ao banco de dados MariaDB
def conectar():
    return mysql.connector.connect(
        host="localhost",
        user="root",  # Substitua pelo seu nome de usuário do MariaDB
        password="sua_senha",  # Substitua pela sua senha do MariaDB
        database="db_BibliotecaUniversitaria"
    )


# Função para consultar usuários
def consultar_usuario():
    conn = conectar()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM tbl_Usuarios")
    usuarios = cursor.fetchall()
    conn.close()

    # Limpa a tabela antes de exibir os dados
    for i in tree.get_children():
        tree.delete(i)

    # Insere os dados na tabela gráfica
    for usuario in usuarios:
        tree.insert('', 'end', values=usuario)


# Função para atualizar informações de usuário
def atualizar_usuario():
    try:
        id_usuario = int(entry_id_usuario.get())
        nome = entry_nome.get()
        email = entry_email.get()
        telefone = entry_telefone.get()
        endereco = entry_endereco.get()
        tipo_usuario = combo_tipo_usuario.get()

        conn = conectar()
        cursor = conn.cursor()
        query = """
        UPDATE tbl_Usuarios
        SET Nome = %s, Email = %s, Telefone = %s, Endereco = %s, TipoUsuario = %s
        WHERE IdUsuario = %s
        """
        cursor.execute(query, (nome, email, telefone, endereco, tipo_usuario, id_usuario))
        conn.commit()
        conn.close()

        messagebox.showinfo("Sucesso", "Usuário atualizado com sucesso!")
        consultar_usuario()
    except Exception as e:
        messagebox.showerror("Erro", f"Erro ao atualizar o usuário: {e}")

# Configuração da interface gráfica
root = tk.Tk()
root.title("Biblioteca Universitária

    # Frame de entrada de dados
frame_input = tk.Frame(root)
frame_input.pack(pady=10)

label_id_usuario = tk.Label(frame_input, text="ID do Usuário:")
label_id_usuario.grid(row=0, column=0, padx=5, pady=5)
entry_id_usuario = tk.Entry(frame_input)
entry_id_usuario.grid(row=0, column=1, padx=5, pady=5)

label_nome = tk.Label(frame_input, text="Nome:")
label_nome.grid(row=1, column=0, padx=5, pady=5)
entry_nome = tk.Entry(frame_input)
entry_nome.grid(row=1, column=1, padx=5, pady=5)

label_email = tk.Label(frame_input, text="Email:")
label_email.grid(row=2, column=0, padx=5, pady=5)
entry_email = tk.Entry(frame_input)
entry_email.grid(row=2, column=1, padx=5, pady=5)

label_telefone = tk.Label(frame_input, text="Telefone:")
label_telefone.grid(row=3, column=0, padx=5, pady=5)
entry_telefone = tk.Entry(frame_input)
entry_telefone.grid(row=3, column=1, padx=5, pady=5)

label_endereco = tk.Label(frame_input, text="Endereço:")
label_endereco.grid(row=4, column=0, padx=5, pady=5)
entry_endereco = tk.Entry(frame_input)
entry_endereco.grid(row=4, column=1, padx=5, pady=5)

label_tipo_usuario = tk.Label(frame_input, text="Tipo de Usuário:")
label_tipo_usuario.grid(row=5, column=0, padx=5, pady=5)
combo_tipo_usuario = tk.StringVar()
combo_tipo_usuario.set("Aluno")
dropdown_tipo_usuario = tk.OptionMenu(frame_input, combo_tipo_usuario, "Aluno", "Professor", "Visitante")
dropdown_tipo_usuario.grid(row=5, column=1, padx=5, pady=5)

# Botões de ação
button_atualizar = tk.Button(root, text="Atualizar Usuário", command=atualizar_usuario)
button_atualizar.pack(pady=5)

button_excluir = tk.Button(root, text="Excluir Usuário", command=excluir_usuario)
button_excluir.pack(pady=5)

button_consultar = tk.Button(root, text="Consultar Usuários", command=consultar_usuario)
button_consultar.pack(pady=5)

# Tabela para exibição dos usuários
tree_frame = tk.Frame(root)
tree_frame.pack(pady=10)

tree_columns = ("IdUsuario", "Nome", "Email", "Telefone", "Endereco", "TipoUsuario")
tree = ttk.Treeview(tree_frame, columns=tree_columns, show="headings")
for col in tree_columns:
    tree.heading(col, text=col)
    tree.column(col, width=150)
tree.pack()

# Executa a função inicial de consulta para carregar dados na tabela
consultar_usuario()

# Inicia a interface gráfica
root.mainloop()
