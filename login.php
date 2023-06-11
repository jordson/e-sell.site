<?php
include 'components/connect.php';
session_start();

if (!$conn) {
    die("Erro na conexão com o banco de dados.");
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

$error = '';

if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);

    if (!$select_user) {
        $error = 'Erro na consulta ao banco de dados: ' . $conn->errorInfo()[2];
    } else {
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header('location:index.php');
            exit();
        } else {
            $error = 'Usuário ou senha incorretos!';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        .error-message {
            display: none;
            color: red;
            animation: fadeOut 3s ease-in-out;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                display: none;
            }
        }
    </style>
</head>
<body>
<?php include 'components/cabeçalho.php'; ?>

<section class="form-container">
    <form action="" method="post">
        <h3>faça o login</h3>
        <?php if ($error !== ''): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>
        <input type="email" name="email" required placeholder="Digite seu e-mail" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="pass" required placeholder="Digite sua senha" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="login" class="btn" name="submit">
        <p>Não tem uma conta?</p>
        <a href="registrar.php" class="option-btn">cadastre-se agora</a>
    </form>
</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const errorMessage = document.querySelector('.error-message');
        if (errorMessage.textContent !== '') {
            errorMessage.style.display = 'block';
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 3000);
        }
    });
</script>
</body>
</html>
