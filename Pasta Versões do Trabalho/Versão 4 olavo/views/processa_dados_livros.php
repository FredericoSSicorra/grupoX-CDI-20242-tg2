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
$id_livro = $_POST['book-id'];
$titulo = $_POST['book-title'];
$genero = $_POST['book-genre'];
$data_publicacao = $_POST['publish-date'];
$numero_copias = $_POST['num-copies'];

// Inserindo os dados na tabela Livro
try {
    $sql = "INSERT INTO Livro (ID_Livro, Titulo, Genero, Data_Publicacao, Numero_Copias)
            VALUES (:id_livro, :titulo, :genero, :data_publicacao, :numero_copias)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_livro' => $id_livro,
        ':titulo' => $titulo,
        ':genero' => $genero,
        ':data_publicacao' => $data_publicacao,
        ':numero_copias' => $numero_copias,
    ]);

    echo "Dados do livro inseridos com sucesso!";
} catch (Exception $e) {
    echo "Erro ao inserir os dados do livro: " . $e->getMessage();
}
?>
