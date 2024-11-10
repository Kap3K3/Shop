/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `db_qllinhkien` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `db_qllinhkien`;

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cart` (`cart_id`, `user_id`, `date_created`) VALUES
	(1, 1, '2024-11-10 12:59:51'),
	(2, 3, '2024-11-10 13:01:44');

CREATE TABLE IF NOT EXISTS `cart_items` (
  `cart_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`cart_item_id`),
  KEY `cart_id` (`cart_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `date_added`) VALUES
	(2, 1, 2, 1, '2024-11-10 13:01:01'),
	(5, 2, 2, 1, '2024-11-10 17:15:20'),
	(6, 2, 2, 1, '2024-11-10 17:20:49');

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `customer` (`id`, `name`, `phone`) VALUES
	(1, 'phát', 123456789),
	(2, 'phát', 123456789),
	(3, 'phát', 214748364),
	(4, 'phát', 123456789);

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_cust` int(6) NOT NULL,
  `date` datetime DEFAULT NULL,
  `total_price` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cust_ord` (`id_cust`),
  CONSTRAINT `fk_cust_ord` FOREIGN KEY (`id_cust`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` (`id`, `id_cust`, `date`, `total_price`) VALUES
	(1, 1, '2024-11-10 12:59:54', 17000000),
	(2, 1, '2024-11-10 13:00:44', 17000000),
	(3, 1, '2024-11-10 13:00:59', 17000000),
	(4, 3, '2024-11-10 13:01:46', 17000000),
	(5, 3, '2024-11-10 13:02:02', 35500000),
	(6, 3, '2024-11-10 17:16:55', 18500000),
	(7, 3, '2024-11-10 17:20:55', 18500000),
	(8, 3, '2024-11-10 17:20:58', 18500000);

CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_prod` int(6) NOT NULL,
  `id_order` int(6) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detail_ord` (`id_order`),
  KEY `fk_detail_prod` (`id_prod`),
  CONSTRAINT `fk_detail_ord` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`),
  CONSTRAINT `fk_detail_prod` FOREIGN KEY (`id_prod`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_details` (`id`, `id_prod`, `id_order`, `quantity`) VALUES
	(1, 1, 1, 1),
	(2, 1, 2, 1),
	(3, 1, 3, 1),
	(4, 1, 4, 1),
	(5, 1, 5, 1),
	(6, 2, 5, 1),
	(7, 2, 6, 1),
	(8, 2, 7, 1),
	(9, 2, 8, 1);

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` bigint(20) NOT NULL,
  `id_supplier` int(6) NOT NULL,
  `id_prodcate` int(6) NOT NULL,
  `image` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prod_cate` (`id_prodcate`),
  KEY `fk_prod_supp` (`id_supplier`),
  CONSTRAINT `fk_prod_cate` FOREIGN KEY (`id_prodcate`) REFERENCES `product_category` (`id`),
  CONSTRAINT `fk_prod_supp` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`id`, `name`, `price`, `id_supplier`, `id_prodcate`, `image`) VALUES
	(1, 'RTX 3060', 17000000, 1, 1, '../src/img/rtx3060.jpg'),
	(2, 'RTX 3060Ti', 18500000, 1, 1, '../src/img/rtx3060ti.jpg');

CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product_category` (`id`, `name`) VALUES
	(1, 'VGA'),
	(2, 'RAM');

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `phone` int(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `supplier` (`id`, `name`, `phone`, `address`) VALUES
	(1, 'NVDIA', 123456789, 'America');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL DEFAULT '1',
  `permission` tinyint(4) NOT NULL DEFAULT 2,
  `id_cust` int(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `fk_cust` (`id_cust`),
  CONSTRAINT `fk_cust` FOREIGN KEY (`id_cust`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `password`, `permission`, `id_cust`) VALUES
	(1, 'admin', '$2y$10$bl9vyL6yst.8H/xpsTJV.u.HS4RnOOkyDX368hUK/qO/kS6tsqZsS', 2, 1),
	(2, 'user1', '$2y$10$9iYwdk1x8/yaOn74lBAioe1IL6.KnF583JhOAy3w7ftYaCmzecHHy', 2, 2),
	(3, 'user2', '$2y$10$RvdmZd8voHrnDjTJslZxfOMw3LCXB6L2whIyz8WKm0mC0V7yoN0MO', 2, 4);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
