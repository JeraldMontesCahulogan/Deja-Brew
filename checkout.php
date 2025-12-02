<?php

@include 'config.php';
session_start();


if(isset($_POST['cancel_order_btn'])){
   $latest_customer_id_query = mysqli_query($conn, "SELECT customer_id FROM `carts` ORDER BY customer_id DESC LIMIT 1");
        if($latest_customer_id_row = mysqli_fetch_assoc($latest_customer_id_query)) {
            $customer_id = $latest_customer_id_row['customer_id'];
        }
    // Delete items from the cart
    mysqli_query($conn, "DELETE FROM `carts` WHERE customer_id = $customer_id");
    echo "<script>alert('Your order has been canceled successfully!'); window.location.href = 'products.php';</script>";
}


if(isset($_POST['order_btn'])){
   if(isset($_SESSION['user_id'])){
      $employee_id = $_SESSION['user_id'];
   }
   $method = $_POST['method'];
   $customer_id = $_POST['number'];
   $cart_query = mysqli_query($conn, "SELECT * FROM `carts` WHERE customer_id = '$customer_id'");
   $price_total = 0;
   $product_name = [];
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name []= $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = number_format($product_item['price'] * $product_item['quantity']);
         $price_total += $product_price;
      }
   }

   $total_product = implode(', ',$product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `checkout`(customer_id, method, total_products, total_price, user_id) VALUES('$customer_id', '$method','$total_product','$price_total', '$employee_id')") or die('query failed');

   if($detail_query){

      if(isset($_SESSION['user_id'])){
         $employee_id = $_SESSION['user_id'];
      }

      if(isset($_SESSION['customer_id'])){
         $customer_id = $_SESSION['customer_id'];
      }

      $latest_customer_id_query = mysqli_query($conn, "SELECT customer_id FROM `checkout` WHERE customer_id = '$customer_id' ");
                    // Check if the query was successful and fetch the result
      if ($latest_customer_id_row = mysqli_fetch_assoc($latest_customer_id_query)) {
          // Extract the customer ID from the fetched row
          $latest_customer_id = $latest_customer_id_row['customer_id'];

          echo "
               <div class='order-message-container'>
               <div class='message-container'>
                  <h3>thank you for shopping!</h3>
                  <div class='order-detail'>
                     <span>".$total_product."</span>
                     <span class='total'> total : ₱".$price_total.".00  </span>
                  </div>
                  <div class='customer-details'>
                     <p> customer ID : <span>".$customer_id."</span> </p> <!-- Display the latest customer ID here -->
                     <p> payment mode : <span>".$method."</span> </p>
                     <p> Employee ID : <span>".$employee_id."</span> </p>
                  </div>
                     <a href='products.php' class='btn'>checkout</a>
                  </div>
               </div>
               ";
      }

      

      // Retrieve the latest customer ID from the orders table
      $latest_order_query = mysqli_query($conn, "SELECT customer_id FROM `carts` ORDER BY customer_id DESC LIMIT 1");
        if($latest_order_row = mysqli_fetch_assoc($latest_order_query)) {
            $latest_customer_transaction_id = $latest_order_row['customer_id'];
            $latest_customer_id = $latest_customer_transaction_id + 1;
            $_SESSION['latest_customer_id'] = $latest_customer_id; // Storing latest_customer_transaction_id in session
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
   <title>checkout</title>

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

<?php include 'header.php'; ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">complete your order</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php

         $customer_id = isset($_SESSION['latest_customer_id']) ? $_SESSION['latest_customer_id'] : 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `carts` WHERE customer_id = '$customer_id' ");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total = $total += $total_price;
      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> grand total : ₱<?= $grand_total; ?>.00 </span>
   </div>

      <div class="flex">

         <div class="inputBox">
                <span>Customer ID</span>
                    <?php
                    $customer_id = isset($_SESSION['latest_customer_id']) ? $_SESSION['latest_customer_id'] : 0;
                    // Fetch the latest customer ID from the carts table
                    $latest_customer_id_query = mysqli_query($conn, "SELECT customer_id FROM `carts` WHERE customer_id = '$customer_id' ORDER BY customer_id DESC LIMIT 1");
                    // Check if the query was successful and fetch the result
                    if ($latest_customer_id_row = mysqli_fetch_assoc($latest_customer_id_query)) {
                        // Extract the customer ID from the fetched row
                        $latest_customer_id = $latest_customer_id_row['customer_id'];
                    }
                    ?>
                <input type="number" value="<?php echo $latest_customer_id; ?>" name="number" required readonly>
            </div>

         <div class="inputBox">
            <span>payment method</span>
            <select name="method">
               <option value="cash" selected>cash</option>
               <option value="credit cart">credit card</option>
               <option value="GCash">GCash</option>
            </select>
         </div>
      </div>
      <input type="submit" value="order now" name="order_btn" class="btn">
      <input type='submit' value='Cancel Order' name='cancel_order_btn' class='btn'>
   </form>

</section>

</div>

<!-- Custom JS for cancel order confirmation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var cancelOrderBtn = document.querySelector('[name="cancel_order_btn"]');
        if (cancelOrderBtn) {
            cancelOrderBtn.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to cancel the order?')) {
                    e.preventDefault();
                }
            });
        }
    });
</script>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>