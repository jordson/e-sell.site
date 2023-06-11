<?php

include '../components/connect.php'; // Inclui o arquivo de conexão com o banco de dados

session_start(); // Inicia a sessão

$admin_id = $_SESSION['admin_id']; // Obtém o ID do administrador da sessão

if (!isset($admin_id)) {
    header('location:admin_login.php'); // Redireciona para a página de login do administrador se o ID não estiver definido na sessão
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete']; // Obtém o ID do administrador a ser excluído
    $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?"); // Prepara a consulta para excluir o administrador do banco de dados
    $delete_admins->execute([$delete_id]); // Executa a consulta com o ID fornecido
    header('location:admin_contas.php'); // Redireciona de volta para a página de contas de administrador após a exclusão
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas de administrador</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<?php include '../components/admin_top.php'; ?> <!-- Inclui o arquivo de componente 'admin_top.php' -->

<section class="accounts">
    <h1 class="heading">Contas de administrador</h1>

    <div class="box-container">
        <div class="box">
            <p>Adicionar novo administrador</p>
            <a href="registrar_admin.php" class="option-btn">Registrar administrador</a>
        </div>

        <?php
        $select_accounts = $conn->prepare("SELECT * FROM `admins`"); // Prepara a consulta para selecionar todas as contas de administrador do banco de dados
        $select_accounts->execute(); // Executa a consulta
        if ($select_accounts->rowCount() > 0) { // Verifica se há registros retornados da consulta
            while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) { // Itera sobre cada registro retornado
                ?>
                <div class="box">
                    <p>ID do administrador: <span><?= $fetch_accounts['id']; ?></span></p> <!-- Exibe o ID do administrador -->
                    <p>Nome do administrador: <span><?= $fetch_accounts['nome']; ?></span></p> <!-- Exibe o nome do administrador -->
                    <div class="flex-btn">
                        <a href="admin_contas.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('Excluir esta conta?')" class="delete-btn">Excluir</a> <!-- Cria um link para excluir a conta do administrador, com confirmação -->
                        <?php
                        if ($fetch_accounts['id'] == $admin_id) { // Verifica se o ID do administrador atual é igual ao ID do administrador logado
                            echo '<a href="update_perfil.php" class="option-btn">Atualizar</a>'; // Exibe um link para atualizar o perfil apenas para o administrador logado
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">Nenhuma conta disponível!</p>'; // Exibe uma mensagem caso não haja contas de administrador disponíveis
        }
        ?>

    </div>
</section>

<script src="../js/admin_script.js"></script> <!-- Inclui o arquivo de script JavaScript 'admin_script.js' -->
</body>
</html>
