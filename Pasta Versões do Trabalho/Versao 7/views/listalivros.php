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

// Consulta SQL para obter os dados da tabela Livro
$sql = "SELECT ID_Livro, Titulo, Data_Publicacao, Numero_Copias, ID_Autor, ID_Categoria FROM Livro";
$result = $conn->query($sql);

// Consulta SQL para obter a soma, média, valor máximo e valor mínimo do número de cópias
$sqlStats = "SELECT SUM(Numero_Copias) AS Soma, AVG(Numero_Copias) AS Media, MAX(Numero_Copias) AS Maximo, MIN(Numero_Copias) AS Minimo FROM Livro";
$statsResult = $conn->query($sqlStats);
$stats = $statsResult->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
    <link rel="stylesheet" href="stylelista.css">
</head>
<body>
    <h1>Lista de Livros</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Data de Publicação</th>
                <th>Número de Cópias</th>
                <th>ID Autor</th>
                <th>ID Categoria</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exibe os dados se existirem resultados
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID_Livro"] . "</td>";
                    echo "<td>" . $row["Titulo"] . "</td>";
                    echo "<td>" . $row["Data_Publicacao"] . "</td>";
                    echo "<td>" . $row["Numero_Copias"] . "</td>";
                    echo "<td>" . $row["ID_Autor"] . "</td>";
                    echo "<td>" . $row["ID_Categoria"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Nenhum livro encontrado</td></tr>";
            }
            ?>
            <tr>
                <td colspan="6"><strong>Estatísticas do Número de Cópias</strong></td>
            </tr>
            <tr>
                <td colspan="2">Soma: <?php echo $stats["Soma"]; ?></td>
                <td colspan="2">Média: <?php echo number_format($stats["Media"], 2, ',', '.'); ?></td>
                <td>Máximo: <?php echo $stats["Maximo"]; ?></td>
                <td>Mínimo: <?php echo $stats["Minimo"]; ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
