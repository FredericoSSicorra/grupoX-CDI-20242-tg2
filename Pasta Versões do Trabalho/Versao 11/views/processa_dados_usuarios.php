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
$nome = $_POST['name'];
$user_id = $_POST['user-id'];
$email = $_POST['email'];
$telefone = $_POST['tel'];
$tipo_usuario = $_POST['user-type'];

$curso = $_POST['curso'] ?? null;
$matricula = $_POST['matricula'] ?? null;
$contratacao = $_POST['contratacao'] ?? null;
$departamento = $_POST['departamento'] ?? null;
$registro = $_POST['registro'] ?? null;

// Verificando o tipo de usuário e inserindo os dados na tabela correspondente
try {
    if ($tipo_usuario === 'aluno') {
        $sql = "INSERT INTO Aluno (ID_Usuario, Nome, Curso, Matricula, Email, Telefone, Endereco)
                VALUES (:id_usuario, :nome, :curso, :matricula, :email, :telefone, NULL)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $user_id,
            ':nome' => $nome,
            ':curso' => $curso,
            ':matricula' => $matricula,
            ':email' => $email,
            ':telefone' => $telefone,
        ]);
    } elseif ($tipo_usuario === 'professor') {
        $sql = "INSERT INTO Professor (ID_Usuario, Nome, Departamento, Data_Contratacao, Email, Telefone, Endereco)
                VALUES (:id_usuario, :nome, :departamento, :data_contratacao, :email, :telefone, NULL)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $user_id,
            ':nome' => $nome,
            ':departamento' => $departamento,
            ':data_contratacao' => $contratacao,
            ':email' => $email,
            ':telefone' => $telefone,
        ]);
    } elseif ($tipo_usuario === 'visitante') {
        $sql = "INSERT INTO Visitante (ID_Usuario, Nome, Data_Registro, Email, Telefone, Endereco)
                VALUES (:id_usuario, :nome, :data_registro, :email, :telefone, NULL)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $user_id,
            ':nome' => $nome,
            ':data_registro' => $registro,
            ':email' => $email,
            ':telefone' => $telefone,
        ]);
    } else {
        throw new Exception("Tipo de usuário inválido.");
    }

    echo "Dados inseridos com sucesso na tabela $tipo_usuario!";
} catch (Exception $e) {
    echo "Erro ao inserir os dados: " . $e->getMessage();
}
?>
