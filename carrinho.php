<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:login.php');
};

if(isset($_POST['delete'])){
    $cart_id = $_POST['cart_id'];
    $delete_cart_item = $conn->prepare("DELETE FROM `carrinho` WHERE id = ?");
    $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
    $delete_cart_item = $conn->prepare("DELETE FROM `carrinho` WHERE user_id = ?");
    $delete_cart_item->execute([$user_id]);
    header('location:carrinho.php');
}

if(isset($_POST['update_qty'])){
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    $update_qty = $conn->prepare("UPDATE `carrinho` SET quantidade = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);
    $message[] = 'quantidade do carrinho atualizada';
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>carrinho de compras</title>

    <!-- link para o Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- link para o arquivo CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<section class="products shopping-cart">

    <h3 class="heading">carrinho de compras</h3>

    <div class="box-container">

        <?php
        $grand_total = 0;
        $select_cart = $conn->prepare("SELECT * FROM `carrinho` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                    <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?= $fetch_cart['imagem']; ?>" alt="">
                    <div class="name"><?= $fetch_cart['nome']; ?></div>
                    <div class="flex">
                        <div class="price">R$<?= $fetch_cart['preco']; ?></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantidade']; ?>">
                        <button type="submit" class="fas fa-edit" name="update_qty"></button>
                    </div>
                    <div class="sub-total"> subtotal: <span>R$<?= $sub_total = ($fetch_cart['preco'] * $fetch_cart['quantidade']); ?></span> </div>
                    <input type="submit" value="excluir item" onclick="return confirm('excluir isso do carrinho?');" class="delete-btn" name="delete">
                </form>

                <?php
                $grand_total += $sub_total;
            }
        }else{
            echo '<p class="empty">seu carrinho está vazio</p>';
        }
        ?>
    </div>

    <div class="cart-total">
        <p>total geral: <span>R$<?= $grand_total; ?></span></p>
        <a href="comprar.php" class="option-btn">continuar comprando</a>
        <a href="carrinho.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('excluir todos do carrinho?');">excluir todos os itens</a>
        <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceder para o pagamento</a>
    </div>


</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
