<?php
// Configurações do banco de dados
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "db_bibliotecaufsm01";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $database);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta SQL para obter os dados da tabela Editora
$sql = "SELECT ID_Editora, Nome_Editora FROM Editora";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Editoras</title>
    <link rel="stylesheet" href="stylelista.css">
</head>
<body>
    <h1>Lista de Editoras</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exibe os dados se existirem resultados
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID_Editora"] . "</td>";
                    echo "<td>" . $row["Nome_Editora"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Nenhuma editora encontrada</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
