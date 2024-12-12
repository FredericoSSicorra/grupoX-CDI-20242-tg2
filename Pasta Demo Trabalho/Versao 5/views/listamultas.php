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

// Consulta SQL para obter os dados da tabela Multa
$sql = "SELECT Multa.ID_Multa, Multa.Valor, Multa.Data_Multa, 
               Multa.ID_Emprestimo, Emprestimo.Data_Emprestimo, Emprestimo.Data_Devolucao
        FROM Multa
        INNER JOIN Emprestimo ON Multa.ID_Emprestimo = Emprestimo.ID_Emprestimo";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Multas</title>
    <link rel="stylesheet" href="stylelista.css">
</head>
<body>
    <h1>Lista de Multas</h1>
    <table>
        <thead>
            <tr>
                <th>ID Multa</th>
                <th>Valor (R$)</th>
                <th>Data da Multa</th>
                <th>ID Empréstimo</th>
                <th>Data do Empréstimo</th>
                <th>Data de Devolução</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exibe os dados se existirem resultados
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID_Multa"] . "</td>";
                    echo "<td>" . number_format($row["Valor"], 2, ',', '.') . "</td>";
                    echo "<td>" . $row["Data_Multa"] . "</td>";
                    echo "<td>" . $row["ID_Emprestimo"] . "</td>";
                    echo "<td>" . $row["Data_Emprestimo"] . "</td>";
                    echo "<td>" . $row["Data_Devolucao"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Nenhuma multa encontrada</td></tr>";
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