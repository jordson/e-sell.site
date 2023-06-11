<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
};

$error_message = '';

if(isset($_POST['submit'])){
$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);
$email = $_POST['email'];
$email = filter_var($email, FILTER_SANITIZE_STRING);
$old_password = $_POST['old_pass'];
$new_password = $_POST['new_pass'];
$confirm_password = $_POST['cpass'];

$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_user->execute([$user_id]);
$row = $select_user->fetch(PDO::FETCH_ASSOC);

if(password_verify($old_password, $row['password'])){
if($new_password === $confirm_password){
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
$update_user = $conn->prepare("UPDATE `users` SET nome = ?, email = ?, password = ? WHERE id = ?");
$update_user->execute([$name, $email, $hashed_password, $user_id]);
$message[] = 'Senha atualizada com sucesso!';
}else{
$error_message = 'A confirmação da nova senha não coincide!';
}
}else{
$error_message = 'Senha antiga incorreta!';
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

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .modal-content p {
            font-size: 16px;
            transition: font-size 0.3s;
            cursor: pointer;
        }

        .modal-content p:hover {
            font-size: 20px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<div id="error-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h4>Erro</h4>
        <p id="error-message"><?php echo $error_message; ?></p>
    </div>
</div>


<section class="form-container">
    <form action="" method="post">
        <h3>Atualize seu perfil</h3>
        <input type="text" name="name" required placeholder="Digite seu nome de usuário" maxlength="20" class="box">
        <input type="email" name="email" required placeholder="Digite seu e-mail" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="old_pass" required placeholder="Digite sua senha antiga" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="new_pass" required placeholder="Digite sua nova senha" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="cpass" required placeholder="Confirme sua nova senha" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Atualizar perfil" class="btn" name="submit">
    </form>
</section>

<?php include 'components/footer.php'; ?>

<script>
    var modal = document.getElementById("error-modal");
    var closeButton = document.getElementsByClassName("close")[0];
    var errorMessage = document.getElementById("error-message");

    // Exibe o pop-up (modal) de erro
    function showErrorModal() {
        modal.style.display = "block";
    }

    // Fecha o pop-up (modal) de erro ao clicar no botão de fechar ou fora do modal
    window.onclick = function(event) {
        if (event.target === modal || event.target === closeButton) {
            modal.style.display = "none";
        }
    }

    // Aumenta o tamanho do texto ao passar o mouse sobre ele
    errorMessage.addEventListener("mouseenter", function() {
        this.style.fontSize = "20px";
    });

    // Reduz o tamanho do texto ao tirar o mouse de cima
    errorMessage.addEventListener("mouseleave", function() {
        this.style.fontSize = "16px";
    });

    // Exibe o pop-up (modal) de erro ao carregar a página, se houver uma mensagem de erro
    window.addEventListener("DOMContentLoaded", function() {
        var error = "<?php echo $error_message; ?>";
        if (error !== "") {
            errorMessage.textContent = error;
            showErrorModal();
        }
    });


</script>

</body>
</html>
