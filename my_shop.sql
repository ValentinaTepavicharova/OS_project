CREATE DATABASE IF NOT EXISTS `my_shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `my_shop`;

CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `image` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(1, 'Laptop', 1200.00, 'laptop.jpg'),
(2, 'Phone', 800.00, 'phone.jpg'),
(3, 'Headphones', 150.00, 'headphones.jpg');