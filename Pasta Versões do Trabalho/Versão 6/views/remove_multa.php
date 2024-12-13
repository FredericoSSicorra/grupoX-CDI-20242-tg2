<?php
// arquivo: remove_multa.php
// Configurações de conexão ao banco de dados
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "db_bibliotecaufsm01";

// Conecta ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Mensagem de status
$message = "";

// Processa a remoção do multa
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_multa = intval($_POST["id_multa"]);

    if ($id_multa) {
        $sql = "DELETE FROM multa WHERE ID_multa = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_multa);

        if ($stmt->execute()) {
            $message = "multa removido com sucesso!";
        } else {
            $message = "Erro ao remover multa: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Por favor, forneça um ID válido.";
    }
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remover multa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label, input {
            display: block;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin: 20px auto;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Remover multa</h1>
    <form method="POST" action="remove_multa.php">
        <label for="id_multa">ID do multa:</label>
        <input type="number" name="id_multa" id="id_multa" required>
        <input type="submit" value="Remover">
    </form>
    <?php if (!empty($message)): ?>
        <div class="message <?= strpos($message, 'Erro') === false ? '' : 'error'; ?>">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
</body>
</html>
