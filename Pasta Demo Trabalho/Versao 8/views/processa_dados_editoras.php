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
$id_editora = $_POST['edit-id'];
$nome_editora = $_POST['edit-name'];

// Inserindo os dados na tabela Editora
try {
    $sql = "INSERT INTO Editora (ID_Editora, Nome_Editora)
            VALUES (:id_editora, :nome_editora)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_editora' => $id_editora,
        ':nome_editora' => $nome_editora,
    ]);

    echo "Dados da editora inseridos com sucesso!";
} catch (Exception $e) {
    echo "Erro ao inserir os dados da editora: " . $e->getMessage();
}
?>
