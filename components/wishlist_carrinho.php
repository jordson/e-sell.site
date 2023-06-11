<?php

if (isset($_POST['add_to_wishlist'])) {
    // Verifica se o usuário está logado
    if ($user_id == '') {
        header('location:login.php');
    } else {
        // Obtém os dados do item a ser adicionado à lista de desejos
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        // Verifica se o item já está na lista de desejos ou no carrinho
        $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE nome = ? AND user_id = ?");
        $check_wishlist_numbers->execute([$name, $user_id]);

        $check_cart_numbers = $conn->prepare("SELECT * FROM `carrinho` WHERE nome = ? AND user_id = ?");
        $check_cart_numbers->execute([$name, $user_id]);

        if ($check_wishlist_numbers->rowCount() > 0) {
            $message = 'Este item já foi adicionado à sua lista de desejos!';
        } elseif ($check_cart_numbers->rowCount() > 0) {
            $message = 'Este item já foi adicionado ao seu carrinho!';
        } else {
            // Insere o item na lista de desejos
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, nome, preco , imagem) VALUES(?,?,?,?,?)");
            $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
            $message = 'Item adicionado à sua lista de desejos com sucesso!';
        }
    }
}

if (isset($_POST['add_to_cart'])) {
    // Verifica se o usuário está logado
    if ($user_id == '') {
        header('location:login.php');
    } else {
        // Obtém os dados do item a ser adicionado ao carrinho
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        // Verifica se o item já está no carrinho
        $check_cart_numbers = $conn->prepare("SELECT * FROM `carrinho` WHERE nome = ? AND user_id = ?");
        $check_cart_numbers->execute([$name, $user_id]);

        if ($check_cart_numbers->rowCount() > 0) {
            $message = 'Este item já foi adicionado ao seu carrinho!';
        } else {
            // Verifica se o item já está na lista de desejos e remove, se necessário
            $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE nome = ? AND user_id = ?");
            $check_wishlist_numbers->execute([$name, $user_id]);

            if ($check_wishlist_numbers->rowCount() > 0) {
                $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE nome = ? AND user_id = ?");
                $delete_wishlist->execute([$name, $user_id]);
            }

            // Insere o item no carrinho
            $insert_cart = $conn->prepare("INSERT INTO `carrinho`(user_id, pid, nome, preco, quantidade, imagem) VALUES(?,?,?,?,?,?)");
            $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
            $message = 'Item adicionado ao seu carrinho com sucesso!';
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
    <title>E-Sell</title>

    <!-- CSS styles -->
    <style>
        .popup-container {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            z-index: 9999;
            animation: slideIn 0.5s ease-in-out;
        }

        .popup-message {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            line-height: 1.5;
            position: relative;
        }

        .popup-close {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 20px;
            color: #333;
            cursor: pointer;
        }

        .popup-progress {
            width: 100%;
            height: 5px;
            background-color: #ccc;
            border-radius: 2px;
            margin-top: 10px;
        }

        @keyframes slideIn {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(0);
            }
        }
    </style>

    <!-- JavaScript -->
    <script>
        function showMessage() {
            var popupContainer = document.getElementById("popup-container");
            popupContainer.style.display = "flex";
            setTimeout(closeMessage, 5000); // Fecha a mensagem após 5 segundos (5000 milissegundos)
        }

        function closeMessage() {
            var popupContainer = document.getElementById("popup-container");
            popupContainer.style.display = "none";
        }

        // Chamada da função showMessage()
        <?php if (isset($message)): ?>
        window.addEventListener('DOMContentLoaded', showMessage);
        <?php endif; ?>
    </script>
</head>
<body>

<?php if (isset($message)): ?>
    <div id="popup-container" class="popup-container">
        <div class="popup-message">
            <span class="popup-close" onclick="closeMessage()">&times;</span>
            <p><?php echo $message; ?></p>
            <div class="popup-progress"></div>
        </div>
    </div>
<?php endif; ?>

<!-- Rest of your HTML code -->

</body>
</html>
