-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 04, 2025 at 06:24 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Database: `mealitup`
--
CREATE DATABASE IF NOT EXISTS `mealitup` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `mealitup`;
-- --------------------------------------------------------
--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_unicode_ci;
--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`)
VALUES (
    'DoctrineMigrations\\Version20250504055728',
    '2025-05-04 05:57:55',
    88
  ),
  (
    'DoctrineMigrations\\Version20250504072826',
    '2025-05-04 07:28:34',
    26
  );
-- --------------------------------------------------------
--
-- Table structure for table `meal_plan`
--

CREATE TABLE `meal_plan` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `meal_date` date NOT NULL,
  `mealtime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `meal_plan`
--

INSERT INTO `meal_plan` (
    `id`,
    `user_id`,
    `recipe_id`,
    `meal_date`,
    `mealtime`
  )
VALUES (2, 1, 5, '2025-05-06', 'lunch'),
  (3, 1, 7, '2025-05-04', 'lunch'),
  (4, 1, 6, '2025-05-04', 'dinner'),
  (5, 1, 5, '2025-04-30', 'lunch'),
  (6, 1, 6, '2025-05-04', 'supper'),
  (7, 2, 5, '2025-05-04', 'dinner'),
  (8, 2, 10, '2025-05-05', 'breakfast'),
  (9, 2, 7, '2025-05-05', 'lunch'),
  (10, 2, 9, '2025-05-05', 'dinner'),
  (11, 1, 8, '2025-05-05', 'lunch');
