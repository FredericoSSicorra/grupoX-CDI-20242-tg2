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

// Consulta SQL para obter os dados da tabela Emprestimo
$sql = "SELECT Emprestimo.ID_Emprestimo, Emprestimo.Data_Emprestimo, Emprestimo.Data_Devolucao, 
               Emprestimo.ID_Livro, Livro.Titulo AS Titulo_Livro
        FROM Emprestimo
        INNER JOIN Livro ON Emprestimo.ID_Livro = Livro.ID_Livro";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empréstimos</title>
    <link rel="stylesheet" href="stylelista.css">
</head>
<body>
    <h1>Lista de Empréstimos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data do Empréstimo</th>
                <th>Data de Devolução</th>
                <th>ID do Livro</th>
                <th>Título do Livro</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exibe os dados se existirem resultados
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID_Emprestimo"] . "</td>";
                    echo "<td>" . $row["Data_Emprestimo"] . "</td>";
                    echo "<td>" . $row["Data_Devolucao"] . "</td>";
                    echo "<td>" . $row["ID_Livro"] . "</td>";
                    echo "<td>" . $row["Titulo_Livro"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum empréstimo encontrado</td></tr>";
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
