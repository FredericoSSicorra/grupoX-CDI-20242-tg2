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
$data_publicacao = $_POST['publish-date'];
$numero_copias = $_POST['num-copies'];
$id_autor = $_POST['author-id'];
$id_categoria = $_POST['category-id'];

// Inserindo os dados na tabela Livro
try {
    $sql = "INSERT INTO Livro (ID_Livro, Titulo, Data_Publicacao, Numero_Copias, ID_Autor, ID_Categoria)
            VALUES (:id_livro, :titulo, :data_publicacao, :numero_copias, :id_autor, :id_categoria)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_livro' => $id_livro,
        ':titulo' => $titulo,
        ':data_publicacao' => $data_publicacao,
        ':numero_copias' => $numero_copias,
        ':id_autor' => $id_autor,
        ':id_categoria' => $id_categoria,
    ]);

    echo "Dados do livro inseridos com sucesso!";
} catch (Exception $e) {
    echo "Erro ao inserir os dados do livro: " . $e->getMessage();
}
?>
