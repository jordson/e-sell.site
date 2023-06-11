<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:login.php');
};

if(isset($_POST['order'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $check_cart = $conn->prepare("SELECT * FROM `carrinho` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if($check_cart->rowCount() > 0){

        $insert_order = $conn->prepare("INSERT INTO `pedidos`(user_id, nome, numero, email, metodo, endereco, total_prod, total_preco) VALUES(?,?,?,?,?,?,?,?)");
        $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

        $delete_cart = $conn->prepare("DELETE FROM `carrinho` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);

        $message[] = 'pedido realizado com sucesso!';
    }else{
        $message[] = 'seu carrinho está vazio';
    }

}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <!-- link do font awesome cdn  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- link do arquivo CSS personalizado  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/cabeçalho.php'; ?>

<section class="checkout-orders">

    <form action="" method="POST">

        <h3>Seus Pedidos</h3>

        <div class="display-orders">
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM `carrinho` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if($select_cart->rowCount() > 0){
                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                    $cart_items[] = $fetch_cart['nome'].' ('.$fetch_cart['preco'].' x '. $fetch_cart['quantidade'].')  ';
                    $total_products = implode($cart_items);
                    $grand_total += ($fetch_cart['preco'] * $fetch_cart['quantidade']);
                    ?>
                    <p> <?= $fetch_cart['nome']; ?> <span>(<?= 'R$'.$fetch_cart['preco'].' x '. $fetch_cart['quantidade']; ?>)</span> </p>
                    <?php
                }
            }else{
                echo '<p class="empty">seu carrinho está vazio!</p>';
            }
            ?>

            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
            <div class="grand-total">Total geral : <span><?= 'R$'.$grand_total; ?></span></div>

        </div>

        <h3>faça seu pedido</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Seu nome :</span>
                <input type="text" name="name" placeholder="digite seu nome" class="box" maxlength="20" required>
            </div>

            <div class="inputBox">
            <span>Telefone :</span>
            <input type="tel" id="telefoneInput" name="number" placeholder="Digite seu número de celular (exemplo: (35)12345-6789)" class="box" pattern="\(\d{2}\)\d{5}-\d{4}" required>
            </div>

            <div class="inputBox">
                <span>Seu email :</span>
                <input type="email" name="email" placeholder="digite seu email" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
                <span>Método de pagamento :</span>
                <select name="method" class="box" required>
                    <option value="pagamento na entrega">pagamento na entrega</option>
                    <option value="cartão de crédito">cartão de crédito</option>
                    <option value="pix">pix</option>
                    <option value="paypal">paypal</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Endereço linha 01 :</span>
                <input type="text" name="flat" placeholder="por exemplo, número do apartamento" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
                <span>Endereço linha 02 :</span>
                <input type="text" name="street" placeholder="por exemplo, nome da rua" class="box" maxlength="50">
            </div>
            <div class="inputBox">
                <span>Cidade :</span>
                <input type="text" name="city" placeholder="por exemplo, São Paulo" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
                <span>Estado :</span>
                <input type="text" name="state" placeholder="por exemplo, SP" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
                <span>País :</span>
                <input type="text" name="country" placeholder="por exemplo, Brasil" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
                <span>CEP :</span>
                <input type="text" name="pin_code" placeholder="por exemplo, 123456" inputmode="numeric" pattern="[0-9]*" class="box" required>
            </div>
        </div>

        <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="fazer pedido">

    </form>

</section>

<?php include 'components/footer.php'; ?>

<script>
  const telefoneInput = document.getElementById('telefoneInput');
  const textoTelefone = telefoneInput.value;

  const regex = /\((\d{2})\)(\d{5})-(\d{4})/;
  const match = textoTelefone.match(regex);

  if (match) {
    const telefone = match[1] + match[2] + match[3];
    console.log(telefone); // Saída: 35123456789
  } else {
    console.log('Telefone não encontrado');
  }
</script>


<script src="js/script.js"></script>

</body>
</html>
