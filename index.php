<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $turma = $_POST['turma'];

    $stmt = $conn->prepare("INSERT INTO alunos (nome, idade, turma) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $idade, $turma]);

    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM alunos WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $turma = $_POST['turma'];

    $stmt = $conn->prepare("UPDATE alunos SET nome = ?, idade = ?, turma = ? WHERE id = ?");
    $stmt->execute([$nome, $idade, $turma, $id]);

    header("Location: index.php");
}

$alunos = $conn->query("SELECT * FROM alunos")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Alunos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Gerenciamento de Alunos</h1>
    <form method="POST">
        <input type="hidden" name="id" id="id">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="idade" class="form-label">Idade</label>
            <input type="number" class="form-control" id="idade" name="idade" required>
        </div>
        <div class="mb-3">
            <label for="turma" class="form-label">Turma</label>
            <input type="text" class="form-control" id="turma" name="turma" required>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <table class="table mt-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Idade</th>
                <th>Turma</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
            <tr>
                <td><?php echo $aluno['id']; ?></td>
                <td><?php echo $aluno['nome']; ?></td>
                <td><?php echo $aluno['idade']; ?></td>
                <td><?php echo $aluno['turma']; ?></td>
                <td>
                    <a href="index.php?delete=<?php echo $aluno['id']; ?>" class="btn btn-danger">Excluir</a>
                    <button class="btn btn-warning" onclick="editAluno(<?php echo $aluno['id']; ?>, '<?php echo $aluno['nome']; ?>', <?php echo $aluno['idade']; ?>, '<?php echo $aluno['turma']; ?>')">Editar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function editAluno(id, nome, idade, turma) {
    document.getElementById('id').value = id;
    document.getElementById('nome').value = nome;
    document.getElementById('idade').value = idade;
    document.getElementById('turma').value = turma;
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
