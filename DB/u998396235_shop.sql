-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 14, 2024 at 02:57 PM
-- Server version: 10.6.16-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u998396235_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(44) NOT NULL,
  `username` varchar(111) NOT NULL,
  `address` varchar(111) NOT NULL,
  `contactnumber` varchar(14) NOT NULL,
  `location_id` varchar(111) NOT NULL,
  `user_id` int(22) NOT NULL,
  `is_default` varchar(11) DEFAULT NULL,
  `cityname` varchar(122) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `username`, `address`, `contactnumber`, `location_id`, `user_id`, `is_default`, `cityname`) VALUES
(8, 'Asr', '201', '07964573116', '1', 29, NULL, 'London'),
(9, 'addsfd', 'lklklkklk', '01615172892', '1', 1, NULL, 'London'),
(10, 'monir', 'dhaka', '33333333333', '1', 24, NULL, 'London'),
(11, 'Aadf', '12 ghfak', '01615172892', '1', 25, NULL, 'London'),
(12, 'Test', 'Test', '01676415198', '1', 30, 'yes', 'London');

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_assign_customers`
--

CREATE TABLE `affiliate_assign_customers` (
  `id` int(11) NOT NULL,
  `customer_phone` varchar(13) NOT NULL,
  `affiliate_user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `purpose` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `month` varchar(20) NOT NULL,
  `year` year(4) NOT NULL,
  `status` varchar(3) NOT NULL,
  `overtime` int(11) DEFAULT NULL,
  `late` int(11) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `banner_image` text NOT NULL,
  `type` varchar(2) NOT NULL,
  `link` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `banner_image`, `type`, `link`, `created_at`, `updated_at`) VALUES
(2, '170725385162602.jpg', '1', NULL, '2024-02-07 03:10:51', '2024-02-07 03:10:51'),
(3, '17072541859328.jpg', '1', NULL, '2024-02-07 03:16:25', '2024-02-07 03:16:25'),
(8, '170767562122766.jpg', '1', 'https://bazardelivery.com/package', '2024-02-12 00:20:21', '2024-02-12 00:20:21'),
(5, '170727001090739.png', '2', NULL, '2024-02-07 07:40:10', '2024-02-07 07:40:10'),
(9, '170767569285296.png', '2', 'package', '2024-02-12 00:21:32', '2024-02-12 00:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `brand_name` varchar(191) NOT NULL,
  `brand_name_bn` varchar(191) NOT NULL,
  `brand_img` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_name_bn`, `brand_img`) VALUES
(2, 'Bazar Delivery', 'বাজার ডেলিভারি', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `cat_name` varchar(191) NOT NULL,
  `cat_name_bn` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `cat_img` varchar(191) DEFAULT NULL,
  `cat_banner_img` text DEFAULT NULL,
  `cat_icon` varchar(100) NOT NULL,
  `cat_order` int(11) DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`, `cat_name_bn`, `slug`, `cat_img`, `cat_banner_img`, `cat_icon`, `cat_order`, `user_id`) VALUES
