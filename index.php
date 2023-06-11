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
    <link rel="icon" href="img\es.png" type="image/x-icon">
    <link rel="shortcut icon" href="img\es.png" type="image/x-icon">
    </head>

    <title>Início</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- Link do CDN do font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Link do arquivo CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>



<div class="home-bg">

    <section class="home">

        <div class="swiper home-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/home-img-1.png" alt="">
                    </div>
                    <div class="content">
                        <span>até 50% de desconto</span>
                        <h3>últimos smartphones</h3>
                        <a href="comprar.php" class="btn">comprar agora</a>
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/home-img-2.png" alt="">
                    </div>
                    <div class="content">
                        <span>até 50% de desconto</span>
                        <h3>últimos relógios</h3>
                        <a href="comprar.php" class="btn">comprar agora</a>
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/home-img-3.png" alt="">
                    </div>
                    <div class="content">
                        <span>até 50% de desconto</span>
                        <h3>últimos fones de ouvido</h3>
                        <a href="comprar.php" class="btn">comprar agora</a>
                    </div>
                </div>

            </div>

            <div class="swiper-pagination"></div>

        </div>

    </section>

</div>

<section class="category">

    <h1 class="heading">comprar por categoria</h1>

    <div class="swiper category-slider">

        <div class="swiper-wrapper">

            <a href="categoria.php?category=laptop" class="swiper-slide slide">
                <img src="images/icon-1.png" alt="">
                <h3>laptop</h3>
            </a>

            <a href="categoria.php?category=tv" class="swiper-slide slide">
                <img src="images/icon-2.png" alt="">
                <h3>tv</h3>
            </a>

            <a href="categoria.php?category=câmera" class="swiper-slide slide">
                <img src="images/icon-3.png" alt="">
                <h3>câmera</h3>
            </a>

            <a href="categoria.php?category=mouse" class="swiper-slide slide">
                <img src="images/icon-4.png" alt="">
                <h3>mouse</h3>
            </a>

            <a href="categoria.php?category=geladeira" class="swiper-slide slide">
                <img src="images/icon-5.png" alt="">
                <h3>geladeira</h3>
            </a>

            <a href="categoria.php?category=máquina de lavar" class="swiper-slide slide">
                <img src="images/icon-6.png" alt="">
                <h3>máquina de lavar</h3>
            </a>

            <a href="categoria.php?category=smartphone" class="swiper-slide slide">
                <img src="images/icon-7.png" alt="">
                <h3>smartphone</h3>
            </a>

            <a href="categoria.php?category=relógio" class="swiper-slide slide">
                <img src="images/icon-8.png" alt="">
                <h3>relógio</h3>
            </a>

        </div>

        <div class="swiper-pagination"></div>

    </div>

</section>

<section class="home-products">
    <h1 class="heading">últimos Produtos</h1>


    <div class="swiper products-slider">

        <div class="swiper-wrapper">

            <?php
            $select_products = $conn->prepare("SELECT * FROM `produtos` LIMIT 6");
            $select_products->execute();
            if($select_products->rowCount() > 0){
                while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post" class="swiper-slide slide">
                        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                        <input type="hidden" name="name" value="<?= $fetch_product['nome']; ?>">
                        <input type="hidden" name="price" value="<?= $fetch_product['preco']; ?>">
                        <input type="hidden" name="image" value="<?= $fetch_product['imagem_01']; ?>">
                        <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                        <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
                        <img src="uploaded_img/<?= $fetch_product['imagem_01']; ?>" alt="">
                        <div class="name"><?= $fetch_product['nome']; ?></div>
                        <div class="flex">
                            <div class="price"><span>R$</span><?= number_format($fetch_product['preco'], 2, ',', '.'); ?></div>
                            <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                        </div>
                        <input type="submit" value="adicionar ao carrinho" class="btn" name="add_to_cart">
                    </form>
                    <?php
                }
            }else{
                echo '<p class="empty">nenhum produto adicionado ainda!</p>';
            }
            ?>

        </div>

        <div class="swiper-pagination"></div>

    </div>

</section>


<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

    var swiper = new Swiper(".home-slider", {
        loop:true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            clickable:true,
        },
    });

    var swiper = new Swiper(".category-slider", {
        loop:true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            clickable:true,
        },
        breakpoints: {
            0: {
                slidesPerView: 2,
            },
            650: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 5,
            },
        },
    });

    var swiper = new Swiper(".products-slider", {
        loop:true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            clickable:true,
        },
        breakpoints: {
            550: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });

</script>

</body>
</html>
