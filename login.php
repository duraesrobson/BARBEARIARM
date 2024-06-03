<?php
session_start();

$servername = "localhost";
$username = "id22216941_admin";
$password = "!Chapo24251916";
$dbname = "id22216941_barbearia2";

// Cria uma conexão segura
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_user = trim($_POST['username']);
    $admin_pass = trim($_POST['password']);

   // Verificação simples para o exemplo
    if ($admin_user === 'admin' && $admin_pass === '2425') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = "Usuário ou senha incorretos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Login do Administrador</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <a href="index.php" class="button-control"><i class="fas fa-arrow-left"></i> Voltar</a>

    <div class="containerlogin">
        <h1>Login do Administrador</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
    <script>
    // Array de URLs das imagens de fundo
    const imagens = [
        'img/fundo1.jpg',
        'img/fundo2.jpg', // Adicione suas imagens aqui
        'img/fundo3.jpg',
        'img/fundo4.jpg',
        'img/fundo5.jpg',
    ];

    let imagemIndex = 0;

    function mudarImagemFundo() {
        // Atualiza o índice da imagem
        imagemIndex = (imagemIndex + 1) % imagens.length;

        // Seleciona o elemento body e altera o background-image
        document.body.style.backgroundImage = `url('${imagens[imagemIndex]}')`;
    }

    // Troca de imagem a cada 5 segundos
    setInterval(mudarImagemFundo, 5000);

    // Garante que a primeira imagem seja carregada imediatamente
    window.onload = function() {
        document.body.style.backgroundImage = `url('${imagens[imagemIndex]}')`;
    };
</script>
</body>
</html>
