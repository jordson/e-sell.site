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
    <title>Loja</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<section class="products">

    <h1 class="heading">Últimos produtos</h1>

    <div class="box-container">

        <?php
        $select_products = $conn->prepare("SELECT * FROM `produtos`");
        $select_products->execute();
        if($select_products->rowCount() > 0){
            while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_product['nome']; ?>">
                <input type="hidden" name="price" value="<?= $fetch_product['preco']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_product['imagem_01']; ?>">
                <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
                <img src="uploaded_img/<?= $fetch_product['imagem_01']; ?>" alt="">
                <div class="name"><?= $fetch_product['nome']; ?></div>
                <div class="flex">
                    <div class="price"><span>R$</span><?= $fetch_product['preco']; ?></div>
                    <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                </div>
                <input type="submit" value="Adicionar ao carrinho" class="btn" name="add_to_cart">
                </form>

                <?php
            }
        }else{
            echo '<p class="empty">Nenhum produto encontrado!</p>';
        }
        ?>

    </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
