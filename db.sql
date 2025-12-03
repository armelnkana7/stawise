-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table statwise.audit_logs
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `action` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resource_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `audit_logs_chk_1` CHECK (json_valid(`details`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.audit_logs: ~0 rows (approximately)

-- Dumping structure for table statwise.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `establishment_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `section` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `establishment_id` (`establishment_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `classes_chk_1` CHECK (json_valid(`meta`))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.classes: ~2 rows (approximately)
INSERT INTO `classes` (`id`, `establishment_id`, `name`, `code`, `grade_level`, `department_id`, `section`, `meta`, `created_at`) VALUES
	(1, 1, '6e A', '6e', '1', 1, '1', NULL, '2025-11-29 17:18:24'),
	(2, 2, 'Cinquième ', '5e', NULL, NULL, '1', NULL, '2025-12-01 13:45:13');

-- Dumping structure for table statwise.class_subjects
CREATE TABLE IF NOT EXISTS `class_subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `teacher_user_id` int DEFAULT NULL,
  `planned_hours_per_week` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_class_subject` (`class_id`,`subject_id`),
  KEY `subject_id` (`subject_id`),
  KEY `teacher_user_id` (`teacher_user_id`),
  CONSTRAINT `class_subjects_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_subjects_ibfk_3` FOREIGN KEY (`teacher_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.class_subjects: ~0 rows (approximately)

-- Dumping structure for table statwise.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `establishment_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_user_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `establishment_id` (`establishment_id`),
  CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.departments: ~3 rows (approximately)
INSERT INTO `departments` (`id`, `establishment_id`, `name`, `code`, `head_user_id`, `created_at`) VALUES
	(1, 1, 'Mathématiques', NULL, NULL, '2025-11-29 17:17:48'),
	(2, 1, 'ANGLAIS', 'ANG', NULL, '2025-12-01 14:09:56'),
	(3, 1, 'FRANCAIS', 'FRAN', NULL, '2025-12-01 14:15:27'),
	(4, 1, 'PHYSIQUE', 'PHY', NULL, '2025-12-03 13:02:49');

-- Dumping structure for table statwise.establishments
CREATE TABLE IF NOT EXISTS `establishments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `establishments_chk_1` CHECK (json_valid(`meta`))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.establishments: ~2 rows (approximately)
INSERT INTO `establishments` (`id`, `name`, `code`, `address`, `phone`, `email`, `meta`, `created_at`) VALUES
	(1, 'StatWise Demo', 'kk', 'kk', NULL, NULL, NULL, '2025-11-29 15:36:22'),
	(2, 'COLLEGE ADVENTISTE BILINGUE NDINGA DE BATOURI', NULL, NULL, NULL, NULL, NULL, '2025-12-01 13:22:46');

-- Dumping structure for table statwise.programs
CREATE TABLE IF NOT EXISTS `programs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `establishment_id` int NOT NULL,
  `classe_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `nbr_hours` int NOT NULL,
  `nbr_lesson` int NOT NULL,
  `nbr_lesson_dig` int NOT NULL,
  `nbr_tp` int NOT NULL,
  `nbr_tp_dig` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `classe_id` (`classe_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `programs_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.programs: ~5 rows (approximately)
INSERT INTO `programs` (`id`, `establishment_id`, `classe_id`, `subject_id`, `nbr_hours`, `nbr_lesson`, `nbr_lesson_dig`, `nbr_tp`, `nbr_tp_dig`, `created_at`) VALUES
	(1, 1, 1, 1, 10, 10, 10, 10, 10, '2025-12-01 13:26:23'),
	(2, 1, 2, 4, 10, 10, 10, 10, 10, '2025-12-01 14:16:33'),
	(3, 1, 2, 3, 0, 0, 0, 0, 0, '2025-12-01 14:17:21'),
	(4, 1, 2, 1, 0, 0, 0, 0, 0, '2025-12-01 14:17:26'),
	(5, 1, 2, 2, 0, 0, 0, 0, 0, '2025-12-01 14:17:35'),
	(6, 1, 1, 2, 10, 10, 10, 10, 10, '2025-12-03 12:58:23'),
	(7, 1, 1, 3, 10, 10, 10, 15, 20, '2025-12-03 12:59:18'),
	(8, 1, 1, 5, 40, 10, 1, 6, 6, '2025-12-03 13:03:47'),
	(9, 1, 1, 6, 40, 10, 1, 1, 1, '2025-12-03 13:06:46');

-- Dumping structure for table statwise.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.roles: ~5 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `description`, `created_at`) VALUES
	(1, 'Admin', 'Administrateur avec toutes les permissions', '2025-11-29 15:20:10'),
	(2, 'superadmin', 'Super administrateur avec accès à toutes les fonctionnalités', '2025-11-29 14:20:10'),
	(3, 'censeur', 'Administrateur d\'un établissement; peut gérer tout concernant son établissement', '2025-11-29 14:21:00'),
	(4, 'chef_departement', 'Chef du département; peut consulter et remplir les rapports pour son département', '2025-11-29 14:21:10'),
	(5, 'Lycée Technique', NULL, '2025-12-01 13:02:59');

-- Dumping structure for table statwise.school_years
CREATE TABLE IF NOT EXISTS `school_years` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.school_years: ~1 rows (approximately)
INSERT INTO `school_years` (`id`, `title`, `start_date`, `end_date`, `is_active`, `created_at`) VALUES
	(1, '2025-2026', '2025-09-01', '2026-06-30', 0, '2025-11-29 17:23:22');

-- Dumping structure for table statwise.subjects
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `department_id` int DEFAULT NULL,
  `establishment_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  KEY `establishment_id` (`establishment_id`),
  CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.subjects: ~4 rows (approximately)
INSERT INTO `subjects` (`id`, `code`, `name`, `description`, `department_id`, `establishment_id`, `created_at`) VALUES
	(1, 'MAT', 'Mathematiques', NULL, 1, 1, '2025-11-29 17:18:49'),
	(2, 'Sci', 'Science', 'Science', 1, 1, '2025-12-01 14:03:27'),
	(3, 'ANG', 'ANGLAIS', 'ANGLAIS', 2, 1, '2025-12-01 14:09:32'),
	(4, 'FRAN', 'FRANCAIS', 'FRANCAIS', 3, 1, '2025-12-01 14:15:04'),
	(5, 'PHY', 'PHYSIQUE', 'PHYSIQUE', 4, 1, '2025-12-03 13:03:05'),
	(6, 'CHI', 'CHIMIE', 'CHIMIE', 4, 1, '2025-12-03 13:06:09');

-- Dumping structure for table statwise.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `establishment_id` int DEFAULT NULL,
  `role_id` int NOT NULL,
  `department_id` int DEFAULT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`id`),
  KEY `establishment_id` (`establishment_id`),
  KEY `role_id` (`role_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `users_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_chk_1` CHECK (json_valid(`meta`))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.users: ~3 rows (approximately)
INSERT INTO `users` (`id`, `establishment_id`, `role_id`, `department_id`, `full_name`, `email`, `username`, `password_hash`, `phone`, `is_active`, `created_at`, `meta`) VALUES
	(1, 1, 3, 4, 'Admin User', 'admin@statwise.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 1, '2025-11-29 15:20:10', NULL),
	(2, 1, 4, 1, 'Admin Demo', 'admin@statwise.local', 'admin', '$2y$10$.xU7HRRFj8I/t9BtO2H5/Oq9ogvcftJoitYFXPtPm/krffHveGhhC', NULL, 1, '2025-11-29 15:36:22', NULL),
	(3, 1, 4, 1, 'Axel', 'axel@gmail.com', NULL, '$2y$10$9oLqHu2EErx14QuC0ME1teIFHp/.L2DfhNXn77NA7d0KNIokSOv/u', NULL, 1, '2025-12-01 13:29:21', NULL);

-- Dumping structure for table statwise.weekly_coverage_reports
CREATE TABLE IF NOT EXISTS `weekly_coverage_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `establishment_id` int NOT NULL,
  `program_id` int NOT NULL,
  `recorded_by_user_id` int NOT NULL,
  `nbr_hours_do` int NOT NULL,
  `nbr_lesson_do` int NOT NULL,
  `nbr_lesson_dig_do` int NOT NULL,
  `nbr_tp_do` int NOT NULL,
  `nbr_tp_dig_do` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `program_id` (`program_id`),
  CONSTRAINT `weekly_coverage_reports_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table statwise.weekly_coverage_reports: ~4 rows (approximately)
INSERT INTO `weekly_coverage_reports` (`id`, `establishment_id`, `program_id`, `recorded_by_user_id`, `nbr_hours_do`, `nbr_lesson_do`, `nbr_lesson_dig_do`, `nbr_tp_do`, `nbr_tp_dig_do`, `created_at`) VALUES
	(1, 1, 1, 1, 5, 5, 5, 6, 5, '2025-12-01 13:37:39'),
	(2, 1, 1, 1, 5, 5, 5, 5, 5, '2025-12-03 12:45:36'),
	(3, 1, 8, 1, 10, 1, 1, 1, 2, '2025-12-03 13:04:39'),
	(4, 1, 9, 1, 10, 10, 1, 1, 1, '2025-12-03 13:07:28');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
