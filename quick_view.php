<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};

include 'components/wishlist_carrinho.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>visualização rápida</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<section class="quick-view">

    <h1 class="heading">visualização rápida</h1>

    <?php
    $pid = $_GET['pid'];
    $select_products = $conn->prepare("SELECT * FROM `produtos` WHERE id = ?");
    $select_products->execute([$pid]);
    if($select_products->rowCount() > 0){
        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_product['nome']; ?>">
                <input type="hidden" name="price" value="<?= $fetch_product['preco']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_product['imagem_01']; ?>">
                <div class="row">
                    <div class="image-container">
                        <div class="main-image">
                            <img src="uploaded_img/<?= $fetch_product['imagem_01']; ?>" alt="">
                        </div>
                        <div class="sub-image">
                            <img src="uploaded_img/<?= $fetch_product['imagem_01']; ?>" alt="">
                            <img src="uploaded_img/<?= $fetch_product['imagem_02']; ?>" alt="">
                            <img src="uploaded_img/<?= $fetch_product['imagem_03']; ?>" alt="">
                        </div>
                    </div>
                    <div class="content">
                        <div class="name"><?= $fetch_product['nome']; ?></div>
                        <div class="flex">
                            <div class="price"><span>R$</span><?= number_format($fetch_product['preco'], 2, ',', '.'); ?></div>
                            <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                        </div>
                        <div class="details"><?= $fetch_product['detalhes']; ?></div>
                        <div class="flex-btn">
                            <input type="submit" value="adicionar ao carrinho" class="btn" name="add_to_cart">
                            <input class="option-btn" type="submit" name="add_to_wishlist" value="adicionar à lista de desejos">
                        </div>
                    </div>
                </div>
            </form>
            <?php
        }
    }else{
        echo '<p class="empty">nenhum produto adicionado ainda!</p>';
    }
    ?>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
