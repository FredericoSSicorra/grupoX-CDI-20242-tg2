<?php
$host = "localhost";
$user = "root";
$password = ""; // Substitua pelo seu password do MySQL
$database = "db_BibliotecaUFSM01";

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verifica se a conexão falhou
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "
    SELECT 
        Multa.ID_Multa,
        Multa.Valor AS Valor_Multa,
        Livro.Titulo AS Livro_Relacionado,
        Emprestimo.Data_Emprestimo,
        Emprestimo.Data_Devolucao
    FROM 
        Multa
    JOIN 
        Emprestimo ON Multa.ID_Emprestimo = Emprestimo.ID_Emprestimo
    JOIN 
        Livro ON Emprestimo.ID_Livro = Livro.ID_Livro;
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta 1</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Livros Reservados por Alunos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID da Multa</th>
                <th>Valor da Multa</th>
                <th>Título do Livro</th>
                <th>Data do Emprestimo</th>
                <th>Data da Devolução</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ID_Multa'] . "</td>";
                    echo "<td>" . $row['Valor_Multa'] . "</td>";
                    echo "<td>" . $row['Livro_Relacionado'] . "</td>";
                    echo "<td>" . $row['Data_Emprestimo'] . "</td>";
                    echo "<td>" . $row['Data_Devolucao'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhum resultado encontrado</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php $conn->close(); ?>
</body>
</html>
