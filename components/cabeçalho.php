<head>
    <!-- Outros links e tags aqui -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>

<style>
    .header {
        background-color: #0a0a0a;
    }

    .custom-div {
        position: fixed;
        top: -153px;
        left: -80px;
    }

    .custom-div img {
        width: 450px;
        height: auto;
        background-color: transparent;
        pointer-events: none;
        outline: none;
    }

    @keyframes colorChange {
    0% { text-shadow: 0 0 5px #ff0000, 0 0 10px #ff0000, 0 0 15px #ff0000, 0 0 20px #ff0000, 0 0 30px #ff0000, 0 0 40px #ff0000; }
    25% { text-shadow: 0 0 5px #ff7f00, 0 0 10px #ff7f00, 0 0 15px #ff7f00, 0 0 20px #ff7f00, 0 0 30px #ff7f00, 0 0 40px #ff7f00; }
    50% { text-shadow: 0 0 5px #ffff00, 0 0 10px #ffff00, 0 0 15px #ffff00, 0 0 20px #ffff00, 0 0 30px #ffff00, 0 0 40px #ffff00; }
    75% { text-shadow: 0 0 5px #00ff00, 0 0 10px #00ff00, 0 0 15px #00ff00, 0 0 20px #00ff00, 0 0 30px #00ff00, 0 0 40px #00ff00; }
    100% { text-shadow: 0 0 5px #0080ff, 0 0 10px #0080ff, 0 0 15px #0080ff, 0 0 20px #0080ff, 0 0 30px #0080ff, 0 0 40px #0080ff; }
}

.header .flex .logo {
    animation: colorChange 5s linear infinite;
    font-size: 5.5rem;
    color: #ffffff; /* white text color */
}

.header .flex .logo span {
    color: #ffffff; /* white text color */
    text-shadow: 0 0 5px #ff0000, 0 0 10px #ff0000, 0 0 15px #ff0000, 0 0 20px #ff0000, 0 0 30px #ff0000, 0 0 40px #ff0000;
    animation: colorChange 5s linear infinite;
}



.logo {
  text-align: center;
}

.logo-text {
  font-size: 4rem;
  font-weight: bold;
  text-transform: uppercase;
  color: #ffffff;
  text-shadow: 0 0 10px rgba(255, 255, 0, 0.8);
  position: relative;
}

.logo-text::before,
.logo-text::after {
  content: "";
  position: absolute;
  top: 50%;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #ff0000;
  animation: flicker 2s infinite;
}

.logo-text::before {
  left: -20px;
  animation-delay: 0.2s;
}

.logo-text::after {
  right: -20px;
  animation-delay: 0.4s;
}

@keyframes flicker {
  0% { opacity: 0.5; }
  50% { opacity: 1; }
  100% { opacity: 0.5; }
}
 
</style>


<header class="header">
    <section class="flex">
        <div class="logo">
        <h1 class="logo-text"><span>E-Sell</span></h1>
        </div>

        <!-- <a href="index.php" class="logo">E-Sell<span>.</span></a> -->
        <!-- <a href="index.php" class="logo animate__animated animate__bounceIn">E-Sell<span>.</span></a> -->

        <!-- <div class="custom-div">
            <img src="img/es.png" alt="Imagem">
        </div><br> -->

        <nav class="navbar">
            <a href="index.php" style="color: #ffffff;">Inicial</a>
            <a href="sobre.php" style="color: #ffffff;">Sobre Nós</a>
            <a href="pedidos.php" style="color: #ffffff;">Pedidos</a>
            <a href="comprar.php" style="color: #ffffff;">Comprar</a>
            <a href="contato.php" style="color: #ffffff;">Contato</a>
        </nav>

        <div class="icons">
            <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `carrinho` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
            ?>
            <div id="menu-btn" class="fas fa-bars" style="color: white;"></div>
            <a href="buscar.php"><i class="fas fa-search" style="color: white;"></i></a>
            <a href="wishlist.php"><i class="fas fa-heart" style="color: white;"></i><span style="color: white;">(<?= $total_wishlist_counts; ?>)</span></a>
            <a href="carrinho.php"><i class="fas fa-shopping-cart" style="color: white;"></i><span style="color: white;">(<?= $total_cart_counts; ?>)</span></a>
            <div id="user-btn" class="fas fa-user" style="color: white;"></div>
        </div>

        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <p><?= $fetch_profile["nome"]; ?></p>
                <a href="atualizar.php" class="btn">atualizar perfil</a>
                <div class="flex-btn">
                    <a href="registrar.php" class="option-btn">registrar</a>
                    <a href="login.php" class="option-btn">login</a>
                </div>
                <a href="components/logout.php" class="delete-btn" onclick="return confirm('sair do site?');">sair</a>
                <?php
            } else {
                ?>
                <p>faça login ou registre-se primeiro!</p>
                <div class="flex-btn">
                    <a href="registrar.php" class="option-btn">registrar</a>
                    <a href="login.php" class="option-btn">login</a>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
</header>
