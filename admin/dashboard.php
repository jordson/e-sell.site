<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_top.php'; ?>

<section class="dashboard">

    <h1 class="heading">Painel</h1>

    <div class="box-container">

        <div class="box">
            <h3>Bem-vindo!</h3>
            <p><?= $fetch_profile['nome']; ?></p>
            <a href="update_perfil.php" class="btn">Atualizar Perfil</a>
        </div>

        <div class="box">
            <?php
            $total_pendings = 0;
            $select_pendings = $conn->prepare("SELECT * FROM `pedidos` WHERE pagamento_status = ?");
            $select_pendings->execute(['pendente']);
            if($select_pendings->rowCount() > 0){
                while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                    $total_pendings += $fetch_pendings['total_preco'];
                }
            }
            ?>
            <h3><span>R$ </span><?= $total_pendings; ?><span></span></h3>
            <p>Pendências Totais</p>
            <a href="pedidos_colocados.php" class="btn">Ver Pedidos</a>
        </div>

        <div class="box">
            <?php
            $total_completes = 0;
            $select_completes = $conn->prepare("SELECT * FROM `contador_pedidos` WHERE pagamento_status = ?");
            $select_completes->execute(['completado']);
            if($select_completes->rowCount() > 0){
                while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                    $total_completes += $fetch_completes['ultimo_pedido_valor'];
                }
            }
            ?>
            <h3><span>R$ </span><?= $total_completes; ?><span></span></h3>
            <p>Pedidos Completados</p>
            <a href="pedidos_colocados.php" class="btn">Ver Pedidos</a>
        </div>

        <div class="box">
            <?php
            $select_orders = $conn->prepare("SELECT * FROM `pedidos`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount()
            ?>
            <h3><?= $number_of_orders; ?></h3>
            <p>Pedidos Realizados</p>
            <a href="pedidos_colocados.php" class="btn">Ver Pedidos</a>
        </div>

        <div class="box">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `produtos`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount()
            ?>
            <h3><?= $number_of_products; ?></h3>
            <p>Produtos Adicionados</p>
            <a href="produtos.php" class="btn">Ver Produtos</a>
        </div>

        <div class="box">
            <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount()
            ?>
            <h3><?= $number_of_users; ?></h3>
            <p>Usuários Normais</p>
            <a href="contas_usuario.php" class="btn">Ver Usuários</a>
        </div>

        <div class="box">
            <?php
            $select_admins = $conn->prepare("SELECT * FROM `admins`");
            $select_admins->execute();
            $number_of_admins = $select_admins->rowCount()
            ?>
            <h3><?= $number_of_admins; ?></h3>
            <p>Usuários Administradores</p>
            <a href="admin_contas.php" class="btn">Ver Administradores</a>
        </div>

        <div class="box">
            <?php
            $select_mensagens = $conn->prepare("SELECT * FROM `mensagem`");
            $select_mensagens->execute();
            $number_of_mensagens = $select_mensagens->rowCount()
            ?>
            <h3><?= $number_of_mensagens; ?></h3>
            <p>Novas Mensagens</p>
            <a href="mensagens.php" class="btn">Ver Mensagens</a>
        </div>

    </div>

</section>
<script src="../js/admin_script.js"></script>

</body>
</html>
