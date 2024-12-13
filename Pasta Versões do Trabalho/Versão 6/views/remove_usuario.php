<?php
// arquivo: remove_usuario.php
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

// Processa a remoção do usuário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = intval($_POST["id_usuario"]);
    $tipo_usuario = $_POST["tipo_usuario"]; // Aluno, Professor ou Visitante

    if ($id_usuario && in_array($tipo_usuario, ["Aluno", "Professor", "Visitante"])) {
        // Delete related records in the reserva table
        $sql_reserva = "DELETE FROM reserva WHERE ID_Usuario = ?";
        $stmt_reserva = $conn->prepare($sql_reserva);
        $stmt_reserva->bind_param("i", $id_usuario);
        $stmt_reserva->execute();
        $stmt_reserva->close();

        // Delete the user
        $sql = "DELETE FROM $tipo_usuario WHERE ID_Usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);

        if ($stmt->execute()) {
            $message = "$tipo_usuario removido com sucesso!";
        } else {
            $message = "Erro ao remover $tipo_usuario: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Por favor, forneça um ID válido e selecione um tipo de usuário.";
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
    <title>Remover Usuário</title>
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
        label, select, input {
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
    <h1>Remover Usuário</h1>
    <form method="POST" action="remove_usuario.php">
        <label for="id_usuario">ID do Usuário:</label>
        <input type="number" name="id_usuario" id="id_usuario" required>

        <label for="tipo_usuario">Tipo de Usuário:</label>
        <select name="tipo_usuario" id="tipo_usuario" required>
            <option value="Aluno">Aluno</option>
            <option value="Professor">Professor</option>
            <option value="Visitante">Visitante</option>
        </select>

        <input type="submit" value="Remover">
    </form>
    <?php if (!empty($message)): ?>
        <div class="message <?= strpos($message, 'Erro') === false ? '' : 'error'; ?>">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
</body>
</html>
