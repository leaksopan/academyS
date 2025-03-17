-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 02:26 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academys`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`) VALUES
(1, 'Web Development', 'web-development', 'Learn how to build websites and web applications', '2025-03-14 02:28:30'),
(2, 'Data Science', 'data-science', 'Learn how to analyze and visualize data', '2025-03-14 02:28:30'),
(3, 'Mobile Development', 'mobile-development', 'Learn how to build mobile applications', '2025-03-14 02:28:30'),
(4, 'Magang', 'magang', 'Ini untuk magang', '2025-03-13 20:42:58');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `level` enum('beginner','intermediate','advanced') DEFAULT 'beginner',
  `image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slug`, `description`, `category_id`, `level`, `image`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'HTML & CSS Basics', 'html-css-basics', 'Learn the fundamentals of HTML and CSS to build beautiful websites', 1, 'beginner', NULL, 1, '2025-03-14 02:28:30', NULL),
(2, 'JavaScript Fundamentals', 'javascript-fundamentals', 'Master the basics of JavaScript programming', 1, 'beginner', NULL, 1, '2025-03-14 02:28:30', NULL),
(3, 'Python for Data Science', 'python-data-science', 'Learn how to use Python for data analysis and visualization', 2, 'intermediate', NULL, 1, '2025-03-14 02:28:30', NULL),
(4, 'React Native Essentials', 'react-native-essentials', 'Build cross-platform mobile apps with React Native', 3, 'intermediate', NULL, 0, '2025-03-14 02:28:30', NULL),
(5, 'Kursus Mobil', 'kursus-mobil', 'Asd', 2, 'beginner', NULL, 1, '2025-03-13 19:35:50', NULL),
(6, 'Magang Divisi Meta', 'magang-divisi-meta', 'Course ini di ambil untuk anak magang divisi Meta', 4, 'beginner', NULL, 1, '2025-03-13 20:16:38', '2025-03-13 20:50:00'),
(7, '[Magang] Pengenalan Teknologi PHP', 'magang-pengenalan-teknologi-php', 'Hari pertama.Ambil ini jika ini adalah hari pertamamu disini', 4, 'beginner', '8e86428f6fc480ba5c0bae58f9e2decd.png', 1, '2025-03-13 21:11:24', NULL),
(8, 'Test Quiz', 'test-quiz', 'asd', 4, 'intermediate', '1b1e180278f282d1e1949016bf109c42.png', 1, '2025-03-13 23:41:48', '2025-03-13 23:41:53'),
(9, '[Quiz] Magang', 'quiz-magang', 'Apa ya', 4, 'intermediate', NULL, 1, '2025-03-14 01:08:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `enrolled_at`) VALUES
(1, 2, 1, '2025-03-14 02:28:30'),
(2, 2, 2, '2025-03-14 02:28:30'),
(3, 1, 1, '2025-03-13 20:05:08'),
(4, 1, 6, '2025-03-13 20:20:12'),
(5, 2, 7, '2025-03-13 22:46:13'),
(6, 1, 8, '2025-03-13 23:46:48'),
(7, 1, 9, '2025-03-14 01:14:49'),
(8, 2, 8, '2025-03-16 18:01:51'),
(9, 2, 9, '2025-03-16 18:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `order_number` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `content`, `order_number`, `created_at`) VALUES
(1, 1, 'Introduction to HTML', '<h1>Introduction to HTML</h1><p>HTML (HyperText Markup Language) is the standard markup language for creating web pages.</p>', 1, '2025-03-14 02:28:30'),
(2, 1, 'HTML Elements', '<h1>HTML Elements</h1><p>HTML elements are represented by tags and are the building blocks of HTML pages.</p>', 2, '2025-03-14 02:28:30'),
(3, 1, 'CSS Basics', '<h1>CSS Basics</h1><p>CSS (Cascading Style Sheets) is used to style HTML elements.</p>', 3, '2025-03-14 02:28:30'),
(4, 2, 'JavaScript Variables', '<h1>JavaScript Variables</h1><p>Variables are containers for storing data values.</p>', 1, '2025-03-14 02:28:30'),
(5, 2, 'JavaScript Functions', '<h1>JavaScript Functions</h1><p>A JavaScript function is a block of code designed to perform a particular task.</p>', 2, '2025-03-14 02:28:30'),
(6, 3, 'Python Basics', '<h1>Python Basics</h1><p>Python is a popular programming language for data science.</p>', 1, '2025-03-14 02:28:30'),
(7, 3, 'NumPy Introduction', '<h1>NumPy Introduction</h1><p>NumPy is a library for the Python programming language, adding support for large, multi-dimensional arrays and matrices.</p>', 2, '2025-03-14 02:28:30'),
(8, 4, 'React Native Setup', '<h1>React Native Setup</h1><p>Learn how to set up your development environment for React Native.</p>', 1, '2025-03-14 02:28:30'),
(9, 6, 'Perkenalan', 'Ini berisikan berkenalan ', 1, '2025-03-13 20:19:30'),
(10, 7, 'asd', 'asdasd', 1, '2025-03-13 22:48:41'),
(11, 8, 'Quiz', 'asd', 1, '2025-03-13 23:42:30'),
(12, 8, 'Quiz', 'asd', 1, '2025-03-13 23:46:31'),
(13, 8, 'Test 1', 'asd', 3, '2025-03-14 00:10:43'),
(14, 8, 'Quiz 2', 'asd', 4, '2025-03-14 00:17:16'),
(15, 9, 'PHP Array [Quiz]', 'Ini adaah quiz untuk PHP Array', 1, '2025-03-14 01:08:57'),
(16, 9, 'HTML Quiz', 'Quiz untuk HTML Magang', 3, '2025-03-14 01:44:29');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`id`, `user_id`, `lesson_id`, `completed`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, '2025-03-14 05:37:41', '2025-03-14 02:28:30'),
(2, 2, 2, 1, '2025-03-14 05:37:41', '2025-03-14 02:28:30'),
(3, 2, 3, 0, '2025-03-14 05:37:41', '2025-03-14 02:28:30'),
(4, 2, 4, 0, '2025-03-14 05:37:41', '2025-03-14 02:28:30'),
(5, 1, 1, 1, '2025-03-13 22:38:56', '2025-03-13 22:38:56'),
(6, 1, 2, 1, '2025-03-13 22:39:18', '2025-03-13 22:39:18'),
(7, 1, 3, 1, '2025-03-13 22:39:20', '2025-03-13 22:39:20'),
(8, 1, 9, 1, '2025-03-13 22:45:24', '2025-03-13 22:45:24'),
(9, 2, 10, 1, '2025-03-13 22:49:16', '2025-03-13 22:49:16'),
(10, 1, 10, 1, '2025-03-13 23:41:15', '2025-03-13 23:41:15'),
(11, 1, 16, 1, '2025-03-14 01:46:33', '2025-03-14 01:55:13'),
(12, 2, 16, 1, '2025-03-16 18:01:35', '2025-03-16 18:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` enum('multiple_choice','essay') NOT NULL,
  `points` int(11) DEFAULT 10,
  `order_number` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `question_type`, `points`, `order_number`, `created_at`) VALUES
(1, 1, 'apa itu PHP', 'multiple_choice', 100, 1, '2025-03-13 23:42:30'),
(2, 2, 'apa itu PHP', 'multiple_choice', 100, 1, '2025-03-13 23:46:31'),
(3, 3, 'Apa itu HTML?', 'multiple_choice', 10, 1, '2025-03-14 07:07:56'),
(4, 4, 'asd', 'multiple_choice', 100, 1, '2025-03-14 00:10:43'),
(5, 5, 'Ini test harunnya ke database', 'multiple_choice', 100, 1, '2025-03-14 00:17:16'),
(6, 6, 'What does HTML stand for?', 'multiple_choice', 10, 1, '2025-03-14 07:40:24'),
(7, 7, 'Apa itu array', 'multiple_choice', 50, 1, '2025-03-14 01:10:05'),
(8, 7, 'Contoh array bagaimana', 'multiple_choice', 50, 1, '2025-03-14 01:14:00'),
(9, 8, 'Apa itu html', 'multiple_choice', 50, 1, '2025-03-14 01:45:42'),
(10, 8, 'HTML digunakan untuk apa', 'multiple_choice', 50, 1, '2025-03-14 01:46:01');

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE `question_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `order_number` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_options`
--

INSERT INTO `question_options` (`id`, `question_id`, `option_text`, `is_correct`, `order_number`, `created_at`) VALUES
(1, 2, 'gatau', 0, 1, '2025-03-14 06:59:04'),
(2, 2, 'PHP', 1, 2, '2025-03-14 06:59:04'),
(3, 3, 'Hypertext Markup Language', 1, 1, '2025-03-14 07:08:10'),
(4, 3, 'High-level Text Machine Language', 0, 2, '2025-03-14 07:08:10'),
(5, 3, 'Hyperlink and Text Markup Language', 0, 3, '2025-03-14 07:08:10'),
(6, 4, '10', 0, 1, '2025-03-14 00:10:43'),
(7, 4, '100', 1, 2, '2025-03-14 00:10:43'),
(8, 5, 'Test ke database', 0, 1, '2025-03-14 00:17:16'),
(9, 5, 'Test ke database sql 1', 1, 2, '2025-03-14 00:17:16'),
(10, 6, 'Hypertext Markup Language', 1, 1, '2025-03-14 07:40:46'),
(11, 6, 'High-level Text Machine Language', 0, 2, '2025-03-14 07:40:46'),
(12, 6, 'Hyperlink and Text Markup Language', 0, 3, '2025-03-14 07:40:46'),
(13, 7, '1', 0, 1, '2025-03-14 01:10:05'),
(14, 7, '2', 0, 2, '2025-03-14 01:10:05'),
(15, 7, '3', 0, 3, '2025-03-14 01:10:05'),
(16, 7, 'Array adalah array', 1, 4, '2025-03-14 01:10:05'),
(17, 8, '1', 0, 1, '2025-03-14 01:14:00'),
(18, 8, '1', 0, 2, '2025-03-14 01:14:00'),
(19, 8, '1', 0, 3, '2025-03-14 01:14:00'),
(20, 8, 'begini conthnya', 1, 4, '2025-03-14 01:14:00'),
(21, 9, '1', 0, 1, '2025-03-14 01:45:42'),
(22, 9, '1', 0, 2, '2025-03-14 01:45:42'),
(23, 9, '1', 0, 3, '2025-03-14 01:45:42'),
(24, 9, 'HTML adalah', 1, 4, '2025-03-14 01:45:42'),
(25, 10, '1', 0, 1, '2025-03-14 01:46:01'),
(26, 10, '1', 0, 2, '2025-03-14 01:46:01'),
(27, 10, '1', 0, 3, '2025-03-14 01:46:01'),
(28, 10, 'UNtuk Membaut web', 1, 4, '2025-03-14 01:46:01');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `passing_score` int(11) DEFAULT 70,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `lesson_id`, `title`, `description`, `passing_score`, `created_at`, `updated_at`) VALUES
(1, 14, 'Quiz: Quiz', 'Quiz untuk pelajaran: Quiz', 100, '2025-03-13 23:42:30', NULL),
(2, 1, 'Quiz: Quiz', 'Quiz untuk pelajaran: Quiz', 100, '2025-03-13 23:46:31', NULL),
(3, 11, 'Quiz: Test Quiz', 'Quiz untuk pelajaran: Test Quiz', 70, '2025-03-14 07:07:35', NULL),
(4, 1, 'Quiz: Test 1', 'Quiz untuk pelajaran: Test 1', 100, '2025-03-14 00:10:43', NULL),
(5, 1, 'Quiz: Quiz 2', 'Quiz untuk pelajaran: Quiz 2', 100, '2025-03-14 00:17:16', NULL),
(6, 1, 'Quiz HTML Introduction', 'Test your knowledge about HTML basics', 70, '2025-03-14 07:40:00', NULL),
(7, 15, 'PHP Array', 'Ini untuk PHP array', 100, '2025-03-14 01:09:33', NULL),
(8, 16, 'HTML Quiz', 'HTML untuk quiz', 70, '2025-03-14 01:45:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` decimal(5,2) DEFAULT 0.00,
  `passed` tinyint(1) DEFAULT 0,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `user_id`, `quiz_id`, `score`, `passed`, `completed_at`) VALUES
