<?php

include '../components/connect.php'; // Inclui o arquivo "connect.php" que contém as configurações de conexão com o banco de dados.

session_start(); // Inicia a sessão.

$admin_id = $_SESSION['admin_id']; // Obtém o ID do administrador da sessão.

if (!isset($admin_id)) { // Verifica se o ID do administrador não está definido na sessão.
    header('location:admin_login.php'); // Redireciona para a página de login do administrador.
}

if (isset($_GET['delete'])) { // Verifica se o parâmetro "delete" está presente na URL.
    $delete_id = $_GET['delete']; // Obtém o ID do usuário a ser deletado.

    // Prepara as consultas SQL para deletar o usuário e suas informações relacionadas em diferentes tabelas do banco de dados.
    $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_user->execute([$delete_id]);

    $delete_orders = $conn->prepare("DELETE FROM `pedidos` WHERE user_id = ?");
    $delete_orders->execute([$delete_id]);

    $delete_mensagens = $conn->prepare("DELETE FROM `mensagem` WHERE user_id = ?");
    $delete_mensagens->execute([$delete_id]);

    $delete_cart = $conn->prepare("DELETE FROM `carrinho` WHERE user_id = ?");
    $delete_cart->execute([$delete_id]);

    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist->execute([$delete_id]);

    header('location:contas_usuario.php'); // Redireciona de volta para a página de contas de usuários após a exclusão.
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas de Usuários</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_top.php'; ?>

<section class="accounts">

    <h1 class="heading">Contas de Usuários</h1>

    <div class="box-container">

        <?php
        $select_accounts = $conn->prepare("SELECT * FROM `users`"); // Prepara a consulta SQL para selecionar todos os usuários.
        $select_accounts->execute(); // Executa a consulta SQL.
        
        if ($select_accounts->rowCount() > 0) { // Verifica se a consulta retornou algum resultado.
            while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) { // Obtém os dados de cada usuário retornado pela consulta.
                ?>
                <div class="box">
                    <p> ID do usuário: <span><?= $fetch_accounts['id']; ?></span> </p> 
                    <p> Nome de usuário: <span><?= $fetch_accounts['nome']; ?></span> </p> 
                    <p> E-mail: <span><?= $fetch_accounts['email']; ?></span> </p> 
                    <a href="contas_usuario.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Deletar esta conta? As informações relacionadas ao usuário também serão excluídas!')" class="delete-btn">Deletar</a>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">Nenhuma conta disponível!</p>'; 
        }
        ?>

    </div>

</section>

<script src="../js/admin_script.js"></script> 

</body>
</html>
