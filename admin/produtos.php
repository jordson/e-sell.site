<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $imagem_01 = $_FILES['imagem_01']['name'];
    $imagem_01 = filter_var($imagem_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['imagem_01']['size'];
    $image_tmp_name_01 = $_FILES['imagem_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/'.$imagem_01;

    $imagem_02 = $_FILES['imagem_02']['name'];
    $imagem_02 = filter_var($imagem_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['imagem_02']['size'];
    $image_tmp_name_02 = $_FILES['imagem_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/'.$imagem_02;

    $imagem_03 = $_FILES['imagem_03']['name'];
    $imagem_03 = filter_var($imagem_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES['imagem_03']['size'];
    $image_tmp_name_03 = $_FILES['imagem_03']['tmp_name'];
    $image_folder_03 = '../uploaded_img/'.$imagem_03;

    $select_products = $conn->prepare("SELECT * FROM `produtos` WHERE nome = ?");
    $select_products->execute([$name]);

    if($select_products->rowCount() > 0){
        $message[] = 'nome do produto já existe!';
    }else{

        $insert_products = $conn->prepare("INSERT INTO `produtos` (nome, detalhes, preco, imagem_01, imagem_02, imagem_03) VALUES(?,?,?,?,?,?)");
        $insert_products->execute([$name, $details, $price, $imagem_01, $imagem_02, $imagem_03]);

        if($insert_products){
            if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
                $message[] = 'tamanho da imagem é muito grande!';
            }else{
                move_uploaded_file($image_tmp_name_01, $image_folder_01);
                move_uploaded_file($image_tmp_name_02, $image_folder_02);
                move_uploaded_file($image_tmp_name_03, $image_folder_03);
                $message[] = 'novo produto adicionado!';
            }

        }

    }

};

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `produtos` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/'.$fetch_delete_image['imagem_01']);
    unlink('../uploaded_img/'.$fetch_delete_image['imagem_02']);
    unlink('../uploaded_img/'.$fetch_delete_image['imagem_03']);
    $delete_product = $conn->prepare("DELETE FROM `produtos` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `carrinho` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);
    header('location:produtos.php');
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>produtos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_top.php'; ?>

<section class="add-products">

    <h1 class="heading">adicionar produto</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="flex">
            <div class="inputBox">
                <span>nome do produto (obrigatório)</span>
                <input type="text" class="box" required maxlength="100" placeholder="digite o nome do produto" name="name">
            </div>
            <div class="inputBox">
            <span>preço do produto (obrigatório)</span>
            <input type="text" inputmode="numeric" pattern="[0-9]*" class="box" required maxlength="10" placeholder="digite o preço do produto" name="price">
            </div>

            <div class="inputBox">
                <span>imagem 01 (obrigatório)</span>
                <input type="file" name="imagem_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
                <span>imagem 02 (obrigatório)</span>
                <input type="file" name="imagem_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
                <span>imagem 03 (obrigatório)</span>
                <input type="file" name="imagem_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
                <span>detalhes do produto (obrigatório)</span>
                <textarea name="details" placeholder="digite os detalhes do produto" class="box" required maxlength="500" cols="30" rows="10"></textarea>
            </div>
        </div>

        <input type="submit" value="adicionar produto" class="btn" name="add_product">
    </form>

</section>

<section class="show-products">

    <h1 class="heading">produtos adicionados</h1>

    <div class="box-container">

        <?php
        $select_products = $conn->prepare("SELECT * FROM `produtos`");
        $select_products->execute();
        if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="box">
                    <img src="../uploaded_img/<?= $fetch_products['imagem_01']; ?>" alt="">
                    <div class="name"><?= $fetch_products['nome']; ?></div>
                    <div class="price">R$ <span><?= $fetch_products['preco']; ?></span></div>
                    <div class="details"><span><?= $fetch_products['detalhes']; ?></span></div>
                    <div class="flex-btn">
                        <a href="update_produtos.php?update=<?= $fetch_products['id']; ?>" class="option-btn">atualizar</a>
                        <a href="produtos.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('excluir este produto?');">excluir</a>
                    </div>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty">nenhum produto adicionado ainda!</p>';
        }
        ?>

    </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
