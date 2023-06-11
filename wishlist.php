<?php
// Inclui o arquivo de conexão com o banco de dados
include 'components/connect.php';

// Inicia a sessão
session_start();

// Verifica se existe um usuário logado na sessão
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    // Redireciona para a página de login do usuário
    header('location: login.php');
}

// Inclui o arquivo do carrinho de desejos
include 'components/wishlist_carrinho.php';

// Verifica se foi enviado o formulário de exclusão de item do carrinho de desejos
if(isset($_POST['delete'])){
    $wishlist_id = $_POST['wishlist_id'];
    // Deleta o item do carrinho de desejos com base no ID
    $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist_item->execute([$wishlist_id]);
}

// Verifica se foi enviado o parâmetro de exclusão de todos os itens do carrinho de desejos
if(isset($_GET['delete_all'])){
    // Deleta todos os itens do carrinho de desejos para o usuário
    $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist_item->execute([$user_id]);
    // Redireciona para a página do carrinho de desejos
    header('location: wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wishlist</title>

    <!-- link para o Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- link para o arquivo CSS personalizado -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<section class="products">

    <h3 class="heading">sua lista de desejos</h3>

    <div class="box-container">

        <?php
        $grand_total = 0;
        // Seleciona todos os itens do carrinho de desejos para o usuário
        $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
        $select_wishlist->execute([$user_id]);
        if($select_wishlist->rowCount() > 0){
            while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
                $grand_total += $fetch_wishlist['preco'];
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
                    <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_wishlist['nome']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_wishlist['preco']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_wishlist['imagem']; ?>">
                    <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?= $fetch_wishlist['imagem']; ?>" alt="">
                    <div class="name"><?= $fetch_wishlist['nome']; ?></div>
                    <div class="flex">
                        <div class="price">R$<?= $fetch_wishlist['preco']; ?></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                    </div>
                    <input type="submit" value="adicionar ao carrinho" class="btn" name="add_to_cart">
                    <input type="submit" value="excluir item" onclick="return confirm('excluir isso da lista de desejos?');" class="delete-btn" name="delete">
                </form>
                <?php
            }
        }else{
            echo '<p class="empty">sua lista de desejos está vazia</p>';
        }
        ?>
    </div>

    <div class="wishlist-total">
        <p>Total: <span>R$<?= $grand_total; ?></span></p>
        <a href="comprar.php" class="option-btn">continuar comprando</a>
        <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('excluir todos os itens da lista de desejos?');">excluir todos os itens</a>
    </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
