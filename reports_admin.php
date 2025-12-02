<?php
session_start();
@include 'config.php';

// Initialize search query and search type
$search_query = "";
$search_type = "";

// Check if a search query and search type are submitted
if(isset($_GET['search']) && isset($_GET['search_type'])) {
    $search_query = $_GET['search'];
    $search_type = $_GET['search_type'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Records</title>

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

<?php include 'header_Admin.php'; ?>

<div class="container">

    <h1 class="heading" style="padding-top: 50px; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; ">Transaction Reports</h1>

    <!-- Search form -->
    <form action="" method="GET" class="search-form-container">
        <select name="search_type" class="search-type-select">
            <option value="customer_id">Customer ID</option>
            <option value="date">Date</option>
        </select>
        <input type="text" name="search" placeholder="<?php echo ($search_type === 'customer_id') ? 'Search by Customer ID' : 'Search by Date (YYYY-MM-DD)'; ?>" value="<?php echo $search_query; ?>" class="search-input">
        <button type="submit" class="search-button">Search</button>
    </form>

    <div class="display-product-table">
        <section>
            <table>
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Customer ID</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Total Products</th>
                        <th>Total Price</th>
                        <th>Employee ID</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include database connection
                    include 'config.php';

                    // Initialize sum variable
                    $totalPriceSum = 0;

                    // Construct query based on search query and search type
                    $query = "SELECT checkout.transaction_id, checkout.customer_id, checkout.method, checkout.date, checkout.total_products, checkout.total_price, checkout.user_id, users.user_name FROM checkout INNER JOIN users ON checkout.user_id = users.user_id";
                    if(!empty($search_query)) {
                        if($search_type === 'customer_id') {
                            $query .= " WHERE checkout.customer_id LIKE '%$search_query%'";
                        } elseif ($search_type === 'date') {
                            // Modify the comparison to use DATE() function and match the date format
                            $query .= " WHERE DATE_FORMAT(checkout.date, '%Y-%m-%d') = '$search_query'";
                        }
                    }

                    $result = mysqli_query($conn, $query);

                    // Check if any rows are returned
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row and display data in table rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['transaction_id'] . "</td>";
                            echo "<td>" . $row['customer_id'] . "</td>";
                            echo "<td>" . $row['method'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['total_products'] . "</td>";
                            echo "<td>₱" . $row['total_price'] . ".00</td>";
                            echo "<td>" . $row['user_id'] . "</td>";
                            echo "<td>" . $row['user_name'] . "</td>";
                            echo "</tr>";

                            // Add the total price to the sum
                            $totalPriceSum += $row['total_price'];
                        }
                    } else {
                        echo "<tr><td colspan='8'>No records found</td></tr>";
                    }

                    // Close connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <!-- Display the sum of total prices below the table -->
    <div class="total_sales">Total Sales: ₱<?php echo number_format($totalPriceSum, 2); ?></div>

</div>    

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
