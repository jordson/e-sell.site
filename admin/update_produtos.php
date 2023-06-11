<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['update'])) {

    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE `produtos` SET nome = ?, preco = ?, detalhes = ? WHERE id = ?");
    $update_product->execute([$name, $price, $details, $pid]);

    $message[] = 'produto atualizado com sucesso!';

    $old_image_01 = $_POST['old_image_01'];
    $image_01 = isset($_FILES['image_01']['name']) ? $_FILES['image_01']['name'] : '';
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = isset($_FILES['image_01']['size']) ? $_FILES['image_01']['size'] : 0;
    $image_tmp_name_01 = isset($_FILES['image_01']['tmp_name']) ? $_FILES['image_01']['tmp_name'] : '';
    $image_folder_01 = '../uploaded_img/' . $image_01;

    if (!empty($image_01)) {
        if ($image_size_01 > 2000000) {
            $message[] = 'tamanho da imagem é muito grande!';
        } else {
            $update_image_01 = $conn->prepare("UPDATE `produtos` SET imagem_01 = ? WHERE id = ?");
            $update_image_01->execute([$image_01, $pid]);
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            if (file_exists('../uploaded_img/' . $old_image_01)) {
                unlink('../uploaded_img/' . $old_image_01);
            }
            $message[] = 'imagem 01 atualizada com sucesso!';
        }
    }

    $old_image_02 = $_POST['old_image_02'];
    $image_02 = isset($_FILES['image_02']['name']) ? $_FILES['image_02']['name'] : '';
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = isset($_FILES['image_02']['size']) ? $_FILES['image_02']['size'] : 0;
    $image_tmp_name_02 = isset($_FILES['image_02']['tmp_name']) ? $_FILES['image_02']['tmp_name'] : '';
    $image_folder_02 = '../uploaded_img/' . $image_02;

    if (!empty($image_02)) {
        if ($image_size_02 > 2000000) {
            $message[] = 'tamanho da imagem é muito grande!';
        } else {
            $update_image_02 = $conn->prepare("UPDATE `produtos` SET imagem_02 = ? WHERE id = ?");
            $update_image_02->execute([$image_02, $pid]);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            if (file_exists('../uploaded_img/' . $old_image_02)) {
                unlink('../uploaded_img/' . $old_image_02);
            }
            $message[] = 'imagem 02 atualizada com sucesso!';
        }
    }

    $old_image_03 = $_POST['old_image_03'];
    $image_03 = isset($_FILES['image_03']['name']) ? $_FILES['image_03']['name'] : '';
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = isset($_FILES['image_03']['size']) ? $_FILES['image_03']['size'] : 0;
    $image_tmp_name_03 = isset($_FILES['image_03']['tmp_name']) ? $_FILES['image_03']['tmp_name'] : '';
    $image_folder_03 = '../uploaded_img/' . $image_03;

    if (!empty($image_03)) {
        if ($image_size_03 > 2000000) {
            $message[] = 'tamanho da imagem é muito grande!';
        } else {
            $update_image_03 = $conn->prepare("UPDATE `produtos` SET imagem_03 = ? WHERE id = ?");
            $update_image_03->execute([$image_03, $pid]);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            if (file_exists('../uploaded_img/' . $old_image_03)) {
                unlink('../uploaded_img/' . $old_image_03);
            }
            $message[] = 'imagem 03 atualizada com sucesso!';
        }
    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Produto</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<?php include '../components/admin_top.php'; ?>

<section class="update-product">
    <h1 class="heading">Atualizar Produto</h1>

    <?php
    $update_id = $_GET['update'];
    $select_products = $conn->prepare("SELECT * FROM `produtos` WHERE id = ?");
    $select_products->execute([$update_id]);
    if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                <input type="hidden" name="old_image_01" value="<?= $fetch_products['imagem_01']; ?>">
                <input type="hidden" name="old_image_02" value="<?= $fetch_products['imagem_02']; ?>">
                <input type="hidden" name="old_image_03" value="<?= $fetch_products['imagem_03']; ?>">
                <div class="image-container">
                    <div class="main-image">
                        <img src="../uploaded_img/<?= $fetch_products['imagem_01']; ?>" alt="">
                    </div>
                    <div class="sub-image">
                        <img src="../uploaded_img/<?= $fetch_products['imagem_01']; ?>" alt="">
                        <img src="../uploaded_img/<?= $fetch_products['imagem_02']; ?>" alt="">
                        <img src="../uploaded_img/<?= $fetch_products['imagem_03']; ?>" alt="">
                    </div>
                </div>
                <span>Atualizar nome</span>
                <input type="text" name="name" required class="box" maxlength="100" placeholder="Digite o nome do produto" value="<?= $fetch_products['nome']; ?>">
                <span>Atualizar preço</span>
                <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="Digite o preço do produto" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['preco']; ?>">
                <span>Atualizar detalhes</span>
                <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['detalhes']; ?></textarea>
                <span>Atualizar imagem 01</span>
                <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                <span>Atualizar imagem 02</span>
                <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                <span>Atualizar imagem 03</span>
                <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                <div class="flex-btn">
                    <input type="submit" name="update" class="btn" value="Atualizar">
                    <a href="produtos.php" class="option-btn">Voltar</a>
                </div>
            </form>
            <?php
        }
    } else {
        echo '<p class="empty">Nenhum produto encontrado!</p>';
    }
    ?>
</section>

<script src="../js/admin_script.js"></script>
</body>
</html>
