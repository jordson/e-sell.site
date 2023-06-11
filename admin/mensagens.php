<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `mensagem` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:mensagens.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagens</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_top.php'; ?>

<section class="contacts">

    <h1 class="heading">Mensagens</h1>

    <div class="box-container">

        <?php
        $select_mensagens = $conn->prepare("SELECT * FROM `mensagem`");
        $select_mensagens->execute();
        if ($select_mensagens->rowCount() > 0) {
            while ($fetch_message = $select_mensagens->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                    <p> ID do usuário: <span><?= $fetch_message['user_id']; ?></span></p>
                    <p> Nome: <span><?= $fetch_message['nome']; ?></span></p>
                    <p> Email: <span><?= $fetch_message['email']; ?></span></p>
                    <p> Número: <span><?= $fetch_message['numero']; ?></span></p>
                    <p> Mensagem: <span><?= $fetch_message['mensagem']; ?></span></p>
                    <a href="mensagens.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Deletar esta mensagem?');" class="delete-btn">Deletar</a>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">Você não tem mensagens.</p>';
        }
        ?>

    </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