(5, 1, 7, '90.91', 0, '2025-03-14 08:40:18'),
(6, 1, 7, '0.00', 0, '2025-03-14 08:40:26'),
(7, 1, 7, '9.09', 0, '2025-03-14 08:40:39'),
(8, 1, 7, '90.91', 0, '2025-03-14 08:40:50'),
(9, 1, 8, '83.33', 1, '2025-03-14 08:46:33'),
(10, 1, 8, '0.00', 0, '2025-03-14 08:53:38'),
(11, 1, 8, '16.67', 0, '2025-03-14 08:53:48'),
(12, 1, 8, '50.00', 0, '2025-03-14 08:54:58'),
(13, 1, 8, '50.00', 0, '2025-03-14 08:55:08'),
(14, 1, 8, '100.00', 1, '2025-03-14 08:55:13'),
(15, 2, 8, '100.00', 1, '2025-03-17 01:01:35'),
(16, 2, 8, '0.00', 0, '2025-03-17 01:02:31'),
(17, 2, 8, '50.00', 0, '2025-03-17 01:02:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `is_active`, `created_at`) VALUES
(1, 'admin', 'admin@academys.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, '2025-03-14 02:28:30'),
(2, 'user1', 'user1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 1, '2025-03-14 02:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL,
  `attempt_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_option_id` int(11) DEFAULT NULL,
  `essay_answer` text DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `points_earned` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `attempt_id`, `question_id`, `selected_option_id`, `essay_answer`, `is_correct`, `points_earned`) VALUES
(7, 5, 7, 16, NULL, 1, 100),
(8, 5, 8, 20, NULL, 0, 0),
(9, 6, 7, 15, NULL, 0, 0),
(10, 6, 8, 20, NULL, 0, 0),
(11, 7, 7, 13, NULL, 0, 0),
(12, 7, 8, 17, NULL, 1, 10),
(13, 8, 7, 16, NULL, 1, 100),
(14, 8, 8, 18, NULL, 0, 0),
(15, 9, 9, 24, NULL, 1, 50),
(16, 9, 10, 28, NULL, 0, 0),
(17, 10, 9, 21, NULL, 0, 0),
(18, 10, 10, 28, NULL, 0, 0),
(19, 11, 9, 21, NULL, 0, 0),
(20, 11, 10, 25, NULL, 1, 10),
(21, 12, 9, 23, NULL, 0, 0),
(22, 12, 10, 28, NULL, 1, 50),
(23, 13, 9, 23, NULL, 0, 0),
(24, 13, 10, 28, NULL, 1, 50),
(25, 14, 9, 24, NULL, 1, 50),
(26, 14, 10, 28, NULL, 1, 50),
(27, 15, 9, 24, NULL, 1, 50),
(28, 15, 10, 28, NULL, 1, 50),
(29, 16, 9, 23, NULL, 0, 0),
(30, 16, 10, 27, NULL, 0, 0),
(31, 17, 9, 24, NULL, 1, 50),
(32, 17, 10, 25, NULL, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`lesson_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attempt_id` (`attempt_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `selected_option_id` (`selected_option_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progress_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `question_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD CONSTRAINT `quiz_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_attempts_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `user_answers_ibfk_1` FOREIGN KEY (`attempt_id`) REFERENCES `quiz_attempts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answers_ibfk_3` FOREIGN KEY (`selected_option_id`) REFERENCES `question_options` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
