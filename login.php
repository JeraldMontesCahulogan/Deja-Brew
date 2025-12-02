    <?php 
session_start();

include("config.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted 
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Read from database 
        $query = "SELECT * FROM users WHERE user_name = '$user_name' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if($user_data['password'] === $password) {
                $_SESSION['user_id'] = $user_data['user_id'];
                
                // Check if the password is not "admin123"
                if($password !== "admin123") {
                    header("Location: products.php");
                } else {
                    header("Location: admin.php");
                }
                die;
            }
        }
        
        // Incorrect username or password
        // echo "Wrong username or password";
        $message[] = 'Wrong username or password';
    } else {
        // Please enter valid information
        // echo "Please enter valid information";
        $message[] = 'Please enter valid information';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <style>
        body{
            background-image: url('images_a/background.png');
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

<?php
   
   if(isset($message)){
      foreach($message as $message){
         echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
      };
   };
   
?>

<div class="login_container">
    <section>
        <form action="" method="post" class="login-form" enctype="multipart/form-data">
            <h3>login</h3>
            <input id="text" type="text" name="user_name" placeholder="Username" class="box" required>
            <input id="text" type="password" name="password" placeholder="Password" class="box" required>
            <input id="button" type="submit" value="Login" class="btn">
            <!-- <a href="signup.php">Click to Signup</a><br><br> -->
        </form>
    </section>
</div>


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>