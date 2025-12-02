<?php 
session_start();

include("config.php");
include("functions.php");

// Function to fetch all users' information
function getUsers($conn) {
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted 
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Save to database 
        $user_id = random_num(20);
        $query = "INSERT INTO users (user_id, user_name, password) VALUES ('$user_id', '$user_name', '$password')";
        $result = mysqli_query($con, $query);

        if($result) {
            // Credentials added successfully
            echo '<script>alert("Credentials added successfully");</script>';
        } else {
            // Error adding credentials
            echo '<script>alert("Could not add the credentials");</script>';
        }

        // Redirect the user
        header("Location: signup.php");
        die;
    } else {
        // Please enter valid information
        $message[] = 'Please enter valid information';
        // echo "Please enter valid information";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>

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

<?php
   
   if(isset($message)){
      foreach($message as $message){
         echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
      };
   };
   
?>


<?php include 'header_Admin.php'; ?>


<div class="container">
    <section>
        <form action="" method="post" class="signup-form" enctype="multipart/form-data">
            <h3>add employee</h3>
            <input id="text" type="text" name="user_name" placeholder="Add Username" class="box" required>
            <input id="text" type="password" name="password" placeholder="Add Password" class="box" required>
            <input id="button" type="submit" value="add" class="btn">
        </form>
    </section>

    <!-- Display users' information in table form -->
<div class="display-product-table">
    <section>
        <h3>All Users</h3>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $users = getUsers($con);
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>{$user['user_id']}</td>";
                        echo "<td>{$user['user_name']}</td>";
                        echo "<td>{$user['password']}</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </section>
</div>
</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
