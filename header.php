<header class="header">

   <div class="flex">

      <a href="#" class="logo">Deja Brew</a>

      <nav class="navbar">
         <a href="products.php">view products</a>
         <a href="report.php">reports</a>
      </nav>

      <?php
      $customer_id = isset($_SESSION['latest_customer_id']) ? $_SESSION['latest_customer_id'] : 0;

      $select_rows = mysqli_query($conn, "SELECT * FROM `carts` WHERE customer_id = '$customer_id'") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);
      ?>

      <a href="cart.php" class="cart">cart <span><?php echo $row_count; ?></span></a>

      <nav class="navbarL">
         <a href="logout.php">Logout</a>
      </nav>

      <!-- for displaying the clock(database 2: additional feature) -->
      
      <!-- <div class="display_clock">
         <a href="" class="clock">04-26-2024 11:45:03 PM</a>
      </div> -->

      <div id="menu-btn" class="fas fa-bars"></div>

   </div>

</header>