-- --------------------------------------------------------
--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `id` int NOT NULL,
  `created_by_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredients` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `preparation_time` int NOT NULL,
  `calories` int NOT NULL,
  `is_vegetarian` tinyint(1) NOT NULL,
  `is_vegan` tinyint(1) NOT NULL,
  `allergens` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nutrients` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `external_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_by_admin` tinyint(1) NOT NULL,
  `average_rating` double NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (
    `id`,
    `created_by_id`,
    `title`,
    `description`,
    `ingredients`,
    `preparation_time`,
    `calories`,
    `is_vegetarian`,
    `is_vegan`,
    `allergens`,
    `nutrients`,
    `external_link`,
    `approved_by_admin`,
    `average_rating`,
    `image`
  )
VALUES (
    5,
    1,
    'Vegan Chickpea Curry',
    'A hearty, spicy curry made with chickpeas, tomatoes, and coconut milk.',
    'Chickpeas, Coconut Milk, Tomato, Onion, Garlic, Curry Powder',
    30,
    380,
    1,
    1,
    'None',
    'Protein, Fiber, Iron',
    'http://chickpea-curry',
    1,
    3,
    'curry-7249242-1280-681738c99b756.jpg'
  ),
  (
    6,
    1,
    'Caprese Pasta Salad',
    'A light and fresh vegetarian salad with tomatoes, basil, and mozzarella.',
    'Pasta, Cherry Tomatoes, Mozzarella, Basil, Olive Oil',
    20,
    450,
    1,
    0,
    'Dairy, Gluten',
    'Calcium, Vitamin C, Carbohydrates',
    'http://caprese-salad',
    1,
    4.5,
    'salad-6900127-1280-681739761a6da.jpg'
  ),
  (
    7,
    1,
    'Creamy Chicken Alfredo',
    'A rich pasta dish with grilled chicken and creamy Alfredo sauce.',
    'Chicken Breast, Pasta, Cream, Parmesan, Garlic',
    35,
    720,
    0,
    0,
    'Dairy, Gluten',
    'Protein, Fat, Calcium',
    'http://chicken-alfredo',
    1,
    4,
    'pasta-7475756-1280-68173a03e25c1.jpg'
  ),
  (
    8,
    2,
    'Grilled Chicken Lettuce Wraps',
    'Light and protein-packed wraps served in crisp lettuce leaves.',
    'Chicken breast, romaine lettuce, garlic, lemon juice, olive oil, pepper',
    25,
    190,
    0,
    0,
    'none',
    'Protein, Vitamin A, Iron',
    'http://chicken-wraps',
    1,
    5,
    'ai-generated-8331065-1280-6817704a3f649.jpg'
  ),
  (
    9,
    2,
    'Zucchini Noodle Caprese',
    'A fresh take on Caprese with spiralized zucchini, cherry tomatoes, and mozzarella.',
    'Zucchini, cherry tomatoes, mozzarella, basil, balsamic glaze',
    15,
    170,
    1,
    0,
    'Dairy',
    'Calcium, Vitamin C',
    'http://zoodle-caprese',
    1,
    5,
    'food-4612333-1280-681774b31c33b.jpg'
  ),
  (
    10,
    2,
    'Avocado Cucumber Salad',
    'Crisp cucumbers, creamy avocado, and lime for a refreshing vegan dish.',
    'Avocado, cucumber, red onion, lime juice, cilantro',
    10,
    180,
    0,
    1,
    'none',
    'Fiber, Healthy fats, Vitamin K',
    'http://avocado-cucumber',
    1,
    4,
    'salat-3946232-1280-681775c62abd6.jpg'
  );
-- --------------------------------------------------------
--
-- Table structure for table `recipe_rating`
--

CREATE TABLE `recipe_rating` (
  `id` int NOT NULL,
  `recipe_id` int NOT NULL,
  `user_id` int NOT NULL,
  `stars` int NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `recipe_rating`
--

INSERT INTO `recipe_rating` (
    `id`,
    `recipe_id`,
    `user_id`,
    `stars`,
    `created_at`
  )
VALUES (1, 6, 1, 5, '2025-05-04 13:04:02'),
  (2, 5, 1, 5, '2025-05-04 13:05:46'),
  (3, 7, 1, 5, '2025-05-04 13:04:12'),
  (4, 5, 2, 1, '2025-05-04 13:50:49'),
  (5, 6, 2, 4, '2025-05-04 14:16:44'),
  (6, 7, 2, 3, '2025-05-04 13:08:10'),
  (7, 9, 2, 5, '2025-05-04 17:46:33'),
  (8, 10, 2, 4, '2025-05-04 14:13:53');
-- --------------------------------------------------------
--
-- Table structure for table `shopping_list`
--

CREATE TABLE `shopping_list` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredients_list` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- --------------------------------------------------------
--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_blocked` tinyint(1) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (
    `id`,
    `username`,
    `email`,
    `roles`,
    `password`,
    `is_blocked`
  )
VALUES (
    1,
    'SvetlanaShmeleva',
    'svetlana@mealitup.com',
    '[]',
    '$2y$13$zbGs5rbHsgXYlkZhQ19rX.z4fPJ/xUDfqfanbPl/Ctj9jI3RsyS5a',
    0
  ),
  (
    2,
    'admin',
    'admin@mealitup.com',
    '[\"ROLE_ADMIN\"]',
    '$2y$13$R9/eobUbTKolaCGwjIkMquEYNzu3jyKQC4j1wz0SKV9fMqYeZAs1q',
    0
  );
--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
ADD PRIMARY KEY (`version`);
--
-- Indexes for table `meal_plan`
--
ALTER TABLE `meal_plan`
ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C7848889A76ED395` (`user_id`),
  ADD KEY `IDX_C784888959D8A214` (`recipe_id`);
--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);
--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DA88B137B03A8386` (`created_by_id`);
--
-- Indexes for table `recipe_rating`
--
ALTER TABLE `recipe_rating`
ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5597380359D8A214` (`recipe_id`),
  ADD KEY `IDX_55973803A76ED395` (`user_id`);
--
-- Indexes for table `shopping_list`
--
ALTER TABLE `shopping_list`
ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3DC1A459A76ED395` (`user_id`);
--
-- Indexes for table `user`
--
ALTER TABLE `user`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meal_plan`
--
ALTER TABLE `meal_plan`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 12;
--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
MODIFY `id` bigint NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 11;
--
-- AUTO_INCREMENT for table `recipe_rating`
--
ALTER TABLE `recipe_rating`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 9;
--
-- AUTO_INCREMENT for table `shopping_list`
--
ALTER TABLE `shopping_list`
MODIFY `id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `meal_plan`
--
ALTER TABLE `meal_plan`
ADD CONSTRAINT `FK_C784888959D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`),
  ADD CONSTRAINT `FK_C7848889A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
ADD CONSTRAINT `FK_DA88B137B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`);
--
-- Constraints for table `recipe_rating`
--
ALTER TABLE `recipe_rating`
ADD CONSTRAINT `FK_5597380359D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`),
  ADD CONSTRAINT `FK_55973803A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
--
-- Constraints for table `shopping_list`
--
ALTER TABLE `shopping_list`
ADD CONSTRAINT `FK_3DC1A459A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;