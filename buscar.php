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
    <title>página de busca</title>

    <!-- link para o Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- link para o arquivo CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<section class="search-form">
    <form action="" method="post">
        <input type="text" name="search_box" placeholder="pesquise aqui..." maxlength="100" class="box" required>
        <button type="submit" class="fas fa-search" name="search_btn"></button>
    </form>
</section>

<section class="products" style="padding-top: 0; min-height:100vh;">

    <div class="box-container">

        <?php
        if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
            $search_box = $_POST['search_box'];
            $select_products = $conn->prepare("SELECT * FROM `produtos` WHERE nome LIKE '%{$search_box}%'");
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
                            <div class="price"><span>R$</span><?= $fetch_product['preco']; ?><span></span></div>
                            <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                        </div>
                        <input type="submit" value="adicionar ao carrinho" class="btn" name="add_to_cart">
                    </form>
                    <?php
                }
            }else{
                echo '<p class="empty">nenhum produto encontrado!</p>';
            }
        }
        ?>

    </div>

</section>
<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
