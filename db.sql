-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 30 nov. 2025 à 08:50
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `statwise`
--

-- --------------------------------------------------------

--
-- Structure de la table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `resource_type` varchar(50) DEFAULT NULL,
  `resource_id` varchar(100) DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `grade_level` varchar(50) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `establishment_id`, `name`, `grade_level`, `department_id`, `meta`, `created_at`) VALUES
(1, 1, '6e A', NULL, 1, NULL, '2025-11-29 17:18:24');

-- --------------------------------------------------------

--
-- Structure de la table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_user_id` int(11) DEFAULT NULL,
  `planned_hours_per_week` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `head_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `departments`
--

INSERT INTO `departments` (`id`, `establishment_id`, `name`, `code`, `head_user_id`, `created_at`) VALUES
(1, 1, 'Mathématiques', NULL, NULL, '2025-11-29 17:17:48');

-- --------------------------------------------------------

--
-- Structure de la table `establishments`
--

CREATE TABLE `establishments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `establishments`
--

INSERT INTO `establishments` (`id`, `name`, `code`, `address`, `phone`, `email`, `meta`, `created_at`) VALUES
(1, 'StatWise Demo', NULL, NULL, NULL, NULL, NULL, '2025-11-29 15:36:22');

-- --------------------------------------------------------

--
-- Structure de la table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `classe_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `nbr_hours` int(11) NOT NULL,
  `nbr_lesson` int(11) NOT NULL,
  `nbr_lesson_dig` int(11) NOT NULL,
  `nbr_tp` int(11) NOT NULL,
  `nbr_tp_dig` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Admin', 'Administrateur avec toutes les permissions', '2025-11-29 15:20:10');

-- --------------------------------------------------------

--
-- Structure de la table `school_years`
--

CREATE TABLE `school_years` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `school_years`
--

INSERT INTO `school_years` (`id`, `title`, `start_date`, `end_date`, `is_active`, `created_at`) VALUES
(1, '2025-2026', '2025-09-01', '2026-06-30', 0, '2025-11-29 17:23:22'),
(2, 'Test 2', '2025-11-29', '2026-11-29', 0, '2025-11-29 17:31:16');

-- --------------------------------------------------------

--
-- Structure de la table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `establishment_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`, `description`, `created_at`) VALUES
(1, 'MAT', 'Mathematiques', NULL, '2025-11-29 17:18:49');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `establishment_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add JSON meta column to users for permission overrides and other metadata, safe migration
ALTER TABLE `users` ADD COLUMN `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`));

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `establishment_id`, `role_id`, `department_id`, `full_name`, `email`, `username`, `password_hash`, `phone`, `is_active`, `created_at`) VALUES
(1, NULL, 1, NULL, 'Admin User', 'admin@statwise.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 1, '2025-11-29 15:20:10'),
(2, 1, 1, 1, 'Admin Demo', 'admin@statwise.local', 'admin', '$2y$10$.xU7HRRFj8I/t9BtO2H5/Oq9ogvcftJoitYFXPtPm/krffHveGhhC', NULL, 1, '2025-11-29 15:36:22');

-- --------------------------------------------------------

--
-- Structure de la table `weekly_coverage_reports`
--

CREATE TABLE `weekly_coverage_reports` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `recorded_by_user_id` int(11) NOT NULL,
  `nbr_hours_do` int(11) NOT NULL,
  `nbr_lesson_do` int(11) NOT NULL,
  `nbr_lesson_dig_do` int(11) NOT NULL,
  `nbr_tp_do` int(11) NOT NULL,
  `nbr_tp_dig_do` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `establishment_id` (`establishment_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Index pour la table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_class_subject` (`class_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_user_id` (`teacher_user_id`);

--
-- Index pour la table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `establishment_id` (`establishment_id`);

--
-- Index pour la table `establishments`
--
ALTER TABLE `establishments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `programs`
  ADD KEY `classe_id` (`classe_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `school_years`
--
ALTER TABLE `school_years`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

-- Add index and FK for department_id and establishment_id (new fields)
ALTER TABLE `subjects`
  ADD KEY `department_id` (`department_id`),
  ADD KEY `establishment_id` (`establishment_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `establishment_id` (`establishment_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Index pour la table `weekly_coverage_reports`
--
ALTER TABLE `weekly_coverage_reports`
  ADD PRIMARY KEY (`id`);

-- Add index for program_id
ALTER TABLE `weekly_coverage_reports`
  ADD KEY `program_id` (`program_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `class_subjects`
--
ALTER TABLE `class_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `establishments`
--
ALTER TABLE `establishments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `school_years`
--
ALTER TABLE `school_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `weekly_coverage_reports`
--
ALTER TABLE `weekly_coverage_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `class_subjects`
--
ALTER TABLE `class_subjects`
  ADD CONSTRAINT `class_subjects_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_subjects_ibfk_3` FOREIGN KEY (`teacher_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `programs_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `weekly_coverage_reports`
--
ALTER TABLE `weekly_coverage_reports`
  ADD CONSTRAINT `weekly_coverage_reports_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `subjects` (department / establishment)
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`establishment_id`) REFERENCES `establishments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
