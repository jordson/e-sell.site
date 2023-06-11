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
    <title>Sobre</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <!-- Link CDN do Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Link para o arquivo de estilo CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'components/cabeçalho.php'; ?>
<section class="about">
    <div class="row">
        <div class="image">
            <img src="images/about-img.svg" alt="">
        </div>

        <div class="content">
            <h3>Por que nos escolher?</h3>
            <p>Variedade e seleção incomparáveis: Oferecemos uma ampla variedade de produtos de diferentes vendedores, abrangendo todas as categorias para atender às suas necessidades.</p>
            <a href="contato.php" class="btn">Entre em contato</a>
        </div>
    </div>
</section>
<section class="reviews">
    <h1 class="heading">Avaliações dos clientes</h1>
    <div class="swiper reviews-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide slide">
                <img src="images/pic-1.png" alt="">
                <p>Estou extremamente satisfeito com minha compra na E-Sell. O produto chegou antes do prazo, em perfeitas condições e exatamente como descrito. Recomendo a todos!</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>João Silva</h3>
            </div>

            <div class="swiper-slide slide">
                <img src="images/pic-2.png" alt="">
                <p>Fiquei impressionada com a variedade de produtos disponíveis na E-Sell. Encontrei exatamente o que estava procurando e a qualidade do produto superou minhas expectativas. Com certeza vou voltar a comprar aqui!</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
<!--                    <i class="fas fa-star-half-alt"></i>-->
                </div>
                <h3>Maria Oliveira</h3>
            </div>

            <div class="swiper-slide slide">
                <img src="images/pic-3.png" alt="">
                <p>Excelente atendimento ao cliente na E-Sell. Tive uma dúvida sobre o produto e fui prontamente atendido pela equipe de suporte, que foi muito prestativa e resolveu meu problema rapidamente. Ótimo serviço!</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Pedro Santos</h3>
            </div>

            <div class="swiper-slide slide">
                <img src="images/pic-4.png" alt="">
                <p>As avaliações dos clientes realmente ajudaram na minha decisão de compra na E-Sell. Foi tranquilizador ler as experiências positivas de outros compradores e isso me deu confiança para fazer minha compra. Estou muito satisfeita com o produto!</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Ana Rodrigues</h3>
            </div>

            <div class="swiper-slide slide">
                <img src="images/pic-5.png" alt="">
                <p>Recomendo fortemente a E-Sell! Além da excelente seleção de produtos, o processo de entrega foi rápido e seguro. Fiquei impressionado com o cuidado e a embalagem do produto. Com certeza voltarei a comprar aqui</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Luiz Costa</h3>
            </div>

            <div class="swiper-slide slide">
                <img src="images/pic-6.png" alt="">
                <p>As avaliações das clientes realmente me ajudaram a decidir minha compra na E-Sell. Foi muito reconfortante ler as experiências positivas de outras compradoras, o que me deu confiança para fazer minha compra. Estou muito satisfeita com o produto!</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Gabriela Rodrigues</h3>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>
<script>

    var swiper = new Swiper(".reviews-slider", {
        loop:true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            clickable:true,
        },
        breakpoints: {
            0: {
                slidesPerView:1,
            },
            768: {
                slidesPerView: 2,
            },
            991: {
                slidesPerView: 3,
            },
        },
    });

</script>
</body>
</html>