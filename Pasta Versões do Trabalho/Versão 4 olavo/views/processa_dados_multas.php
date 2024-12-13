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
$id_multa = $_POST['mult-id'];
$valor = $_POST['mult-value'];
$data_multa = $_POST['mult-date'];
$id_emprestimo = $_POST['emp-id-mult'];

// Inserindo os dados na tabela Multa
try {
    $sql = "INSERT INTO Multa (ID_Multa, Valor, Data_Multa, ID_Emprestimo)
            VALUES (:id_multa, :valor, :data_multa, :id_emprestimo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_multa' => $id_multa,
        ':valor' => $valor,
        ':data_multa' => $data_multa,
        ':id_emprestimo' => $id_emprestimo,
    ]);

    echo "Dados da multa inseridos com sucesso!";
} catch (Exception $e) {
    echo "Erro ao inserir os dados da multa: " . $e->getMessage();
}
?>
