<?php

@include 'config.php';
session_start();

// inserting product to the cart table in coffee_db database
if(isset($_POST['add_to_cart'])){
   $customer_id = isset($_SESSION['latest_customer_id']) ? $_SESSION['latest_customer_id'] : 0;
   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM `carts` WHERE product_id = '$product_id' AND customer_id = '$customer_id'");
   
   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'This product is already in the cart.';
   } else {
      $insert_product = mysqli_query($conn, "INSERT INTO `carts`(customer_id, product_id, name, price, image, quantity) VALUES ('$customer_id', '$product_id','$product_name', '$product_price', '$product_image', '$product_quantity')");
      if($insert_product) {
         $message[] = 'Product added to cart successfully.';
      } else {
         $message[] = 'Failed to add product to cart.';
      }
   }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <style>
        body{
            background-image: url('images_a/background1.png');
            height: 100vh;
            background-size: cover;
            background-position: center;
        }
    </style>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<!-- displaying the message -->
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};
?>

<?php include 'header.php'; ?>

<div class="container">

<!-- displaying the available products -->
<section class="products">

   <h1 class="heading">latest products</h1>

   <div class="box-container">

      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products`");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>

      <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['name']; ?></h3>
            <div class="price">₱<?php echo $fetch_product['price']; ?>.00</div>
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>

      <?php
         };
      };
      ?>

   </div>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>