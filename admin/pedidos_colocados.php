<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['update_payment'])) {
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
    $update_payment = $conn->prepare("UPDATE `pedidos` SET pagamento_status = ? WHERE id = ?");
    $update_payment->execute([$payment_status, $order_id]);

    if ($payment_status == "completado") {
        $fetch_orders = $conn->prepare("SELECT * FROM `pedidos` WHERE id = ?");
        $fetch_orders->execute([$order_id]);
        $fetch_data = $fetch_orders->fetch(PDO::FETCH_ASSOC);

        $insert_completed_count = $conn->prepare("INSERT INTO `contador_pedidos` (completados, ultimo_pedido_nome, ultimo_pedido_data, ultimo_pedido_valor, ultimo_pedido_admin) VALUES (1, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE completados = completados + 1, ultimo_pedido_nome = ?, ultimo_pedido_data = ?, ultimo_pedido_valor = ?, ultimo_pedido_admin = ?");
        $insert_completed_count->execute([$fetch_data['nome'], $fetch_data['data'], $fetch_data['total_preco'], $admin_id, $fetch_data['nome'], $fetch_data['data'], $fetch_data['total_preco'], $admin_id]);

        $delete_order = $conn->prepare("DELETE FROM `pedidos` WHERE id = ?");
        $delete_order->execute([$order_id]);
    }

    $message[] = 'Status de pagamento atualizado!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    $fetch_orders = $conn->prepare("SELECT * FROM `pedidos` WHERE id = ?");
    $fetch_orders->execute([$delete_id]);
    $fetch_data = $fetch_orders->fetch(PDO::FETCH_ASSOC);

    $insert_completed_count = $conn->prepare("INSERT INTO `contador_pedidos` (completados, ultimo_pedido_nome, ultimo_pedido_data, ultimo_pedido_valor, ultimo_pedido_admin) VALUES (1, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE completados = completados + 1, ultimo_pedido_nome = ?, ultimo_pedido_data = ?, ultimo_pedido_valor = ?, ultimo_pedido_admin = ?");
    $insert_completed_count->execute([$fetch_data['nome'], $fetch_data['data'], $fetch_data['total_preco'], $admin_id, $fetch_data['nome'], $fetch_data['data'], $fetch_data['total_preco'], $admin_id]);

    $delete_order = $conn->prepare("DELETE FROM `pedidos` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    header('location:pedidos_colocados.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos realizados</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<?php include '../components/admin_top.php'; ?>

<section class="orders">
    <h1 class="heading">Pedidos realizados</h1>

    <div class="box-container">
        <?php
        $select_orders = $conn->prepare("SELECT * FROM `pedidos`");
        $select_orders->execute();
        if ($select_orders->rowCount() > 0) {
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                    <p>Realizado em: <span><?= $fetch_orders['data']; ?></span></p>
                    <p>Nome: <span><?= $fetch_orders['nome']; ?></span></p>
                    <p>Número: <span><?= $fetch_orders['numero']; ?></span></p>
                    <p>Endereço: <span><?= $fetch_orders['endereco']; ?></span></p>
                    <p>Total de produtos: <span><?= $fetch_orders['total_prod']; ?></span></p>
                    <p>Preço total: <span>R$<?= $fetch_orders['total_preco']; ?>,00</span></p>
                    <p>Método de pagamento: <span><?= $fetch_orders['metodo']; ?></span></p>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                        <select name="payment_status" class="select">
                            <option selected disabled><?= $fetch_orders['pagamento_status']; ?></option>
                            <option value="pendente">pendente</option>
                            <option value="completado">completado</option>
                        </select>
                        <div class="flex-btn">
                            <input type="submit" value="Atualizar" class="option-btn" name="update_payment">
                            <a href="pedidos_colocados.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Excluir este pedido?');">Excluir</a>
                        </div>
                    </form>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">Nenhum pedido realizado ainda!</p>';
        }
        ?>
    </div>
</section>

<script src="../js/admin_script.js"></script>
</body>
</html>
