<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
$user_id = $_SESSION['user_id'];
} else {
$user_id = '';
}

if (isset($_POST['submit'])) {

$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);
$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_STRING);
$password = $_POST['pass'];
$password = filter_var($password, FILTER_SANITIZE_STRING);
$confirm_password = $_POST['cpass'];
$confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);

$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
$select_user->execute([$email]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);

if ($select_user->rowCount() > 0) {
$message[] = 'E-mail já cadastrado!';
} else {
if ($password != $confirm_password) {
$message[] = 'Confirmação de senha não coincide!';
} else {
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insert_user = $conn->prepare("INSERT INTO `users` (nome, email, password) VALUES (?, ?, ?)");
$insert_user->execute([$name, $email, $hashed_password]);
$message[] = 'Registrado com sucesso! Faça o login, por favor.';
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
    <title>Cadastro</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<section class="form-container">

    <form action="" method="post">
        <h3>Cadastre-se agora</h3>
        <input type="text" name="name" required placeholder="Digite seu nome de usuário" maxlength="20"  class="box">
        <input type="email" name="email" required placeholder="Digite seu e-mail" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="pass" required placeholder="Digite sua senha" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="cpass" required placeholder="Confirme sua senha" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Cadastrar agora" class="btn" name="submit">
        <p>Já tem uma conta?</p>
        <a href="login.php" class="option-btn">Faça o login agora</a>
    </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
