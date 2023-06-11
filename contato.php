<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};

if(isset($_POST['send'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM `mensagem` WHERE nome = ? AND email = ? AND numero = ? AND mensagem = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if($select_message->rowCount() > 0){
        $message[] = 'Mensagem já enviada!';
    }else{

        $insert_message = $conn->prepare("INSERT INTO `mensagem`(user_id, nome, email, numero, mensagem) VALUES(?,?,?,?,?)");
        $insert_message->execute([$user_id, $name, $email, $number, $msg]);

        $message[] = 'Mensagem enviada com sucesso!';

    }

}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<section class="contact">

    <form action="" method="post">
        <h3>Fale Conosco</h3>
        <input type="text" name="name" placeholder="Digite seu nome" required maxlength="20" class="box">
        <input type="email" name="email" placeholder="Digite seu email" required maxlength="50" class="box">
        <input type="tel" id="phone" name="phone" pattern="\(\d{2}\)\d{5}-\d{4}" placeholder="DDD + número" required class="box" style="-moz-appearance: textfield; -webkit-appearance: textfield; appearance: textfield;">
        <textarea name="msg" class="box" placeholder="Digite sua mensagem" cols="30" rows="10"></textarea>
        <input type="submit" value="Enviar mensagem" name="send" class="btn">
    </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
