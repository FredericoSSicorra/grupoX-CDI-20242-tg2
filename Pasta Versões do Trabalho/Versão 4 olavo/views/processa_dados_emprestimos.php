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
$id_emprestimo = $_POST['emp-id'];
$data_emprestimo = $_POST['emp-date'];
$data_devolucao = $_POST['dev-date'];
$id_livro = $_POST['book-id-emp'];

// Inserindo os dados na tabela Emprestimo
try {
    $sql = "INSERT INTO Emprestimo (ID_Emprestimo, Data_Emprestimo, Data_Devolucao, ID_Livro)
            VALUES (:id_emprestimo, :data_emprestimo, :data_devolucao, :id_livro)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_emprestimo' => $id_emprestimo,
        ':data_emprestimo' => $data_emprestimo,
        ':data_devolucao' => $data_devolucao,
        ':id_livro' => $id_livro,
    ]);

    echo "Dados do emprestimo inseridos com sucesso!";
} catch (Exception $e) {
    echo "Erro ao inserir os dados do emprestimo: " . $e->getMessage();
}
?>
