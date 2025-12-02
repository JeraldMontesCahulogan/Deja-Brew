<?php

@include 'config.php';
session_start();

// for updating the quantity in the table cart in coffee_db database
if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `carts` SET quantity = '$update_value' WHERE product_id = '$update_id'");
   if($update_quantity_query){
      header('location:cart.php');
   };
};

// for removing the selected product in the table cart in coffe_db database
if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `carts` WHERE product_id = '$remove_id'");
   header('location:cart.php');
};

// for deleting all the selected products of the latest customer in the table cart in coffee_db database
if(isset($_GET['delete_all'])){
   $latest_customer_id_query = mysqli_query($conn, "SELECT customer_id FROM `carts` ORDER BY customer_id DESC LIMIT 1");
        if($latest_customer_id = mysqli_fetch_assoc($latest_customer_id_query)) {
            $customer_id = $latest_customer_id['customer_id'];
            mysqli_query($conn, "DELETE FROM `carts` where customer_id = '$customer_id' ");
            header('location:cart.php');
      };
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- background image and its style -->
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

<!-- displaying the selected products of the customer -->
<section class="shopping-cart">

   <h1 class="heading">shopping cart</h1>

   <!-- displaying the selected products of the customer in a table -->
   <table>

      <thead>
         <th>image</th>
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th>action</th>
      </thead>

      <tbody>

         <?php 
         $customer_id = isset($_SESSION['latest_customer_id']) ? $_SESSION['latest_customer_id'] : 0;

         $select_cart = mysqli_query($conn, "SELECT * FROM `carts` WHERE customer_id = '$customer_id'");
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td>₱<?php echo number_format($fetch_cart['price']); ?>.00</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['product_id']; ?>" >
                  <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['quantity']; ?>" >
                  <input type="submit" value="update" name="update_update_btn">
               </form>   
            </td>
            <td>₱<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>.00</td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['product_id']; ?>" onclick="return confirm('Are you sure you want to remove this product from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
         </tr>
         <?php
           $grand_total += $sub_total;  
            };
         };
         ?>
         <tr class="table-bottom">
            <td><a href="products.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
            <td colspan="3">grand total</td>
            <td>₱<?php echo $grand_total; ?>.00</td>
            <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">procced to checkout</a>
   </div>

</section>

</div>
   
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>