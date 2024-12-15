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
$id_categoria = $_POST['cat-id'];
$nome_categoria = $_POST['cat-name'];

// Inserindo os dados na tabela Categoria
try {
    $sql = "INSERT INTO Categoria (ID_Categoria, Nome_Categoria)
            VALUES (:id_categoria, :nome_categoria)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_categoria' => $id_categoria,
        ':nome_categoria' => $nome_categoria,
    ]);

    echo "Dados da categoria inseridos com sucesso!";
} catch (Exception $e) {
    echo "Erro ao inserir os dados da categoria: " . $e->getMessage();
}
?>
