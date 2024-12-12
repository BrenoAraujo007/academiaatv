
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <title>Cadastro | Fitclub</title>
  </head>
  <body>
    <nav>
      <div class="nav__logo">
        <a href="#"></a>
      </div>
      <ul class="nav__links">
        <li class="link"><a href="#">Início</a></li>
        <li class="link"><a href="#">Programa</a></li>
        <li class="link"><a href="#">Serviços</a></li>
        <li class="link"><a href="#">Sobre</a></li>
        <li class="link"><a href="#">Comunidade</a></li>
      </ul>
    </nav>

<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT * FROM login WHERE email = ? AND senha = ?");
    $stmt->execute([$usuario, $senha]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['usuario_id'] = $user['id'];
        header("Location: princ.php");
        exit();
    } else {
        echo "Usuário ou senha inválidos.";
    }
}
?>
