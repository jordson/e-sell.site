<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <a href="../admin/dashboard.php" class="logo">Admin<span>Paneil</span></a>

      <nav class="navbar">
         <a href="../admin/dashboard.php">Inicial</a>
         <a href="../admin/produtos.php">Produtos</a>
         <a href="../admin/pedidos_colocados.php">Pedidos</a>
         <a href="../admin/admin_contas.php">Admins</a>
         <a href="../admin/contas_usuario.php">Clientes</a>
         <a href="../admin/mensagens.php">Mensagem</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['nome']; ?></p>
         <a href="../admin/update_perfil.php" class="btn">Atualizar Perfil</a>
         <div class="flex-btn">
            <a href="../admin/registrar_admin.php" class="option-btn">registrar</a>
            <a href="../admin/admin_login.php" class="option-btn">login</a>
         </div>
         <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">Sair</a> 
      </div>

   </section>

</header>