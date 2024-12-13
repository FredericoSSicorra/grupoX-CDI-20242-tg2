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
        Aluno.Nome AS Nome_Aluno,
        Livro.Titulo AS Titulo_Livro,
        Categoria.Nome_Categoria AS Genero_Livro
    FROM 
        Aluno
    JOIN 
        Reserva ON Aluno.ID_Usuario = Reserva.ID_Usuario
    JOIN 
        Livro ON Reserva.ID_Livro = Livro.ID_Livro
    JOIN
        Categoria ON Livro.ID_Categoria = Categoria.ID_Categoria
    
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
                <th>Aluno</th>
                <th>Título do Livro</th>
                <th>Gênero</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Nome_Aluno'] . "</td>";
                    echo "<td>" . $row['Titulo_Livro'] . "</td>";
                    echo "<td>" . $row['Genero_Livro'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Nenhum resultado encontrado</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php $conn->close(); ?>
</body>
</html>
