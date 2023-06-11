<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<section class="orders">

    <h1 class="heading">Pedidos realizados</h1>

    <div class="box-container">

        <?php
        if($user_id == ''){
            echo '<p class="empty">Faça login para ver seus Pedidos</p>';
        }else{
            $select_orders = $conn->prepare("SELECT * FROM `pedidos` WHERE user_id = ?");
            $select_orders->execute([$user_id]);
            if($select_orders->rowCount() > 0){
                while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <div class="box">
                        <p>Data do pedido: <span><?= $fetch_orders['data']; ?></span></p>
                        <p>Nome: <span><?= $fetch_orders['nome']; ?></span></p>
                        <p>Email: <span><?= $fetch_orders['email']; ?></span></p>
                        <p>Número: <span><?= $fetch_orders['numero']; ?></span></p>
                        <p>Endereço: <span><?= $fetch_orders['endereco']; ?></span></p>
                        <p>Método de Pagamento: <span><?= $fetch_orders['metodo']; ?></span></p>
                        <p>Seus Pedidos: <span><?= $fetch_orders['total_prod']; ?></span></p>
                        <p>Preço total: <span>R$<?= $fetch_orders['total_preco']; ?></span></p>
                        <p>Status do pagamento: <span style="color:<?php if($fetch_orders['pagamento_status'] == 'Andamento'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['pagamento_status']; ?></span> </p>
                    </div>
                    <?php
                }
            }else{
                echo '<p class="empty">Nenhum pedido realizado ainda!</p>';
            }
        }
        ?>

    </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
