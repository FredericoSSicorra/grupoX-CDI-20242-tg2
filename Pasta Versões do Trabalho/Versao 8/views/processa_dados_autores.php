<?php
// Configurações do Banco de Dados
$host = 'localhost';
$dbname = 'db_BibliotecaUFSM01';
$username = 'root';
$password = '';

// Conexão com o Banco de Dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Obtendo os dados do formulário
$id_autor = $_POST['id_autor'];
$nome_autor = $_POST['nome_autor'];
$nacionalidade = $_POST['nacionalidade'];
$data_nascimento = $_POST['data_nascimento'];
$id_editora = $_POST['id_editora'];

// Inserindo os dados na tabela Autor
try {
    $sql = "INSERT INTO Autor (ID_Autor, Nome_Autor, Nacionalidade, Data_Nascimento, ID_Editora)
            VALUES (:id_autor, :nome_autor, :nacionalidade, :data_nascimento, :id_editora)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_autor' => $id_autor,
        ':nome_autor' => $nome_autor,
        ':nacionalidade' => $nacionalidade,
        ':data_nascimento' => $data_nascimento,
        ':id_editora' => $id_editora,
    ]);

    echo "Dados do autor inseridos com sucesso!";
} catch (Exception $e) {
    echo "Erro ao inserir os dados do autor: " . $e->getMessage();
}
?>
