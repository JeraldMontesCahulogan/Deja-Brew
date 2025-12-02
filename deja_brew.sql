-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 15, 2024 at 07:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deja_brew`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `customer_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`customer_id`, `product_id`, `name`, `price`, `image`, `quantity`) VALUES
(0, 19, 'espresso', '65', 'espresso.png', 1),
(0, 35, 'Cake vegan', '75', 'Cake vegan.png', 1),
(3, 31, 'special leche flan', '65', 'special leche flan.png', 1),
(3, 35, 'Cake vegan', '75', 'Cake vegan.png', 1),
(7, 27, 'cupcakes', '35', 'cupcake.png', 3),
(7, 28, 'fig cupcake', '45', 'fig cupcake.png', 3),
(7, 33, 'tripled layer choco cake', '69', 'tripled layer choco cake.png', 3),
(7, 35, 'Cake vegan', '75', 'Cake vegan.png', 1),
(8, 30, 'Mud Cake ', '55', 'Mud Cake Photography.png', 1),
(8, 31, 'special leche flan', '65', 'special leche flan.png', 1),
(8, 32, 'mocha caramel cake', '65', 'mocha caramel cake.png', 1),
(9, 34, 'strawberry cream cake', '75', 'strawberry cream cake.png', 2),
(10, 29, 'chuk coffe cake', '69', 'chuk coffe cake.png', 1),
(11, 35, 'Cake vegan', '75', 'Cake vegan.png', 1),
(12, 17, 'cappuccino', '99', 'Cappuccino.png', 1),
(12, 18, 'classic coffee', '55', 'classic coffee.png', 1),
(12, 19, 'espresso', '65', 'espresso.png', 1),
(13, 19, 'espresso', '65', 'espresso.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `transaction_id` int(255) NOT NULL,
  `customer_id` int(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `total_products` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `user_id` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`transaction_id`, `customer_id`, `method`, `date`, `total_products`, `total_price`, `user_id`) VALUES
(127, 0, 'cash', '2024-05-02', 'espresso (1) , Cake vegan (1) ', '140', 24144914),
(128, 12, 'cash', '2024-05-09', 'cappuccino (1) , classic coffee (1) , espresso (1) ', '219', 24144914),
(129, 13, 'cash', '2024-05-13', 'espresso (1) ', '65', 24144914);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(17, 'cappuccino', '99', 'Cappuccino.png'),
(18, 'classic coffee', '55', 'classic coffee.png'),
(19, 'espresso', '65', 'espresso.png'),
(23, 'matcha latte', '99', 'matcha latte.png'),
(25, 'Mocha Latte', '75', 'Mocha Latte.png'),
(26, 'croissant', '30', 'croissant.png'),
(27, 'cupcakes', '35', 'cupcake.png'),
(28, 'fig cupcake', '45', 'fig cupcake.png'),
(29, 'chuk coffe cake', '69', 'chuk coffe cake.png'),
(30, 'Mud Cake ', '55', 'Mud Cake Photography.png'),
(31, 'special leche flan', '65', 'special leche flan.png'),
(32, 'mocha caramel cake', '65', 'mocha caramel cake.png'),
(33, 'tripled layer choco cake', '69', 'tripled layer choco cake.png'),
(34, 'strawberry cream cake', '75', 'strawberry cream cake.png'),
(35, 'Cake vegan', '75', 'Cake vegan.png'),
(36, 'Keto Caramel Macchiato', '99', 'Keto Caramel Macchiato.png'),
(37, 'Caramel Coffee Banana Cake', '109', 'Caramel Coffee Banana Cake.png'),
(38, 'matcha latte', '300', 'coffee caramel cake.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `password`) VALUES
(14, 99332979, 'admin', 'admin123'),
(15, 24144914, 'jerald', 'jmc123'),
(17, 21162850, 'yumi', '123'),
(18, 4634620, 'mark', 'mark1234'),
(19, 94234574, 'lea', 'password'),
(20, 74385625, 'jaysan', 'david123'),
(21, 74655623, 'angelie', '1129'),
(22, 27927287, 'rose', 'rose123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`customer_id`,`product_id`),
  ADD KEY `product_id_fk` (`product_id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`transaction_id`,`customer_id`),
  ADD KEY `customer_id_fk` (`customer_id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `transaction_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `customer_id_fk` FOREIGN KEY (`customer_id`) REFERENCES `carts` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
