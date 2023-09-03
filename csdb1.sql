-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Sep 03, 2023 at 03:14 PM
-- Server version: 10.6.5-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `csdb1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

DROP TABLE IF EXISTS `tbl_accounts`;
CREATE TABLE IF NOT EXISTS `tbl_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

DROP TABLE IF EXISTS `tbl_categories`;
CREATE TABLE IF NOT EXISTS `tbl_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

DROP TABLE IF EXISTS `tbl_inventory`;
CREATE TABLE IF NOT EXISTS `tbl_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `supplier_product_number` varchar(100) NOT NULL,
  `order_uom` varchar(10) NOT NULL,
  `cost` double NOT NULL,
  `stock_factor` int(11) NOT NULL,
  `issue_uom` varchar(10) NOT NULL,
  `par_level` int(11) NOT NULL,
  `on_hand` int(11) NOT NULL,
  `price` double NOT NULL,
  `stockroom_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_po_lines`
--

DROP TABLE IF EXISTS `tbl_po_lines`;
CREATE TABLE IF NOT EXISTS `tbl_po_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `stockroom_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `supplier_product_number` varchar(100) NOT NULL,
  `stock_factor` int(11) NOT NULL,
  `order_uom` varchar(10) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `received` int(11) NOT NULL DEFAULT 0,
  `cost` double NOT NULL,
  `inventory_account` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

DROP TABLE IF EXISTS `tbl_products`;
CREATE TABLE IF NOT EXISTS `tbl_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `supplier_product_number` varchar(100) NOT NULL,
  `order_uom` varchar(10) NOT NULL,
  `cost` double NOT NULL,
  `stock_factor` int(11) NOT NULL,
  `issue_uom` varchar(10) NOT NULL,
  `price` double NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_orders`
--

DROP TABLE IF EXISTS `tbl_purchase_orders`;
CREATE TABLE IF NOT EXISTS `tbl_purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `stockroom_id` int(11) NOT NULL,
  `stockroom` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `open_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `closed_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stockroom`
--

DROP TABLE IF EXISTS `tbl_stockroom`;
CREATE TABLE IF NOT EXISTS `tbl_stockroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stockroom` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_stockroom`
--

INSERT INTO `tbl_stockroom` (`id`, `stockroom`, `description`) VALUES
(1, 'Central Supply Lodge', 'Main stock room at lodge with lodge only supplies'),
(3, 'Central Supply PR ', 'Main stock room at lodge with PR only supplies');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

DROP TABLE IF EXISTS `tbl_supplier`;
CREATE TABLE IF NOT EXISTS `tbl_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier` varchar(50) NOT NULL,
  `account` varchar(100) NOT NULL,
  `contact_first_name` varchar(50) NOT NULL,
  `contact_last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `corp_phone` varchar(20) NOT NULL,
  `street_address` varchar(100) NOT NULL,
  `street_address_line_2` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `postal` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

DROP TABLE IF EXISTS `tbl_transactions`;
CREATE TABLE IF NOT EXISTS `tbl_transactions` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `supplier` varchar(100) NOT NULL,
  `supplier_product_number` varchar(100) NOT NULL,
  `stock_factor` int(11) DEFAULT NULL,
  `issue_quantity` int(11) DEFAULT NULL,
  `issue_uom` varchar(10) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `charge_account` varchar(100) DEFAULT NULL,
  `order_quantity` int(11) DEFAULT NULL,
  `received` int(11) DEFAULT NULL,
  `order_uom` varchar(10) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `inventory_account` varchar(100) NOT NULL,
  `tran_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_uom`
--

DROP TABLE IF EXISTS `tbl_uom`;
CREATE TABLE IF NOT EXISTS `tbl_uom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uom` varchar(5) DEFAULT NULL,
  `description` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tbl_uom`
--

INSERT INTO `tbl_uom` (`id`, `uom`, `description`) VALUES
(2, 'BKT', 'Bucket'),
(3, 'BND', 'Bundle'),
(4, 'BOWL', 'Bowl'),
(5, 'BX', 'Box'),
(6, 'CRD', 'Card'),
(7, 'CM', 'Centimeters'),
(8, 'CS', 'Case'),
(9, 'CTN', 'Carton'),
(10, 'DZ', 'Dozen'),
(11, 'EA', 'Each'),
(12, 'FT', 'Foot'),
(13, 'GAL', 'Gallon'),
(14, 'GROSS', 'Gross'),
(15, 'IN', 'Inches'),
(16, 'KIT', 'Kit'),
(17, 'LOT', 'Lot'),
(18, 'M', 'Meter'),
(19, 'MM', 'Millimeter'),
(20, 'PC', 'Piece'),
(21, 'PK', 'Pack'),
(22, 'PK100', 'Pack 100'),
(23, 'PK50', 'Pack 50'),
(24, 'PR', 'Pair'),
(25, 'RACK', 'Rack'),
(26, 'RL', 'Roll'),
(27, 'SET', 'Set'),
(28, 'SET3', 'Set of 3'),
(29, 'SET4', 'Set of 4'),
(30, 'SET5', 'Set of 5'),
(31, 'SGL', 'Single'),
(32, 'SHT', 'Sheet'),
(33, 'SQFT', 'Square ft'),
(34, 'TUBE', 'Tube'),
(35, 'YD', 'Yard');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
