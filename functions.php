<?php 

function check_login($con)
{
    if(isset($_SESSION['user_id']))
    {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";

        $result = mysqli_query($con,$query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
        
    }

    //redirect to login
    header("Location: login.php");
    die;

}


    function random_num($length)
{
    $text = "";
    $fixedLength = 8; // Fixed length of 8 digits

    // If the specified length is less than 8, set it to 8
    if ($length < $fixedLength) {
        $length = $fixedLength;
    }

    // Generate a random number with exactly 8 digits
    for ($i = 0; $i < $fixedLength; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}