(1, 'Package', 'প্যাকেজ', 'package', '170725548174679.jpg', '170725548130002.jpg', '170725548155174.jpg', 1, 1),
(2, 'Fruit and Vegetable', 'ফল এবং সবজি', 'fruit-and-vegetable', '170743100253359.jpg', '17074310018032.jpg', '170743100254146.png', 2, 1),
(3, 'Fresh Meat', 'তাজা মাংস', 'fresh-meat', '170752211927305.jpg', '170752211934391.jpg', '170752211982792.png', 3, 1),
(4, 'Cooking Ingredients', 'রান্নার উপাদান', 'cooking-ingredients', '170752353396234.jpg', '170752353378069.jpg', '170752353331503.png', 4, 1),
(5, 'Frozen Food', 'হিমায়িত খাদ্য', 'frozen-food', '170752450739211.jpg', '170752450767971.jpg', '170752450765251.png', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `child_sub_cats`
--

CREATE TABLE `child_sub_cats` (
  `id` int(10) UNSIGNED NOT NULL,
  `child_cat_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_cat_name_bn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `cat_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collect_due_payment`
--

CREATE TABLE `collect_due_payment` (
  `id` int(11) NOT NULL,
  `pay_amount` double NOT NULL,
  `due_customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(10) NOT NULL,
  `coupon_discount` varchar(30) NOT NULL,
  `accepted_orders_amount` int(11) NOT NULL,
  `not_product_id` varchar(100) DEFAULT NULL,
  `active_from` date NOT NULL,
  `active_until` date NOT NULL,
  `start_time` varchar(10) DEFAULT NULL,
  `end_time` varchar(10) DEFAULT NULL,
  `not_for_valid_products` varchar(200) DEFAULT NULL,
  `minimum_order_amount` double DEFAULT NULL,
  `coupon_used` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_references`
--

CREATE TABLE `customer_references` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `referer_phone` varchar(12) NOT NULL,
  `comment` text DEFAULT NULL,
  `gift_amount` double DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customize_products`
--

CREATE TABLE `customize_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_summary`
--

CREATE TABLE `daily_summary` (
  `id` int(11) NOT NULL,
  `due_amount` varchar(100) NOT NULL,
  `waiting_stock_money` varchar(100) NOT NULL,
  `incomplete_order_amount` varchar(100) NOT NULL,
  `product_stock_amount` varchar(100) NOT NULL,
  `hand_cash` varchar(100) NOT NULL,
  `real_stock_amount` varchar(100) NOT NULL,
  `deposit_amount` double NOT NULL,
  `summary` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damages`
--

CREATE TABLE `damages` (
  `id` int(11) NOT NULL,
  `product_id` varchar(200) NOT NULL,
  `quantity` double NOT NULL,
  `total_price` double NOT NULL,
  `is_deleted` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_locations`
--

CREATE TABLE `delivery_locations` (
  `id` int(11) NOT NULL,
  `location_name_bn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_croatian_ci NOT NULL,
  `postcode` varchar(11) NOT NULL,
  `charge` int(11) NOT NULL,
  `min_order_amount` double DEFAULT 0,
  `extra_fast_delivery_charge` int(11) NOT NULL DEFAULT 0,
  `delivery_time_slot` text DEFAULT NULL,
  `buffering_time_slot` text DEFAULT NULL,
  `water_location_serial` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `start_time` varchar(122) DEFAULT NULL,
  `end_time` varchar(122) DEFAULT NULL,
  `days` varchar(122) DEFAULT NULL,
  `location_name` varchar(122) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `delivery_locations`
--

INSERT INTO `delivery_locations` (`id`, `location_name_bn`, `postcode`, `charge`, `min_order_amount`, `extra_fast_delivery_charge`, `delivery_time_slot`, `buffering_time_slot`, `water_location_serial`, `discount`, `start_time`, `end_time`, `days`, `location_name`) VALUES
(1, 'লন্ডন', 'E1', 10, NULL, 0, NULL, NULL, NULL, 10, '04:00 PM', '11:59 PM', 'Mon,Tue,Wed,Thu,Fri', 'London'),
(2, 'লন্ডন', 'E2', 10, NULL, 0, NULL, NULL, NULL, 10, '04:00 PM', '11:59 PM', 'Mon,Tue,Wed,Thu,Fri', 'London'),
(3, 'লন্ডন', 'E3', 10, NULL, 0, NULL, NULL, NULL, 10, '04:00 PM', '11:59 PM', 'Mon,Tue,Wed,Thu,Fri', 'London');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_mans`
--

CREATE TABLE `delivery_mans` (
  `id` int(11) NOT NULL,
  `name` varchar(44) NOT NULL,
  `phone` varchar(22) NOT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(11) NOT NULL,
  `customer_phone` varchar(13) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `payment_method` text NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_message`
--

CREATE TABLE `deposit_message` (
  `id` int(11) NOT NULL,
  `message_bn` text NOT NULL,
  `message_en` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposit_requests`
--

CREATE TABLE `deposit_requests` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `transaction_id` varchar(20) DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `requestMessage` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `due_customers`
--

CREATE TABLE `due_customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `due_purchase_history`
--

CREATE TABLE `due_purchase_history` (
  `id` int(11) NOT NULL,
  `customer_phone` varchar(13) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `order_date` timestamp NULL DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `due_sales`
--

CREATE TABLE `due_sales` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `order_date` timestamp NULL DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(44) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `join_date` date NOT NULL,
  `address` text NOT NULL,
  `salary` double NOT NULL,
  `hourly_bill` double NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `purpose` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `date` date NOT NULL,
  `type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `salary_month` int(11) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `investor` varchar(200) NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_candidates`
--

CREATE TABLE `job_candidates` (
  `id` int(11) NOT NULL,
  `full_name` text NOT NULL,
  `phone` text NOT NULL,
  `email` int(11) NOT NULL,
  `job_type` text NOT NULL,
  `job_time` text NOT NULL,
  `education` text NOT NULL,
  `vehicle` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `low_stock_products`
--

CREATE TABLE `low_stock_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `map_locations`
--

CREATE TABLE `map_locations` (
  `id` int(11) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `map_url` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketers`
--

CREATE TABLE `marketers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_images`
--

CREATE TABLE `offer_images` (
  `id` int(11) NOT NULL,
  `color` varchar(20) NOT NULL,
  `offer_image` text NOT NULL,
  `url` text DEFAULT NULL,
  `status` varchar(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `open_jobs`
--

CREATE TABLE `open_jobs` (
  `id` int(11) NOT NULL,
  `title_bn` int(11) NOT NULL,
  `description_bn` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `order_by` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_total` double(8,2) NOT NULL,
  `delivery_charge` double(8,2) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `coupon` varchar(15) DEFAULT NULL,
  `coupon_discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `approve_status` tinyint(4) NOT NULL DEFAULT 0,
  `transit_date` timestamp NULL DEFAULT NULL,
  `transit_status` tinyint(4) NOT NULL DEFAULT 0,
  `delivered_status` tinyint(4) NOT NULL DEFAULT 0,
  `approve_date` timestamp NULL DEFAULT NULL,
  `cancel_status` int(11) NOT NULL DEFAULT 0,
  `cancel_date` timestamp NULL DEFAULT NULL,
  `delivered_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `delivery_man_id` int(11) DEFAULT NULL,
  `c_order_received` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_total`, `delivery_charge`, `customer_id`, `coupon`, `coupon_discount_amount`, `approve_status`, `transit_date`, `transit_status`, `delivered_status`, `approve_date`, `cancel_status`, `cancel_date`, `delivered_date`, `created_at`, `updated_at`, `active_status`, `notes`, `user_id`, `delivery_man_id`, `c_order_received`) VALUES
(1, 4.45, 10.00, 1, '0', 0.00, 1, NULL, 0, 0, '2024-02-13 09:02:15', 0, NULL, NULL, '2024-02-12 23:10:28', '2024-02-13 09:02:15', 1, NULL, 1, 1, NULL),
(2, 1.45, 10.00, 1, '0', 0.00, 0, NULL, 0, 0, NULL, 1, '2024-02-13 09:01:41', NULL, '2024-02-12 23:12:12', '2024-02-13 09:01:41', 4, NULL, 1, 1, NULL),
(3, 210.00, 10.00, 1, '0', 0.00, 1, NULL, 0, 0, '2024-02-12 23:40:44', 0, NULL, NULL, '2024-02-12 23:29:40', '2024-02-12 23:40:44', 1, NULL, 1, 1, NULL),
(4, 0.00, 10.00, 25, '0', 0.00, 0, NULL, 0, 0, NULL, 1, '2024-02-13 09:03:25', NULL, '2024-02-13 08:58:20', '2024-02-13 09:03:25', 4, NULL, 25, NULL, NULL),
(5, 199.00, 10.00, 25, '0', 0.00, 1, NULL, 0, 0, '2024-02-13 09:05:38', 0, NULL, NULL, '2024-02-13 09:04:13', '2024-02-13 09:05:38', 1, NULL, 1, 1, NULL),
(6, 199.00, 10.00, 25, '0', 0.00, 0, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-02-13 09:10:59', '2024-02-13 09:10:59', 0, NULL, NULL, NULL, NULL),
(7, 199.00, 10.00, 25, '0', 0.00, 0, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-02-13 09:12:39', '2024-02-13 09:12:39', 0, NULL, NULL, NULL, NULL),
(8, 1.45, 10.00, 1, '0', 0.00, 0, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-02-13 10:19:29', '2024-02-13 10:19:29', 0, NULL, NULL, NULL, NULL),
(9, 3.00, 10.00, 24, '0', 0.00, 0, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-02-13 19:25:50', '2024-02-13 19:25:50', 0, NULL, NULL, NULL, NULL),
(10, 1.45, 0.00, 29, '0', 0.00, 0, NULL, 0, 0, NULL, 0, NULL, NULL, '2024-02-13 21:17:33', '2024-02-13 21:17:33', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double(8,2) NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `total_buy_price` double DEFAULT 0,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `custom_name_en` text DEFAULT NULL,
  `custom_name_bn` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `total_buy_price`, `customer_id`, `custom_name_en`, `custom_name_bn`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 1.45, 1.45, 0, 1, NULL, NULL, '2024-02-12 23:10:28', '2024-02-12 23:10:28'),
(2, 1, 5, 1, 3.00, 3.00, 0, 1, NULL, NULL, '2024-02-12 23:10:28', '2024-02-12 23:10:28'),
(3, 2, 4, 1, 1.45, 1.45, 0, 1, NULL, NULL, '2024-02-12 23:12:12', '2024-02-12 23:12:12'),
(4, 3, 2, 1, 210.00, 210.00, 0, 1, NULL, NULL, '2024-02-12 23:29:40', '2024-02-12 23:29:40'),
(5, 5, 7, 1, 199.00, 199.00, 0, 25, NULL, NULL, '2024-02-13 09:04:13', '2024-02-13 09:04:13'),
(6, 6, 7, 1, 199.00, 199.00, 0, 25, NULL, NULL, '2024-02-13 09:10:59', '2024-02-13 09:10:59'),
(7, 7, 7, 1, 199.00, 199.00, 0, 25, NULL, NULL, '2024-02-13 09:12:39', '2024-02-13 09:12:39'),
(8, 8, 4, 1, 1.45, 1.45, 0, 1, NULL, NULL, '2024-02-13 10:19:29', '2024-02-13 10:19:29'),
(9, 9, 5, 1, 3.00, 3.00, 0, 24, NULL, NULL, '2024-02-13 19:25:50', '2024-02-13 19:25:50'),
(10, 10, 4, 1, 1.45, 1.45, 0, 29, NULL, NULL, '2024-02-13 21:17:33', '2024-02-13 21:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `other_incomes`
--

CREATE TABLE `other_incomes` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` double NOT NULL,
  `purpose` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otptokens`
--

CREATE TABLE `otptokens` (
  `id` int(11) NOT NULL,
  `token` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `payment_type` int(10) UNSIGNED NOT NULL,
  `transaction_number` varchar(15) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_amount`, `payment_type`, `transaction_number`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 1, 14.45, 1, '14', 1, NULL, NULL),
(2, 2, 11.45, 1, '23', 1, NULL, NULL),
(3, 3, 220.00, 1, '33', 1, NULL, NULL),
(4, 4, 10.00, 1, '44', 25, NULL, NULL),
(5, 5, 209.00, 1, '53', 25, NULL, NULL),
(6, 6, 209.00, 1, '62', 25, NULL, NULL),
(7, 7, 209.00, 1, '73', 25, NULL, NULL),
(8, 8, 11.45, 1, '83', 1, NULL, NULL),
(9, 9, 13.00, 1, '92', 24, NULL, NULL),
(10, 10, 1.45, 1, '103', 29, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_type_name` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`id`, `payment_type_name`) VALUES
(1, 'Cash On Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `file` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `name_bn` varchar(191) NOT NULL,
  `tags` varchar(191) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `price` double(8,2) NOT NULL,
  `buy_price` double DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `unit` varchar(191) NOT NULL,
  `unit_quantity` varchar(200) NOT NULL,
  `stock_quantity` double(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `sub_category_id` varchar(100) DEFAULT NULL,
  `child_sub_cats_id` varchar(100) DEFAULT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `featured_image` varchar(191) NOT NULL,
  `gp_image_1` varchar(191) DEFAULT NULL,
  `gp_image_2` varchar(191) DEFAULT NULL,
  `gp_image_3` varchar(191) DEFAULT NULL,
  `gp_image_4` varchar(191) DEFAULT NULL,
  `generic_name` varchar(100) DEFAULT NULL,
  `strength` varchar(20) DEFAULT NULL,
  `dosages_description` varchar(44) DEFAULT NULL,
  `use_for` varchar(20) DEFAULT NULL,
  `DAR` varchar(22) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `inactive_search` varchar(10) DEFAULT NULL,
  `is_featured` int(11) NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL,
  `real_stock` int(11) NOT NULL DEFAULT 0 COMMENT '1 is real stock active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `name_bn`, `tags`, `slug`, `price`, `buy_price`, `discount`, `unit`, `unit_quantity`, `stock_quantity`, `status`, `category_id`, `sub_category_id`, `child_sub_cats_id`, `brand_id`, `featured_image`, `gp_image_1`, `gp_image_2`, `gp_image_3`, `gp_image_4`, `generic_name`, `strength`, `dosages_description`, `use_for`, `DAR`, `description`, `restaurant_id`, `inactive_search`, `is_featured`, `user_id`, `real_stock`, `created_at`, `updated_at`) VALUES
(4, 'Banana', 'কলা', 'Banana, কলা', 'banana-156', 1.45, 0, 0.00, 'kg', '1', 17.00, 1, 2, '1', '', 2, '170743764990060.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p><span style=\"color: rgb(103, 114, 121); font-family: &quot;Gill Sans Nova&quot;, sans-serif; font-size: 16px;\">Fresh and exotic bananas. Sweet and ripe.</span><br></p>', NULL, NULL, 0, 1, 0, '2024-02-09 06:14:09', '2024-02-09 06:14:09'),
(5, 'Fresh Oranges', 'তাজা কমলা', 'Oranges, কমলা', 'fresh-oranges-191', 3.00, 0, 0.00, 'kg', '1', 18.00, 1, 2, '1', '', 2, '170743818232915.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p><span style=\"color: rgb(103, 114, 121); font-family: &quot;Gill Sans Nova&quot;, sans-serif; font-size: 16px;\">Fresh Oranges(Per Kg),&nbsp;are a popular winter fruit that looks and tastes just like oranges.&nbsp;</span><br></p>', NULL, NULL, 0, 1, 0, '2024-02-09 06:23:02', '2024-02-09 06:23:02'),
(6, 'Tilda Basmati Rice', 'তিলদা বাসমতি চাল', 'Tilda, Tilda Basmati Rice, Basmati Rice', 'tilda-basmati-rice-35', 2.49, NULL, 0.00, 'gm', '500', 20000.00, 1, 7, '', '', 2, '170767538139394.jpg', '17076753816712.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p><b><span style=\"color: rgb(103, 114, 121); font-family: &quot;Gill Sans Nova&quot;, sans-serif; font-size: 16px;\">﻿</span><span style=\"color: inherit; font-family: &quot;Gill Sans Nova&quot;, sans-serif; font-size: calc(var(--base-text-font-size) - (var(--default-text-font-size) - 25px));\">Tilda Basmati Rice</span></b></p><p><span style=\"color: rgb(103, 114, 121); font-family: &quot;Gill Sans Nova&quot;, sans-serif; font-size: 16px;\">This unique grain is known for its tantalising flavour, magical aroma and delicate fluffy texture. Like champagne, Pure Basmati rice can only be grown and harvested in one place on Earth, at the foothills of the Himalayas. Our grains are purity tested, as we believe only Pure Basmati has the unique characteristics.</span><br></p>', NULL, NULL, 0, 1, 0, '2024-02-12 00:16:21', '2024-02-12 00:16:21'),
(7, 'BUGGET PACKAGE', 'বাজেট প্যাকেজ', 'BUGGET PACKAGE, বাজেট প্যাকেজ', 'bugget-package-165', 230.00, 0, 31.00, 'pcs', '1', 47.00, 1, 1, '', '', 2, '170777096622888.jpg', '170777096665237.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>1. <b>Hilsha Fish:</b> 800g | 2. <b>Promfret fish:&nbsp;</b>800-1000g | 3 .<b>Mix Beef:</b> 5kg | 4. <b>Mix lamb:</b> 5kg&nbsp; | 5. <b>Roster Chicken:</b> 6pc | 6. <b>Red Chicken :</b> 6pc&nbsp; | 7. <b>Ruah afza drink :</b> 1pc | 8. <b>Chilli Powder:</b> 1kg | 9. <b>Turmeric Powder: </b>1kg | 10 <b>Hot Masala Powder:</b> 1kg | 11. <b>Red Lentil :</b> 1kg | 12. <b>Papa Gram Flour:</b> 1kg | 13. <b>Vegetable oil:</b> 5L | 14. Dates: 900 gm | 15. <b>Laccha Semai :</b> 2pack | 16. <b>Basmoti rice :</b> 10kg | 17. <b>Black Check peas can:</b>12pcs | 18. <b>White Chek peas can:</b> 12pcs | 19. <b>Puffed Rice:</b> 1kg | 20.<b> Lentil:</b> 1 KG<br></p>', NULL, NULL, 1, 1, 0, '2024-02-13 02:49:26', '2024-02-13 02:49:26'),
(8, 'FAMILY PACKAGE', 'ফ্যামিলি প্যাকেজ', 'FAMILY PACKAGE, ফ্যামিলি প্যাকেজ', 'family-package-93', 280.00, 0, 31.00, 'pcs', '1', 50.00, 1, 1, '', '', 2, '170777165631620.jpg', '170777165688966.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>1. <b>Hilsha Fish:</b> 800g+ | 2. <b>Promfret fish :</b> 800-1000g | 3. <b>Mix Beef:</b> 5kg | 4. <b>Mix lamb:</b> 5kg | 5. <b>Roster Chicken :</b> 6pc | 6. <b>Red Chicken : </b>6pc | 7. <b>Vege somosa : </b>50pc | 8.<b> Meat somosa :</b> 50pc&nbsp; | 9. <b>Chicken Nuggets: </b>1 pack | 10. <b>Ruah afza drink : </b>1pc | 11. <b>Chilli Powder: </b>1kg | 12. <b>Turmeric Powder: </b>1kg | 13. <b>Hot Masala Powder:</b> 1kg | 14. <b>Papa Gram Flour: </b>1kg | 15. <b>Sugar :</b> 1kg | 16. Butter <b>Ghee:</b> 1kg&nbsp; | 17. <b>Vegetable oil:</b> 5L | 18.<b> Dates:</b> 900 gm | 19. <b>Chick Peas:</b> 2kg | 20. <b>Lentil: </b>2kg | 21. <b>Laccha Semai : </b>3pack | 22.<b> Basmoti rice : </b>10kg | 23. <b>Black Check peas can:</b> 12pcs | 24. <b>White Chek peas can: </b>12pcs | 25. <b>Puffed Rice:</b> 1kg&nbsp;</p>', NULL, NULL, 1, 1, 0, '2024-02-13 03:00:56', '2024-02-13 03:00:56'),
(9, 'PREMIUM PACKAGE', 'প্রিমিয়াম প্যাকেজ', 'PREMIUM PACKAGE, প্রিমিয়াম প্যাকেজ', 'premium-package-213', 420.00, 0, 50.00, 'pcs', '1', 50.00, 1, 1, '', '', 2, '170777241249656.jpg', '170777241214620.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>1.&nbsp;<span style=\"font-weight: 700;\">Hilsha Fish</span>&nbsp;800g+ X 2 | 2.&nbsp;<span style=\"font-weight: 700;\">Promfret fish</span>&nbsp;800-1000g X2 | 3.&nbsp;<span style=\"font-weight: 700;\">Mix Beef&nbsp;</span>5kg| 4.&nbsp;<span style=\"font-weight: 700;\">Mix lamb</span>&nbsp;5kg | 5.&nbsp;<span style=\"font-weight: 700;\">Roster Chicken</span>&nbsp;10pc | 6.&nbsp;<span style=\"font-weight: 700;\">Red Chicken</span>&nbsp;6pc | 7.&nbsp;<span style=\"font-weight: 700;\">Vege somosa</span>&nbsp;50pc | 8.&nbsp;<span style=\"font-weight: 700;\">Meat somosa</span>&nbsp;50pc | 9.&nbsp;<span style=\"font-weight: 700;\">Chicken Nuggets</span>&nbsp;3pack | 10.<span style=\"font-weight: 700;\">Ruah afza drink</span>&nbsp;2pc | 11.&nbsp;<span style=\"font-weight: 700;\">Chilli Powder</span>&nbsp;1kg&nbsp; | 12.&nbsp;<span style=\"font-weight: 700;\">Turmeric Powder</span>&nbsp;1kg | 13.&nbsp;<span style=\"font-weight: 700;\">Hot Masala Powder&nbsp;</span>1kg | 14.&nbsp;<span style=\"font-weight: 700;\">Papa Gram Flour</span>&nbsp;1kg | 15.<span style=\"font-weight: 700;\">&nbsp;Sugar</span>&nbsp;1kg | 16.&nbsp;<span style=\"font-weight: 700;\">Butter Ghee</span>&nbsp;1kg | 17.&nbsp;<span style=\"font-weight: 700;\">Vegetable oil</span>&nbsp;5L&nbsp; | 18.&nbsp;<span style=\"font-weight: 700;\">Olive virgin oil</span>&nbsp;5L | 19.&nbsp;<span style=\"font-weight: 700;\">Dates</span>&nbsp;900gm x 2&nbsp; | 20.&nbsp;<span style=\"font-weight: 700;\">Chick Peas</span>&nbsp;2kg&nbsp; | 21.&nbsp;<span style=\"font-weight: 700;\">Lentil</span>&nbsp;2kg | 22.&nbsp;<span style=\"font-weight: 700;\">Laccha Semai</span>&nbsp;7pack | 23.<span style=\"font-weight: 700;\">&nbsp;Basmoti rice</span>&nbsp;20kg | 24.&nbsp;<span style=\"font-weight: 700;\">Black Chek peas can:</span>&nbsp;12pcs | 25.&nbsp;<span style=\"font-weight: 700;\">White Chek peas can:&nbsp;</span>12pcs | 26.&nbsp;<span style=\"font-weight: 700;\">Prawn pack</span>&nbsp;500gm+ x3&nbsp; | 27.&nbsp;<span style=\"font-weight: 700;\">Puffed Rice&nbsp;</span>1kg x 2<br></p>', NULL, NULL, 1, 1, 0, '2024-02-13 03:13:32', '2024-02-13 03:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `products_temp_stock`
--

CREATE TABLE `products_temp_stock` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_buy_price` double NOT NULL,
  `expire_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_requests`
--

CREATE TABLE `product_requests` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `price` double NOT NULL,
  `expire_date` date NOT NULL,
  `old_stock` double DEFAULT NULL,
  `old_buy_price` double DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_locations`
--

CREATE TABLE `product_stock_locations` (
  `id` int(11) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `rak_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regular_products`
--

CREATE TABLE `regular_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `restaurant_name_en` varchar(200) NOT NULL,
  `restaurant_name_bn` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `slug` varchar(100) NOT NULL,
  `address_en` varchar(100) NOT NULL,
  `address_bn` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `area` varchar(191) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `address` varchar(191) NOT NULL,
  `delivery_time` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shippings`
--

INSERT INTO `shippings` (`id`, `order_id`, `name`, `phone`, `area`, `area_id`, `address`, `delivery_time`, `created_at`, `updated_at`) VALUES
(5, 5, 'monir', '01911311175', 'Dhaka', 1, 'bd', '0', '2024-01-26 15:08:36', '2024-01-26 15:08:36'),
(6, 6, 'monir', '01911311175', 'Dhaka', 1, 'bd', '0', '2024-01-26 15:10:51', '2024-01-26 15:10:51'),
(7, 7, 'monir', '09999999999', 'Dhaka', 1, 'khulna', '0', '2024-01-29 13:01:23', '2024-01-29 13:01:23'),
(8, 8, 'monir', '09999999999', 'Dhaka', 1, 'khulna', '0', '2024-01-29 17:45:16', '2024-01-29 17:45:16'),
(9, 9, 'monir', '09999999999', 'Dhaka', 1, 'khulna', '0', '2024-01-29 17:46:20', '2024-01-29 17:46:20'),
(10, 1, 'Md MOnirul Islam77', '01911311175', 'London', 1, 'dhaka', '0', '2024-02-12 23:10:28', '2024-02-12 23:10:28'),
(11, 2, 'Md MOnirul Islam77', '01911311175', 'London', 1, 'dhaka', '0', '2024-02-12 23:12:12', '2024-02-12 23:12:12'),
(12, 3, 'Md MOnirul Islam77', '01911311175', 'London', 1, 'dhaka', '0', '2024-02-12 23:29:40', '2024-02-12 23:29:40'),
(13, 4, 'asd', '01235469887', 'London', 1, 'Block:B House no :68 Southbonosree Project,Goran', '0', '2024-02-13 08:58:20', '2024-02-13 08:58:20'),
(14, 5, 'asd', '01235469887', 'London', 1, 'Block:B House no :68 Southbonosree Project,Goran', '0', '2024-02-13 09:04:13', '2024-02-13 09:04:13'),
(15, 6, 'asd', '01235469887', 'London', 1, 'Block:B House no :68 Southbonosree Project,Goran', '0', '2024-02-13 09:10:59', '2024-02-13 09:10:59'),
(16, 7, 'asd', '01235469887', 'London', 1, 'Block:B House no :68 Southbonosree Project,Goran', '0', '2024-02-13 09:12:39', '2024-02-13 09:12:39'),
(17, 8, 'Md MOnirul Islam77', '01911311175', 'London', 1, 'dhaka', '0', '2024-02-13 10:19:29', '2024-02-13 10:19:29'),
(18, 9, 'abu', '789', 'London', 1, 'dhaka', '0', '2024-02-13 19:25:50', '2024-02-13 19:25:50'),
(19, 10, 'Asr', '0796457316', 'London', 1, '201', '0', '2024-02-13 21:17:33', '2024-02-13 21:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `shop_customize_products`
--

CREATE TABLE `shop_customize_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_expenses`
--

CREATE TABLE `shop_expenses` (
  `id` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_investments`
--

CREATE TABLE `shop_investments` (
  `id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `type` varchar(100) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `today_extra_money` varchar(3) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_low_stock_products`
--

CREATE TABLE `shop_low_stock_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_orders`
--

CREATE TABLE `shop_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_total` double(8,2) NOT NULL,
  `delivery_charge` double(8,2) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `coupon` varchar(15) DEFAULT NULL,
  `coupon_discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `approve_status` tinyint(4) NOT NULL DEFAULT 0,
  `transit_date` timestamp NULL DEFAULT NULL,
  `transit_status` tinyint(4) NOT NULL DEFAULT 0,
  `delivered_status` tinyint(4) NOT NULL DEFAULT 0,
  `approve_date` timestamp NULL DEFAULT NULL,
  `cancel_status` int(11) NOT NULL DEFAULT 0,
  `cancel_date` timestamp NULL DEFAULT NULL,
  `delivered_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `delivery_man_id` int(11) DEFAULT NULL,
  `c_order_received` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_order_items`
--

CREATE TABLE `shop_order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double(8,2) NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `total_buy_price` double DEFAULT 0,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `custom_name_en` text DEFAULT NULL,
  `custom_name_bn` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_payments`
--

CREATE TABLE `shop_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `payment_amount` double(8,2) NOT NULL,
  `payment_type` int(10) UNSIGNED NOT NULL,
  `transaction_number` varchar(15) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_products`
--

CREATE TABLE `shop_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `name_bn` varchar(191) NOT NULL,
  `tags` varchar(191) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `price` double(8,2) NOT NULL,
  `buy_price` double DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `unit` varchar(191) NOT NULL,
  `unit_quantity` varchar(200) NOT NULL,
  `stock_quantity` double(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `sub_category_id` varchar(100) DEFAULT NULL,
  `child_sub_cats_id` varchar(100) DEFAULT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `featured_image` varchar(191) NOT NULL,
  `gp_image_1` varchar(191) DEFAULT NULL,
  `gp_image_2` varchar(191) DEFAULT NULL,
  `gp_image_3` varchar(191) DEFAULT NULL,
  `gp_image_4` varchar(191) DEFAULT NULL,
  `generic_name` varchar(100) DEFAULT NULL,
  `strength` varchar(20) DEFAULT NULL,
  `dosages_description` varchar(44) DEFAULT NULL,
  `use_for` varchar(20) DEFAULT NULL,
  `DAR` varchar(22) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `inactive_search` varchar(10) DEFAULT NULL,
  `is_featured` int(11) NOT NULL DEFAULT 0,
  `user_id` int(10) UNSIGNED NOT NULL,
  `real_stock` int(11) NOT NULL DEFAULT 0 COMMENT '1 is real stock active',
  `shop_id` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_product_stocks`
--

CREATE TABLE `shop_product_stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL,
  `price` double NOT NULL,
  `expire_date` date NOT NULL,
  `old_stock` double DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_shippings`
--

CREATE TABLE `shop_shippings` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `area` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_histories`
--

CREATE TABLE `sms_histories` (
  `id` int(11) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `sms_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `send_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_money`
--

CREATE TABLE `stock_money` (
  `id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `type` varchar(100) NOT NULL COMMENT 'money-plus,money-minus',
  `purpose` text NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `sub_cat_name` varchar(191) NOT NULL,
  `sub_cat_name_bn` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `banner` text DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `serial` int(11) DEFAULT NULL,
  `cat_image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `sub_cat_name`, `sub_cat_name_bn`, `slug`, `category_id`, `banner`, `user_id`, `serial`, `cat_image`) VALUES
(1, 'Fresh Fruits', 'তাজা ফল', 'fresh-fruits', 2, '170743125211375.jpg', 1, NULL, '170743125273682.jpg'),
(2, 'Fresh Vegetables', 'তাজা সবজি', 'fresh-vegetables', 2, '17074317357842.jpg', 1, NULL, '170743173597104.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `temp_instock_products`
--

CREATE TABLE `temp_instock_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_sms_histories`
--

CREATE TABLE `temp_sms_histories` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `text` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `send_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms_conditions`
--

CREATE TABLE `terms_conditions` (
  `id` int(11) NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trashes`
--

CREATE TABLE `trashes` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` varchar(111) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(10) UNSIGNED NOT NULL,
  `unit_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `created_at`, `updated_at`) VALUES
(1, 'gm', '2024-01-17 14:59:43', '2024-01-17 14:59:43'),
(2, 'kg', '2024-01-17 15:00:01', '2024-01-17 15:00:01'),
(3, 'liter', '2024-01-17 15:00:11', '2024-01-17 15:00:11'),
(4, 'pcs', '2024-01-17 15:00:24', '2024-01-17 15:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `role` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `area` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `phone`, `email_verified_at`, `password`, `area`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Md MOnirul Islam77', 'admin', 'monirjss@gmail.com', '01911311175', NULL, '$2y$10$ld.Iue9.Hvyumz7QG/.3reF0ruLZebq2VQXF8L5ZMYjcv69ORh2pK', 'Burashi ( বুড়াশি )', 'Dhaka', '3M6ycjWWch0GxR4Cr4YXklrOTAtzC3HmB8vtSIxVk1Ndk05EC1Ix1MyHxIHW', '2020-04-24 04:00:00', '2024-01-14 10:08:28'),
(12, 'Abu Ronee', '3', NULL, '7964573116', NULL, '$2y$10$f1DnwHVbSQEtseGlBWyEoOaqLghBkoKd/GVJ.6KEpfB57ulHl4GY2', NULL, NULL, NULL, '2024-02-12 18:50:01', '2024-02-12 18:50:01'),
(13, 'abu', '3', NULL, '07964573116', NULL, '$2y$10$riILTunyqquxpjOn/lfm/.i88AZbQkNe4M7egCXkjV5Sux45bcsZS', NULL, NULL, NULL, '2024-02-12 23:44:42', '2024-02-12 23:44:42'),
(14, 'adsgg', '3', NULL, '01615142892', NULL, '$2y$10$t2uUKzXmvgqLUU2LqOscMOnA/TPV3KDCDjJrhpwGgl01mYW9sfo0G', NULL, NULL, NULL, '2024-02-12 23:47:31', '2024-02-12 23:47:31'),
(19, 'Md Abu Nowshad Miah', '3', NULL, '07853599450', NULL, '$2y$10$fRE2tbQs0pTbBpBtV7Fctu6LTfSad0Ma653moD7mXBmpKWYjDdV8q', NULL, NULL, NULL, '2024-02-12 23:54:10', '2024-02-12 23:54:10'),
(20, 'adsf', '3', NULL, '01915172892', NULL, '$2y$10$noXAch9M96U6XVzwPf/ciea/W5WKW1poOgdD7mRsvr8TRjokA2cs6', NULL, NULL, NULL, '2024-02-13 00:15:15', '2024-02-13 00:15:15'),
(21, 'ont', '3', NULL, '01715172892', NULL, '$2y$10$.RgrrzouhfFpEPFJps5mFuF5VqkgRXreTvep.TlS/Jm/tt.r8IKvu', NULL, NULL, NULL, '2024-02-13 00:18:37', '2024-02-13 00:18:37'),
(22, 'kjiuy', '3', NULL, '01615172892', NULL, '$2y$10$OaREqIRQs8jn8CZ/63EemOI7bNmzc4hYr7EeSTWLJFtSenNpu6Gie', NULL, NULL, NULL, '2024-02-13 00:22:30', '2024-02-13 00:22:30'),
(23, 'monir', '3', NULL, '01988788888', NULL, '$2y$10$14xNmpgefnDw1WGC2tRQzePfvvDTGy8QbnHlS1qzHNFnLEWwseo0.', NULL, NULL, NULL, '2024-02-13 00:28:50', '2024-02-13 00:28:50'),
(24, 'abu', '3', 'a@gmail.com', '789', NULL, '$2y$10$rV6pSb2lbbM0tQvs/grypuoKm5p1if2NO6tseT5TCxhZ0akZD9G2G', NULL, NULL, NULL, '2024-02-13 00:40:05', '2024-02-13 00:40:05'),
(25, 'asd', '3', 'ony.cse@yahoo.com', '01235469887', NULL, '$2y$10$xVv25ahiIxYIyPMZ4HPCJOSglIj1IGp5v4SBADKmOPvGaRFMpkD7K', NULL, NULL, NULL, '2024-02-13 00:43:55', '2024-02-13 00:43:55'),
(29, 'Asr', '3', 'asronee1989@gmail.com', '0796457316', NULL, '$2y$10$l/VZ6UdmczrEo1QSo4H.cuxC/6YY9hZnzwKgOPeGYeT58meHPUTrW', NULL, NULL, NULL, '2024-02-13 21:04:40', '2024-02-13 21:04:40'),
(30, 'HASNAIN RAHMAN', '3', 'hrahman.2k11@gmail.com', '01676415198', NULL, '$2y$10$VvgL.quW8wHN6KxdAz3EZuVGXcECLl85jVWtxGkB9.mDeqr2/PKVC', NULL, NULL, NULL, '2024-02-14 00:15:50', '2024-02-14 00:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_requests`
--

CREATE TABLE `vendor_requests` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waiting_stocks`
--

CREATE TABLE `waiting_stocks` (
  `id` int(11) NOT NULL,
  `product_id` varchar(200) NOT NULL,
  `quantity` double NOT NULL,
  `total_price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waters`
--

CREATE TABLE `waters` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` varchar(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `d_1_sell` int(11) DEFAULT 0,
  `d_1_in` int(11) DEFAULT 0,
  `d_2_sell` int(11) DEFAULT 0,
  `d_2_in` int(11) DEFAULT 0,
  `d_3_sell` int(11) DEFAULT 0,
  `d_3_in` int(11) DEFAULT 0,
  `d_4_sell` int(11) DEFAULT 0,
  `d_4_in` int(11) DEFAULT 0,
  `d_5_sell` int(11) DEFAULT 0,
  `d_5_in` int(11) DEFAULT 0,
  `d_6_sell` int(11) DEFAULT 0,
  `d_6_in` int(11) DEFAULT 0,
  `d_7_sell` int(11) DEFAULT 0,
  `d_7_in` int(11) DEFAULT 0,
  `d_8_sell` int(11) DEFAULT 0,
  `d_8_in` int(11) DEFAULT 0,
  `d_9_sell` int(11) DEFAULT 0,
  `d_9_in` int(11) DEFAULT 0,
  `d_10_sell` int(11) DEFAULT 0,
  `d_10_in` int(11) DEFAULT 0,
  `d_11_sell` int(11) DEFAULT 0,
  `d_11_in` int(11) DEFAULT 0,
  `d_12_sell` int(11) DEFAULT 0,
  `d_12_in` int(11) DEFAULT 0,
  `d_13_sell` int(11) DEFAULT 0,
  `d_13_in` int(11) DEFAULT 0,
  `d_14_sell` int(11) DEFAULT 0,
  `d_14_in` int(11) DEFAULT 0,
  `d_15_sell` int(11) DEFAULT 0,
  `d_15_in` int(11) DEFAULT 0,
  `d_16_sell` int(11) DEFAULT 0,
  `d_16_in` int(11) DEFAULT 0,
  `d_17_sell` int(11) DEFAULT 0,
  `d_17_in` int(11) DEFAULT 0,
  `d_18_sell` int(11) DEFAULT 0,
  `d_18_in` int(11) DEFAULT 0,
  `d_19_sell` int(11) DEFAULT 0,
  `d_19_in` int(11) DEFAULT 0,
  `d_20_sell` int(11) DEFAULT 0,
  `d_20_in` int(11) DEFAULT 0,
  `d_21_sell` int(11) DEFAULT 0,
  `d_21_in` int(11) DEFAULT 0,
  `d_22_sell` int(11) DEFAULT 0,
  `d_22_in` int(11) DEFAULT 0,
  `d_23_sell` int(11) DEFAULT 0,
  `d_23_in` int(11) DEFAULT 0,
  `d_24_sell` int(11) DEFAULT 0,
  `d_24_in` int(11) DEFAULT 0,
  `d_25_sell` int(11) DEFAULT 0,
  `d_25_in` int(11) DEFAULT 0,
  `d_26_sell` int(11) DEFAULT 0,
  `d_26_in` int(11) DEFAULT 0,
  `d_27_sell` int(11) DEFAULT 0,
  `d_27_in` int(11) DEFAULT 0,
  `d_28_sell` int(11) DEFAULT 0,
  `d_28_in` int(11) DEFAULT 0,
  `d_29_sell` int(11) DEFAULT 0,
  `d_29_in` int(11) DEFAULT 0,
  `d_30_sell` int(11) DEFAULT 0,
  `d_30_in` int(11) DEFAULT 0,
  `d_31_sell` int(11) DEFAULT 0,
  `d_31_in` int(11) DEFAULT 0,
  `c1` text DEFAULT NULL,
  `c2` text DEFAULT NULL,
  `c3` text DEFAULT NULL,
  `c4` text DEFAULT NULL,
  `c5` text DEFAULT NULL,
  `c6` text DEFAULT NULL,
  `c7` text DEFAULT NULL,
  `c8` text DEFAULT NULL,
  `c9` text DEFAULT NULL,
  `c10` text DEFAULT NULL,
  `c11` text DEFAULT NULL,
  `c12` text DEFAULT NULL,
  `c13` text DEFAULT NULL,
  `c14` text DEFAULT NULL,
  `c15` text DEFAULT NULL,
  `c16` text DEFAULT NULL,
  `c17` text DEFAULT NULL,
  `c18` text DEFAULT NULL,
  `c19` text DEFAULT NULL,
  `c20` text DEFAULT NULL,
  `c21` text DEFAULT NULL,
  `c22` text DEFAULT NULL,
  `c23` text DEFAULT NULL,
  `c24` text DEFAULT NULL,
  `c25` text DEFAULT NULL,
  `c26` text DEFAULT NULL,
  `c27` text DEFAULT NULL,
  `c28` text DEFAULT NULL,
  `c29` text DEFAULT NULL,
  `c30` text DEFAULT NULL,
  `c31` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `water_customers`
--

CREATE TABLE `water_customers` (
  `id` int(11) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `area_id` int(11) NOT NULL,
  `address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `price` int(11) DEFAULT NULL,
  `jar` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_assign_customers`
--
ALTER TABLE `affiliate_assign_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_phone` (`customer_phone`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_brand_name_unique` (`brand_name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `child_sub_cats`
--
ALTER TABLE `child_sub_cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collect_due_payment`
--
ALTER TABLE `collect_due_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- Indexes for table `customer_references`
--
ALTER TABLE `customer_references`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referer_phone` (`referer_phone`);

--
-- Indexes for table `customize_products`
--
ALTER TABLE `customize_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `daily_summary`
--
ALTER TABLE `daily_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damages`
--
ALTER TABLE `damages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_locations`
--
ALTER TABLE `delivery_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_mans`
--
ALTER TABLE `delivery_mans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_message`
--
ALTER TABLE `deposit_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_requests`
--
ALTER TABLE `deposit_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `due_customers`
--
ALTER TABLE `due_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `due_purchase_history`
--
ALTER TABLE `due_purchase_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `due_sales`
--
ALTER TABLE `due_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_candidates`
--
ALTER TABLE `job_candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `low_stock_products`
--
ALTER TABLE `low_stock_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_locations`
--
ALTER TABLE `map_locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `marketers`
--
ALTER TABLE `marketers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_images`
--
ALTER TABLE `offer_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `other_incomes`
--
ALTER TABLE `other_incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otptokens`
--
ALTER TABLE `otptokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_payment_type_foreign` (`payment_type`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_user_id_foreign` (`user_id`),
  ADD KEY `name` (`name`),
  ADD KEY `name_bn` (`name_bn`),
  ADD KEY `tags` (`tags`),
  ADD KEY `slug` (`slug`);

--
-- Indexes for table `products_temp_stock`
--
ALTER TABLE `products_temp_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_requests`
--
ALTER TABLE `product_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stock_locations`
--
ALTER TABLE `product_stock_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regular_products`
--
ALTER TABLE `regular_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shippings_order_id_foreign` (`order_id`);

--
-- Indexes for table `shop_customize_products`
--
ALTER TABLE `shop_customize_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_expenses`
--
ALTER TABLE `shop_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_investments`
--
ALTER TABLE `shop_investments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_low_stock_products`
--
ALTER TABLE `shop_low_stock_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_orders`
--
ALTER TABLE `shop_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `shop_order_items`
--
ALTER TABLE `shop_order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_payments`
--
ALTER TABLE `shop_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_products`
--
ALTER TABLE `shop_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_user_id_foreign` (`user_id`),
  ADD KEY `name` (`name`),
  ADD KEY `name_bn` (`name_bn`),
  ADD KEY `tags` (`tags`),
  ADD KEY `slug` (`slug`);

--
-- Indexes for table `shop_product_stocks`
--
ALTER TABLE `shop_product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_shippings`
--
ALTER TABLE `shop_shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_histories`
--
ALTER TABLE `sms_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_money`
--
ALTER TABLE `stock_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_instock_products`
--
ALTER TABLE `temp_instock_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_sms_histories`
--
ALTER TABLE `temp_sms_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trashes`
--
ALTER TABLE `trashes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_unit_name_unique` (`unit_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `vendor_requests`
--
ALTER TABLE `vendor_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waiting_stocks`
--
ALTER TABLE `waiting_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waters`
--
ALTER TABLE `waters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `water_customers`
--
ALTER TABLE `water_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(44) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `affiliate_assign_customers`
--
ALTER TABLE `affiliate_assign_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `child_sub_cats`
--
ALTER TABLE `child_sub_cats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `collect_due_payment`
--
ALTER TABLE `collect_due_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_references`
--
ALTER TABLE `customer_references`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customize_products`
--
ALTER TABLE `customize_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_summary`
--
ALTER TABLE `daily_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damages`
--
ALTER TABLE `damages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_locations`
--
ALTER TABLE `delivery_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_mans`
--
ALTER TABLE `delivery_mans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit_message`
--
ALTER TABLE `deposit_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit_requests`
--
ALTER TABLE `deposit_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `due_customers`
--
ALTER TABLE `due_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `due_purchase_history`
--
ALTER TABLE `due_purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `due_sales`
--
ALTER TABLE `due_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_candidates`
--
ALTER TABLE `job_candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `low_stock_products`
--
ALTER TABLE `low_stock_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `map_locations`
--
ALTER TABLE `map_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketers`
--
ALTER TABLE `marketers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_images`
--
ALTER TABLE `offer_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `other_incomes`
--
ALTER TABLE `other_incomes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otptokens`
--
ALTER TABLE `otptokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products_temp_stock`
--
ALTER TABLE `products_temp_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_requests`
--
ALTER TABLE `product_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_stock_locations`
--
ALTER TABLE `product_stock_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regular_products`
--
ALTER TABLE `regular_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `shop_customize_products`
--
ALTER TABLE `shop_customize_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_expenses`
--
ALTER TABLE `shop_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_investments`
--
ALTER TABLE `shop_investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_low_stock_products`
--
ALTER TABLE `shop_low_stock_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_orders`
--
ALTER TABLE `shop_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_order_items`
--
ALTER TABLE `shop_order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_payments`
--
ALTER TABLE `shop_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_products`
--
ALTER TABLE `shop_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_product_stocks`
--
ALTER TABLE `shop_product_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_shippings`
--
ALTER TABLE `shop_shippings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_histories`
--
ALTER TABLE `sms_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_money`
--
ALTER TABLE `stock_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `temp_instock_products`
--
ALTER TABLE `temp_instock_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_sms_histories`
--
ALTER TABLE `temp_sms_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trashes`
--
ALTER TABLE `trashes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `vendor_requests`
--
ALTER TABLE `vendor_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waiting_stocks`
--
ALTER TABLE `waiting_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waters`
--
ALTER TABLE `waters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `water_customers`
--
ALTER TABLE `water_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_payment_type_foreign` FOREIGN KEY (`payment_type`) REFERENCES `payment_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shippings`
--
ALTER TABLE `shippings`
  ADD CONSTRAINT `shippings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
