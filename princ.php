<?php
include 'conexao.php';

// Cadastrar usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $pago = isset($_POST['pago']) ? 1 : 0;
    $ultimo_pagamento = $_POST['ultimo_pagamento'];
    $valor_pagamento = $_POST['valor_pagamento'];
    $frequencia = $_POST['frequencia'];

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, cpf, pago, ultimo_pagamento, valor_pagamento, frequencia) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $cpf, $pago, $ultimo_pagamento, $valor_pagamento, $frequencia]);

    header("Location: index.php");
}

// Atualizar usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $pago = isset($_POST['pago']) ? 1 : 0;
    $ultimo_pagamento = $_POST['ultimo_pagamento'];
    $valor_pagamento = $_POST['valor_pagamento'];
    $frequencia = $_POST['frequencia'];

    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, cpf = ?, pago = ?, ultimo_pagamento = ?, valor_pagamento = ?, frequencia = ? WHERE id = ?");
    $stmt->execute([$nome, $cpf, $pago, $ultimo_pagamento, $valor_pagamento, $frequencia, $id]);

    header("Location: index.php");
}

// Deletar usuário
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
}

// Consultar usuários
$usuarios = $conn->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Academia</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Gerenciamento de Academia</h1>
    <form method="POST">
        <input type="hidden" name="id" id="id">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" required>
        </div>
        <div class="mb-3">
            <label for="pago" class="form-label">Pago</label>
            <input type="checkbox" id="pago" name="pago">
        </div>
        <div class="mb-3">
            <label for="ultimo_pagamento" class="form-label">Último Pagamento</label>
            <input type="date" class="form-control" id="ultimo_pagamento" name="ultimo_pagamento" required>
        </div>
        <div class="mb-3">
            <label for="valor_pagamento" class="form-label">Valor do Pagamento</label>
            <input type="number" step="0.01" class="form-control" id="valor_pagamento" name="valor_pagamento" required>
        </div>
        <div class="mb-3">
            <label for="frequencia" class="form-label">Frequência</label>
            <input type="text" class="form-control" id="frequencia" name="frequencia" required>
        </div>
        <button type="submit" name="cadastrar" class="btn btn-success">Cadastrar</button>
        <button type="submit" name="atualizar" class="btn btn-primary">Atualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <table class="table mt-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Pago</th>
                <th>Último Pagamento</th>
                <th>Valor do Pagamento</th>
                <th>Frequência</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo $usuario['nome']; ?></td>
                <td><?php echo $usuario['cpf']; ?></td>
                <td><?php echo $usuario['pago'] ? 'Sim' : 'Não'; ?></td>
                <td><?php echo $usuario['ultimo_pagamento']; ?></td>
                <td><?php echo $usuario['valor_pagamento']; ?></td>
                <td><?php echo $usuario['frequencia']; ?></td>
                <td>
                    <a href="index.php?delete=<?php echo $usuario['id']; ?>" class="btn btn-danger">Excluir</a>
                    <button class="btn btn-warning" onclick="editUsuario(<?php echo $usuario['id']; ?>, '<?php echo $usuario['nome']; ?>', '<?php echo $usuario['cpf']; ?>', <?php echo $usuario['pago']; ?>, '<?php echo $usuario['ultimo_pagamento']; ?>', '<?php echo $usuario['valor_pagamento']; ?>', '<?php echo $usuario['frequencia']; ?>')">Editar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function editUsuario(id, nome, cpf, pago, ultimo_pagamento, valor_pagamento, frequencia) {
    document.getElementById('id').value = id;
    document.getElementById('nome').value = nome;
    document.getElementById('cpf').value = cpf;
    document.getElementById('pago').checked = pago;
    document.getElementById('ultimo_pagamento').value = ultimo_pagamento;
    document.getElementById('valor_pagamento').value = valor_pagamento;
    document.getElementById('frequencia').value = frequencia;
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
