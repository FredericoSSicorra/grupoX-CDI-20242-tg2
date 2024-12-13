import tkinter as tk
from tkinter import messagebox
import mysql.connector

# Conectar ao banco de dados MySQL
def connect_db():
    return mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="peterchan",
        database="db_BibliotecaUFSM01"
    )

# Função para inserir dados
def insert_livro():
    titulo = entry_titulo.get()
    id_livro = entry_id.get()
    genero = entry_genero.get()
    data_publicacao = entry_data.get()
    numero_copias = entry_nc.get()

    if titulo and id_livro and genero and data_publicacao and numero_copias:
        try:
            # Verificar se o campo número de cópias é um número inteiro
            numero_copias = int(numero_copias)  # Converter para inteiro
            conn = connect_db()
            cursor = conn.cursor()
            cursor.execute(
                "INSERT INTO Livro (ID_Livro, Titulo, Genero, Data_Publicacao, Numero_Copias) VALUES (%s, %s, %s, %s, %s)",
                (id_livro, titulo, genero, data_publicacao, numero_copias)
            )
            conn.commit()  # Confirmar a inserção
            conn.close()  # Fechar a conexão
            messagebox.showinfo("Sucesso", "Livro inserido com sucesso!")
        except mysql.connector.Error as err:
            # Exibir erro caso haja algum problema na consulta ou conexão
            messagebox.showerror("Erro", f"Erro ao inserir livro: {err}")
        except ValueError:
            # Exibir erro se o número de cópias não for um número válido
            messagebox.showwarning("Erro", "O número de cópias deve ser um número inteiro.")
    else:
        messagebox.showwarning("Erro", "Por favor, preencha todos os campos.")

# Função para listar livros
def listar_livros():
    conn = connect_db()
    cursor = conn.cursor()
    cursor.execute("SELECT * FROM Livro")
    livros = cursor.fetchall()
    conn.close()

    # Limpar o Listbox antes de adicionar novos itens
    listbox_clientes.delete(0, tk.END)

    # Adicionar os livros ao Listbox
    for livro in livros:
        listbox_clientes.insert(tk.END, f"ID: {livro[0]} - Título: {livro[1]} - Gênero: {livro[2]} - Data: {livro[3]} - Cópias: {livro[4]}")

# Configuração da interface gráfica
root = tk.Tk()
root.title("Sistema da Biblioteca")

tk.Label(root, text="ID").pack()
entry_id = tk.Entry(root)
entry_id.pack()

# Campos para inserir dados
tk.Label(root, text="Título").pack()
entry_titulo = tk.Entry(root)
entry_titulo.pack()

tk.Label(root, text="Gênero").pack()
entry_genero = tk.Entry(root)
entry_genero.pack()

tk.Label(root, text="Data de Publicação").pack()
entry_data = tk.Entry(root)
entry_data.pack()

tk.Label(root, text="Número de Cópias").pack()
entry_nc = tk.Entry(root)
entry_nc.pack()

# Botão para inserir livro
button_insert = tk.Button(root, text="Inserir Livro", command=insert_livro)
button_insert.pack()

# Botão para listar livros
button_listar = tk.Button(root, text="Listar Livros", command=listar_livros)
button_listar.pack()

# Lista para exibir livros
listbox_clientes = tk.Listbox(root, width=100, height=20)
listbox_clientes.pack()

root.mainloop()
