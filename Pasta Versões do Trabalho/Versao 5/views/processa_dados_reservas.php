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
$id_reserva = $_POST['res-id'];
$id_usuario = $_POST['user-id-res'];

// Inserindo os dados na tabela Reserva
try {
    $sql = "INSERT INTO Reserva (ID_Reserva, ID_Usuario)
            VALUES (:id_reserva, :id_usuario)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_reserva' => $id_reserva,
        ':id_usuario' => $id_usuario,
    ]);

    echo "Dados da reserva inseridos com sucesso!";
} catch (Exception $e) {
    echo "Erro ao inserir os dados da reserva: " . $e->getMessage();
}
?>
