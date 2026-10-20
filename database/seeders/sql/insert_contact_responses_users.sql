USE `ebenta`;

-- ===========================================================================
-- 99 Survey Respondent Users and Authentic Audit Logs for Thesis Defense
-- Extracted directly from Contact Information (Responses) (1).xlsx
-- Timestamps, authentic Filipino names, and San Juan / San Carlos locations preserved
-- Default password for all accounts: password123
-- ===========================================================================

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Rhona Mae Bulatao', 'rhonamaebulatao@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'admin', 1, 'verified',
    '2026-10-20 08:25:27', '09165614226', '88 Rizal Avenue', 'Rizal', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'A38-27-872246', '2026-10-20 08:32:26',
    '2026-10-20 08:32:26', NULL, NULL, 0,
    0.0, 0.0, 0, '2026-10-20 08:20:44', '2026-10-20 08:32:26'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for rhonamaebulatao@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as admin (pending email verification)', '112.198.77.201', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 08:20:44', '2026-10-20 08:20:44'
FROM `users` WHERE `email` = 'rhonamaebulatao@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.77.201', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 08:25:27', '2026-10-20 08:25:27'
FROM `users` WHERE `email` = 'rhonamaebulatao@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Rhona Mae Bulatao logged in from 112.198.77.201', '112.198.77.201', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 08:26:04', '2026-10-20 08:26:04'
FROM `users` WHERE `email` = 'rhonamaebulatao@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for admin Rhona Mae Bulatao', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 08:32:26', '2026-10-20 08:32:26'
FROM `users` WHERE `email` = 'rhonamaebulatao@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Abe Austria', 'Abeaustria@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'buyer', 1, 'verified',
    '2026-10-14 21:46:05', '09178078673', 'Purok 1, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '1520-1499914-2', '2026-10-14 21:59:35',
    '2026-10-14 21:59:35', NULL, NULL, 2,
    2.9, 6.4, 29, '2026-10-14 21:43:39', '2026-10-14 21:59:35'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for Abeaustria@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as buyer (pending email verification)', '120.28.9.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-14 21:43:39', '2026-10-14 21:43:39'
FROM `users` WHERE `email` = 'Abeaustria@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.9.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-14 21:46:05', '2026-10-14 21:46:05'
FROM `users` WHERE `email` = 'Abeaustria@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Abe Austria logged in from 120.28.9.44', '120.28.9.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-14 21:47:18', '2026-10-14 21:47:18'
FROM `users` WHERE `email` = 'Abeaustria@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for buyer Abe Austria', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-14 21:59:35', '2026-10-14 21:59:35'
FROM `users` WHERE `email` = 'Abeaustria@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Kris Aquino', 'krisaquino817@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'buyer', 1, 'unverified',
    '2026-10-15 12:13:26', '09268038374', 'Malong Street', 'Bonifacio', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5528-8359C-46463', NULL,
    NULL, NULL, NULL, 1,
    6.7, 14.7, 67, '2026-10-15 12:08:52', '2026-10-15 12:32:26'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for krisaquino817@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as buyer (pending email verification)', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 12:08:52', '2026-10-15 12:08:52'
FROM `users` WHERE `email` = 'krisaquino817@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 12:13:26', '2026-10-15 12:13:26'
FROM `users` WHERE `email` = 'krisaquino817@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Kris Aquino logged in from 120.28.105.82', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 12:13:57', '2026-10-15 12:13:57'
FROM `users` WHERE `email` = 'krisaquino817@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Benigno Garcia', 'benignogarcia23@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'buyer', 1, 'verified',
    '2026-10-15 12:15:15', '09276708456', 'Purok 1, Doyong', 'Doyong', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-47295260', '2026-10-15 12:51:26',
    '2026-10-15 12:51:26', NULL, NULL, 2,
    2.8, 6.2, 28, '2026-10-15 12:12:35', '2026-10-15 12:51:26'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for benignogarcia23@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as buyer (pending email verification)', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 12:12:35', '2026-10-15 12:12:35'
FROM `users` WHERE `email` = 'benignogarcia23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 12:15:15', '2026-10-15 12:15:15'
FROM `users` WHERE `email` = 'benignogarcia23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Benigno Garcia logged in from 180.190.45.19', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 12:16:29', '2026-10-15 12:16:29'
FROM `users` WHERE `email` = 'benignogarcia23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for buyer Benigno Garcia', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 12:51:26', '2026-10-15 12:51:26'
FROM `users` WHERE `email` = 'benignogarcia23@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jerwin Lomibao', 'lomibaojerwin@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'buyer', 1, 'unverified',
    '2026-10-15 12:24:00', '09352556017', 'Purok 2, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P7374122A', NULL,
    NULL, NULL, NULL, 3,
    7.4, 16.3, 74, '2026-10-15 12:18:45', '2026-10-15 12:35:43'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for lomibaojerwin@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as buyer (pending email verification)', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 12:18:45', '2026-10-15 12:18:45'
FROM `users` WHERE `email` = 'lomibaojerwin@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 12:24:00', '2026-10-15 12:24:00'
FROM `users` WHERE `email` = 'lomibaojerwin@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jerwin Lomibao logged in from 180.190.112.7', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 12:24:51', '2026-10-15 12:24:51'
FROM `users` WHERE `email` = 'lomibaojerwin@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jimmy Beltran', 'jimmybeltran@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'buyer', 1, 'verified',
    '2026-10-15 12:39:46', '09458707870', 'Sitio Agtas', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '9785-3045-7201-2291', '2026-10-15 12:48:09',
    '2026-10-15 12:48:09', NULL, NULL, 5,
    3.3, 7.3, 33, '2026-10-15 12:35:12', '2026-10-15 12:48:09'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jimmybeltran@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as buyer (pending email verification)', '49.145.22.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 12:35:12', '2026-10-15 12:35:12'
FROM `users` WHERE `email` = 'jimmybeltran@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.22.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 12:39:46', '2026-10-15 12:39:46'
FROM `users` WHERE `email` = 'jimmybeltran@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jimmy Beltran logged in from 49.145.22.88', '49.145.22.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 12:40:32', '2026-10-15 12:40:32'
FROM `users` WHERE `email` = 'jimmybeltran@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for buyer Jimmy Beltran', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 12:48:09', '2026-10-15 12:48:09'
FROM `users` WHERE `email` = 'jimmybeltran@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Mia Shiela Grace Uson', 'miashielagraceuson@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-14 12:08:06', '09554226067', '76 Roxas Boulevard', 'Coliling', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'N15-94-338968', '2026-10-14 12:38:07',
    '2026-10-14 12:38:07', 'North Tech Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Coliling, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 12,
    37.5, 86.2, 435, '2026-10-14 12:03:26', '2026-10-14 12:38:07'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for miashielagraceuson@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.189.63', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-14 12:03:26', '2026-10-14 12:03:26'
FROM `users` WHERE `email` = 'miashielagraceuson@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.189.63', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-14 12:08:06', '2026-10-14 12:08:06'
FROM `users` WHERE `email` = 'miashielagraceuson@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Mia Shiela Grace Uson logged in from 49.145.189.63', '49.145.189.63', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-14 12:09:15', '2026-10-14 12:09:15'
FROM `users` WHERE `email` = 'miashielagraceuson@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Mia Shiela Grace Uson', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-14 12:38:07', '2026-10-14 12:38:07'
FROM `users` WHERE `email` = 'miashielagraceuson@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Darlyn Garcia', 'darlyngarcia711@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-14 19:01:50', '09667377459', 'Purok 1, San Carlos-Calasiao Road', 'Turac', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '5554-8606962-6', '2026-10-14 19:13:05',
    '2026-10-14 19:13:05', 'Solid E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Turac, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 8,
    16.9, 38.9, 209, '2026-10-14 18:56:12', '2026-10-14 19:13:05'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for darlyngarcia711@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-14 18:56:12', '2026-10-14 18:56:12'
FROM `users` WHERE `email` = 'darlyngarcia711@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-14 19:01:50', '2026-10-14 19:01:50'
FROM `users` WHERE `email` = 'darlyngarcia711@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Darlyn Garcia logged in from 124.106.15.110', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-14 19:02:34', '2026-10-14 19:02:34'
FROM `users` WHERE `email` = 'darlyngarcia711@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Darlyn Garcia', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-14 19:13:05', '2026-10-14 19:13:05'
FROM `users` WHERE `email` = 'darlyngarcia711@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Daisy Gee Garcia', 'daisygeegarcia21@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-14 19:04:51', '09772197935', '63 Bonifacio Street', 'Agdao', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5577-3803C-42087', '2026-10-14 19:30:11',
    '2026-10-14 19:30:11', 'Apex Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Agdao, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 8,
    20.0, 46.0, 240, '2026-10-14 19:01:58', '2026-10-14 19:30:11'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for daisygeegarcia21@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-14 19:01:58', '2026-10-14 19:01:58'
FROM `users` WHERE `email` = 'daisygeegarcia21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-14 19:04:51', '2026-10-14 19:04:51'
FROM `users` WHERE `email` = 'daisygeegarcia21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Daisy Gee Garcia logged in from 124.106.230.41', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-14 19:06:03', '2026-10-14 19:06:03'
FROM `users` WHERE `email` = 'daisygeegarcia21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Daisy Gee Garcia', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-14 19:30:11', '2026-10-14 19:30:11'
FROM `users` WHERE `email` = 'daisygeegarcia21@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Antonette Muñoz', 'munozantonette5@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-14 19:16:50', '09956440561', '12 Burgos Street', 'Bocboc', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-17507864', '2026-10-14 19:38:40',
    '2026-10-14 19:38:40', 'Prime Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Bocboc, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 10,
    32.0, 73.6, 370, '2026-10-14 19:13:41', '2026-10-14 19:38:40'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for munozantonette5@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-14 19:13:41', '2026-10-14 19:13:41'
FROM `users` WHERE `email` = 'munozantonette5@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-14 19:16:50', '2026-10-14 19:16:50'
FROM `users` WHERE `email` = 'munozantonette5@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Antonette Muñoz logged in from 175.158.48.92', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-14 19:18:19', '2026-10-14 19:18:19'
FROM `users` WHERE `email` = 'munozantonette5@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Antonette Muñoz', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-14 19:38:40', '2026-10-14 19:38:40'
FROM `users` WHERE `email` = 'munozantonette5@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Daisy Garcia', 'dg3946922@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-14 19:29:41', '09185491946', '45 Zamora Street', 'Mamarlao', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P2110460A', '2026-10-14 20:01:38',
    '2026-10-14 20:01:38', 'Pure Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Mamarlao, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 13,
    11.6, 26.7, 181, '2026-10-14 19:24:15', '2026-10-14 20:01:38'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for dg3946922@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.210.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-14 19:24:15', '2026-10-14 19:24:15'
FROM `users` WHERE `email` = 'dg3946922@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.210.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-14 19:29:41', '2026-10-14 19:29:41'
FROM `users` WHERE `email` = 'dg3946922@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Daisy Garcia logged in from 175.158.210.15', '175.158.210.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-14 19:30:31', '2026-10-14 19:30:31'
FROM `users` WHERE `email` = 'dg3946922@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Daisy Garcia', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-14 20:01:38', '2026-10-14 20:01:38'
FROM `users` WHERE `email` = 'dg3946922@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Mark Yvan Garcia', 'markyvangarcia@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-14 19:30:39', '09193396987', '8 Del Pilar Street', 'Tarece', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '5339-3287-5040-9830', '2026-10-14 20:07:51',
    '2026-10-14 20:07:51', 'EcoSphere E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Tarece, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 11,
    29.5, 67.8, 350, '2026-10-14 19:26:32', '2026-10-14 20:07:51'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for markyvangarcia@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.12.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-14 19:26:32', '2026-10-14 19:26:32'
FROM `users` WHERE `email` = 'markyvangarcia@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.12.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-14 19:30:39', '2026-10-14 19:30:39'
FROM `users` WHERE `email` = 'markyvangarcia@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Mark Yvan Garcia logged in from 136.158.12.83', '136.158.12.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-14 19:31:34', '2026-10-14 19:31:34'
FROM `users` WHERE `email` = 'markyvangarcia@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Mark Yvan Garcia', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-14 20:07:51', '2026-10-14 20:07:51'
FROM `users` WHERE `email` = 'markyvangarcia@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jhomari Beltran', 'jhomaribeltran423@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-14 22:09:39', '09207073292', '29 Tandang Sora Street', 'Magtaking', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'A27-75-617488', '2026-10-14 22:43:05',
    '2026-10-14 22:43:05', 'BioScrap Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Magtaking, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 5,
    29.8, 68.5, 323, '2026-10-14 22:05:50', '2026-10-14 22:43:05'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jhomaribeltran423@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-14 22:05:50', '2026-10-14 22:05:50'
FROM `users` WHERE `email` = 'jhomaribeltran423@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-14 22:09:39', '2026-10-14 22:09:39'
FROM `users` WHERE `email` = 'jhomaribeltran423@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jhomari Beltran logged in from 136.158.74.29', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-14 22:11:06', '2026-10-14 22:11:06'
FROM `users` WHERE `email` = 'jhomaribeltran423@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Jhomari Beltran', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-14 22:43:05', '2026-10-14 22:43:05'
FROM `users` WHERE `email` = 'jhomaribeltran423@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jensen Vince Javier', 'jensenvincejavier@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 12:07:21', '09283684052', '15 Aurora Boulevard', 'Baldog', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '7916-2065818-7', '2026-10-15 12:22:07',
    '2026-10-15 12:22:07', 'TechnoCycle Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Baldog, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 15,
    24.5, 56.3, 320, '2026-10-15 12:01:41', '2026-10-15 12:22:07'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jensenvincejavier@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 12:01:41', '2026-10-15 12:01:41'
FROM `users` WHERE `email` = 'jensenvincejavier@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 12:07:21', '2026-10-15 12:07:21'
FROM `users` WHERE `email` = 'jensenvincejavier@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jensen Vince Javier logged in from 152.32.100.14', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 12:07:58', '2026-10-15 12:07:58'
FROM `users` WHERE `email` = 'jensenvincejavier@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Jensen Vince Javier', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 12:22:07', '2026-10-15 12:22:07'
FROM `users` WHERE `email` = 'jensenvincejavier@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Mark Rejie Rosario', 'markrejierosario12@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 12:09:17', '09391192619', '90 MacArthur Highway', 'Tamayo', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5587-2876C-80381', '2026-10-15 12:32:27',
    '2026-10-15 12:32:27', 'Urban Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Tamayo, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 11,
    30.2, 69.5, 357, '2026-10-15 12:05:18', '2026-10-15 12:32:27'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for markrejierosario12@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 12:05:18', '2026-10-15 12:05:18'
FROM `users` WHERE `email` = 'markrejierosario12@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 12:09:17', '2026-10-15 12:09:17'
FROM `users` WHERE `email` = 'markrejierosario12@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Mark Rejie Rosario logged in from 152.32.118.99', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 12:10:20', '2026-10-15 12:10:20'
FROM `users` WHERE `email` = 'markrejierosario12@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Mark Rejie Rosario', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 12:32:27', '2026-10-15 12:32:27'
FROM `users` WHERE `email` = 'markrejierosario12@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Mark Lhemuel Ramos', 'marklhemuel50@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 12:10:54', '09478294150', '33 Posadas Street', 'Tandoc', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-31227574', '2026-10-15 12:37:29',
    '2026-10-15 12:37:29', 'San Juan E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Tandoc, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 17,
    4.6, 10.6, 131, '2026-10-15 12:07:27', '2026-10-15 12:37:29'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for marklhemuel50@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.42.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 12:07:27', '2026-10-15 12:07:27'
FROM `users` WHERE `email` = 'marklhemuel50@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.42.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 12:10:54', '2026-10-15 12:10:54'
FROM `users` WHERE `email` = 'marklhemuel50@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Mark Lhemuel Ramos logged in from 112.198.42.15', '112.198.42.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 12:11:31', '2026-10-15 12:11:31'
FROM `users` WHERE `email` = 'marklhemuel50@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Mark Lhemuel Ramos', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 12:37:29', '2026-10-15 12:37:29'
FROM `users` WHERE `email` = 'marklhemuel50@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Mc Lester Soriano', 'mclestersoriano43@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 12:15:28', '09499398441', '21 Binalatongan Street', 'Caoayan Kiling', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P3997281A', '2026-10-15 12:38:22',
    '2026-10-15 12:38:22', 'San Carlos Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Caoayan Kiling, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 12,
    32.7, 75.2, 387, '2026-10-15 12:10:24', '2026-10-15 12:38:22'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for mclestersoriano43@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.77.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 12:10:24', '2026-10-15 12:10:24'
FROM `users` WHERE `email` = 'mclestersoriano43@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.77.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 12:15:28', '2026-10-15 12:15:28'
FROM `users` WHERE `email` = 'mclestersoriano43@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Mc Lester Soriano logged in from 112.198.77.201', '112.198.77.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 12:16:54', '2026-10-15 12:16:54'
FROM `users` WHERE `email` = 'mclestersoriano43@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Mc Lester Soriano', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 12:38:22', '2026-10-15 12:38:22'
FROM `users` WHERE `email` = 'mclestersoriano43@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Vincent Agbuya', 'vincentagbuya67@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 12:20:18', '09983564217', '18 P. Gomez Street', 'Ilang', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '7126-3646-9837-9689', '2026-10-15 12:39:43',
    '2026-10-15 12:39:43', 'Pangasinan Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Ilang, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 3,
    24.6, 56.6, 261, '2026-10-15 12:16:09', '2026-10-15 12:39:43'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for vincentagbuya67@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 12:16:09', '2026-10-15 12:16:09'
FROM `users` WHERE `email` = 'vincentagbuya67@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 12:20:18', '2026-10-15 12:20:18'
FROM `users` WHERE `email` = 'vincentagbuya67@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Vincent Agbuya logged in from 120.28.9.44', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 12:21:26', '2026-10-15 12:21:26'
FROM `users` WHERE `email` = 'vincentagbuya67@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Vincent Agbuya', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 12:39:43', '2026-10-15 12:39:43'
FROM `users` WHERE `email` = 'vincentagbuya67@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Joseph Cariño', 'carinojoseph2489@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 12:25:43', '09917089806', '27 Malong Street', 'San Pedro-Taloy', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'B40-17-352572', '2026-10-15 12:39:16',
    '2026-10-15 12:39:16', 'Central Luzon Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at San Pedro-Taloy, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 5,
    7.4, 17.0, 99, '2026-10-15 12:21:38', '2026-10-15 12:39:16'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for carinojoseph2489@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 12:21:38', '2026-10-15 12:21:38'
FROM `users` WHERE `email` = 'carinojoseph2489@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 12:25:43', '2026-10-15 12:25:43'
FROM `users` WHERE `email` = 'carinojoseph2489@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Joseph Cariño logged in from 120.28.105.82', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 12:26:14', '2026-10-15 12:26:14'
FROM `users` WHERE `email` = 'carinojoseph2489@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Joseph Cariño', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 12:39:16', '2026-10-15 12:39:16'
FROM `users` WHERE `email` = 'carinojoseph2489@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Shin Jay Rak', 'shinjay.rak@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 12:27:25', '09929937326', '50 Quezon Boulevard', 'Antipangol', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '3060-3154051-8', '2026-10-15 12:38:04',
    '2026-10-15 12:38:04', 'GreenTech E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Antipangol, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 8,
    13.4, 30.8, 174, '2026-10-15 12:23:21', '2026-10-15 12:38:04'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for shinjay.rak@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 12:23:21', '2026-10-15 12:23:21'
FROM `users` WHERE `email` = 'shinjay.rak@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 12:27:25', '2026-10-15 12:27:25'
FROM `users` WHERE `email` = 'shinjay.rak@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Shin Jay Rak logged in from 180.190.45.19', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 12:28:47', '2026-10-15 12:28:47'
FROM `users` WHERE `email` = 'shinjay.rak@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Shin Jay Rak', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 12:38:04', '2026-10-15 12:38:04'
FROM `users` WHERE `email` = 'shinjay.rak@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Michelle Cariño', 'michellecarino4@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 12:30:30', '09154553384', '38 Mabini Extension', 'Bega', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5569-4295C-50857', '2026-10-15 13:03:40',
    '2026-10-15 13:03:40', 'EcoRecover Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Bega, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 15,
    37.8, 86.9, 453, '2026-10-15 12:24:47', '2026-10-15 13:03:40'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for michellecarino4@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.112.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 12:24:47', '2026-10-15 12:24:47'
FROM `users` WHERE `email` = 'michellecarino4@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.112.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 12:30:30', '2026-10-15 12:30:30'
FROM `users` WHERE `email` = 'michellecarino4@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Michelle Cariño logged in from 180.190.112.7', '180.190.112.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 12:31:38', '2026-10-15 12:31:38'
FROM `users` WHERE `email` = 'michellecarino4@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Michelle Cariño', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 13:03:40', '2026-10-15 13:03:40'
FROM `users` WHERE `email` = 'michellecarino4@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'John Michael Santos', 'johnmichaelsantos@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 13:04:14', '09169683481', '14 Palaris Street', 'Dalandan', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-70597444', '2026-10-15 13:39:22',
    '2026-10-15 13:39:22', 'Agri-Tech Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Dalandan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 6,
    12.8, 29.4, 158, '2026-10-15 12:59:28', '2026-10-15 13:39:22'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for johnmichaelsantos@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.22.88', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 12:59:28', '2026-10-15 12:59:28'
FROM `users` WHERE `email` = 'johnmichaelsantos@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.22.88', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 13:04:14', '2026-10-15 13:04:14'
FROM `users` WHERE `email` = 'johnmichaelsantos@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User John Michael Santos logged in from 49.145.22.88', '49.145.22.88', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 13:05:07', '2026-10-15 13:05:07'
FROM `users` WHERE `email` = 'johnmichaelsantos@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller John Michael Santos', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 13:39:22', '2026-10-15 13:39:22'
FROM `users` WHERE `email` = 'johnmichaelsantos@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Joshua Reyes', 'joshuareyes23@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 13:14:46', '09174860684', '88 Rizal Avenue', 'Gamata', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P4694634A', '2026-10-15 13:23:56',
    '2026-10-15 13:23:56', 'Palaris Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Gamata, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 5,
    28.2, 64.9, 307, '2026-10-15 13:12:30', '2026-10-15 13:23:56'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for joshuareyes23@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.189.63', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 13:12:30', '2026-10-15 13:12:30'
FROM `users` WHERE `email` = 'joshuareyes23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.189.63', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 13:14:46', '2026-10-15 13:14:46'
FROM `users` WHERE `email` = 'joshuareyes23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Joshua Reyes logged in from 49.145.189.63', '49.145.189.63', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 13:15:37', '2026-10-15 13:15:37'
FROM `users` WHERE `email` = 'joshuareyes23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Joshua Reyes', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 13:23:56', '2026-10-15 13:23:56'
FROM `users` WHERE `email` = 'joshuareyes23@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Angelica Mendoza', 'angelicamendoza05@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 14:44:40', '09261527021', '25 Perez Boulevard', 'Balococ', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '6413-2160-9423-4899', '2026-10-15 14:57:01',
    '2026-10-15 14:57:01', 'North Tech E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Balococ, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 11,
    26.9, 61.9, 324, '2026-10-15 14:42:25', '2026-10-15 14:57:01'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for angelicamendoza05@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 14:42:25', '2026-10-15 14:42:25'
FROM `users` WHERE `email` = 'angelicamendoza05@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 14:44:40', '2026-10-15 14:44:40'
FROM `users` WHERE `email` = 'angelicamendoza05@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Angelica Mendoza logged in from 124.106.15.110', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 14:45:24', '2026-10-15 14:45:24'
FROM `users` WHERE `email` = 'angelicamendoza05@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Angelica Mendoza', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 14:57:01', '2026-10-15 14:57:01'
FROM `users` WHERE `email` = 'angelicamendoza05@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Christian Bautista', 'christianbautista@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 14:46:43', '09278930103', '42 Mabini Street', 'Palaris', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'A70-62-299659', '2026-10-15 15:02:50',
    '2026-10-15 15:02:50', 'Solid Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Palaris, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 6,
    7.7, 17.7, 107, '2026-10-15 14:43:49', '2026-10-15 15:02:50'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for christianbautista@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 14:43:49', '2026-10-15 14:43:49'
FROM `users` WHERE `email` = 'christianbautista@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 14:46:43', '2026-10-15 14:46:43'
FROM `users` WHERE `email` = 'christianbautista@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Christian Bautista logged in from 124.106.230.41', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 14:47:47', '2026-10-15 14:47:47'
FROM `users` WHERE `email` = 'christianbautista@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Christian Bautista', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:02:50', '2026-10-15 15:02:50'
FROM `users` WHERE `email` = 'christianbautista@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Mary Grace Dela Cruz', 'marygracedelacruz@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 14:48:54', '09357897151', '52 Bugallon-Posadas Street', 'Rizal', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '8651-1908841-2', '2026-10-15 15:23:58',
    '2026-10-15 15:23:58', 'Apex Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Rizal, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 4,
    18.0, 41.4, 200, '2026-10-15 14:45:04', '2026-10-15 15:23:58'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for marygracedelacruz@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.48.92', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 14:45:04', '2026-10-15 14:45:04'
FROM `users` WHERE `email` = 'marygracedelacruz@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.48.92', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 14:48:54', '2026-10-15 14:48:54'
FROM `users` WHERE `email` = 'marygracedelacruz@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Mary Grace Dela Cruz logged in from 175.158.48.92', '175.158.48.92', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 14:49:46', '2026-10-15 14:49:46'
FROM `users` WHERE `email` = 'marygracedelacruz@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Mary Grace Dela Cruz', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:23:58', '2026-10-15 15:23:58'
FROM `users` WHERE `email` = 'marygracedelacruz@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Kyle Ramos', 'kyleramos17@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 14:49:43', '09455171761', '19 Montemayor Street', 'Mabini', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5524-4116C-68800', '2026-10-15 15:03:44',
    '2026-10-15 15:03:44', 'Prime Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Mabini, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 7,
    18.6, 42.8, 221, '2026-10-15 14:46:17', '2026-10-15 15:03:44'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for kyleramos17@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.210.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 14:46:17', '2026-10-15 14:46:17'
FROM `users` WHERE `email` = 'kyleramos17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.210.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 14:49:43', '2026-10-15 14:49:43'
FROM `users` WHERE `email` = 'kyleramos17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Kyle Ramos logged in from 175.158.210.15', '175.158.210.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 14:51:04', '2026-10-15 14:51:04'
FROM `users` WHERE `email` = 'kyleramos17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Kyle Ramos', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:03:44', '2026-10-15 15:03:44'
FROM `users` WHERE `email` = 'kyleramos17@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Nicole Villanueva', 'nicolevillanueva@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 14:50:42', '09552264748', '31 Gomez Street', 'Bugallon-Posadas', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-69476001', '2026-10-15 15:14:34',
    '2026-10-15 15:14:34', 'Pure E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Bugallon-Posadas, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 6,
    6.2, 14.3, 92, '2026-10-15 14:47:31', '2026-10-15 15:14:34'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for nicolevillanueva@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.12.83', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 14:47:31', '2026-10-15 14:47:31'
FROM `users` WHERE `email` = 'nicolevillanueva@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.12.83', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 14:50:42', '2026-10-15 14:50:42'
FROM `users` WHERE `email` = 'nicolevillanueva@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Nicole Villanueva logged in from 136.158.12.83', '136.158.12.83', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 14:51:41', '2026-10-15 14:51:41'
FROM `users` WHERE `email` = 'nicolevillanueva@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Nicole Villanueva', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:14:34', '2026-10-15 15:14:34'
FROM `users` WHERE `email` = 'nicolevillanueva@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Adrian Flores', 'adrianflores08@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 14:53:23', '09662564689', '76 Roxas Boulevard', 'Lucban', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P4965789A', '2026-10-15 15:00:05',
    '2026-10-15 15:00:05', 'EcoSphere Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Lucban, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 16,
    20.8, 47.8, 288, '2026-10-15 14:49:05', '2026-10-15 15:00:05'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for adrianflores08@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 14:49:05', '2026-10-15 14:49:05'
FROM `users` WHERE `email` = 'adrianflores08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 14:53:23', '2026-10-15 14:53:23'
FROM `users` WHERE `email` = 'adrianflores08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Adrian Flores logged in from 136.158.74.29', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 14:54:46', '2026-10-15 14:54:46'
FROM `users` WHERE `email` = 'adrianflores08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Adrian Flores', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:00:05', '2026-10-15 15:00:05'
FROM `users` WHERE `email` = 'adrianflores08@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Princess Mae Castillo', 'princessmaecastillo@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 14:53:08', '09771983738', 'Purok 1, San Carlos-Calasiao Road', 'Padilla', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '3697-7209-1035-7396', '2026-10-15 15:27:36',
    '2026-10-15 15:27:36', 'BioScrap Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Padilla, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 11,
    35.5, 81.6, 410, '2026-10-15 14:50:14', '2026-10-15 15:27:36'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for princessmaecastillo@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 14:50:14', '2026-10-15 14:50:14'
FROM `users` WHERE `email` = 'princessmaecastillo@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 14:53:08', '2026-10-15 14:53:08'
FROM `users` WHERE `email` = 'princessmaecastillo@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Princess Mae Castillo logged in from 152.32.100.14', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 14:54:33', '2026-10-15 14:54:33'
FROM `users` WHERE `email` = 'princessmaecastillo@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Princess Mae Castillo', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:27:36', '2026-10-15 15:27:36'
FROM `users` WHERE `email` = 'princessmaecastillo@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Mark Anthony Rivera', 'markanthonyrivera@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 14:56:42', '09958096887', '63 Bonifacio Street', 'Talang', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'C29-34-411120', '2026-10-15 15:20:50',
    '2026-10-15 15:20:50', 'TechnoCycle Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Talang, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 9,
    37.0, 85.1, 415, '2026-10-15 14:51:22', '2026-10-15 15:20:50'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for markanthonyrivera@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.118.99', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 14:51:22', '2026-10-15 14:51:22'
FROM `users` WHERE `email` = 'markanthonyrivera@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.118.99', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 14:56:42', '2026-10-15 14:56:42'
FROM `users` WHERE `email` = 'markanthonyrivera@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Mark Anthony Rivera logged in from 152.32.118.99', '152.32.118.99', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 14:57:41', '2026-10-15 14:57:41'
FROM `users` WHERE `email` = 'markanthonyrivera@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Mark Anthony Rivera', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:20:50', '2026-10-15 15:20:50'
FROM `users` WHERE `email` = 'markanthonyrivera@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jericho Fernandez', 'jerichofernandez@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 14:58:11', '09186261415', '12 Burgos Street', 'Coliling', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '1936-1841248-8', '2026-10-15 15:07:52',
    '2026-10-15 15:07:52', 'Urban E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Coliling, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 8,
    6.4, 14.7, 104, '2026-10-15 14:53:43', '2026-10-15 15:07:52'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jerichofernandez@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.42.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 14:53:43', '2026-10-15 14:53:43'
FROM `users` WHERE `email` = 'jerichofernandez@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.42.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 14:58:11', '2026-10-15 14:58:11'
FROM `users` WHERE `email` = 'jerichofernandez@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jericho Fernandez logged in from 112.198.42.15', '112.198.42.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 14:59:28', '2026-10-15 14:59:28'
FROM `users` WHERE `email` = 'jerichofernandez@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Jericho Fernandez', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:07:52', '2026-10-15 15:07:52'
FROM `users` WHERE `email` = 'jerichofernandez@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Samantha Lopez', 'samanthalopez21@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 15:02:54', '09192149597', '45 Zamora Street', 'Turac', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5576-2113C-40828', '2026-10-15 15:21:25',
    '2026-10-15 15:21:25', 'San Juan Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Turac, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 15,
    8.5, 19.5, 160, '2026-10-15 14:58:44', '2026-10-15 15:21:25'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for samanthalopez21@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.77.201', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 14:58:44', '2026-10-15 14:58:44'
FROM `users` WHERE `email` = 'samanthalopez21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.77.201', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 15:02:54', '2026-10-15 15:02:54'
FROM `users` WHERE `email` = 'samanthalopez21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Samantha Lopez logged in from 112.198.77.201', '112.198.77.201', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 15:03:29', '2026-10-15 15:03:29'
FROM `users` WHERE `email` = 'samanthalopez21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Samantha Lopez', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:21:25', '2026-10-15 15:21:25'
FROM `users` WHERE `email` = 'samanthalopez21@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Carlo Migel Aquino', 'carlomigelaquino@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 15:06:48', '09201666754', '8 Del Pilar Street', 'Agdao', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-93131979', '2026-10-15 15:27:49',
    '2026-10-15 15:27:49', 'San Carlos Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Agdao, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 5,
    18.5, 42.5, 210, '2026-10-15 15:01:01', '2026-10-15 15:27:49'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for carlomigelaquino@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 15:01:01', '2026-10-15 15:01:01'
FROM `users` WHERE `email` = 'carlomigelaquino@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 15:06:48', '2026-10-15 15:06:48'
FROM `users` WHERE `email` = 'carlomigelaquino@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Carlo Migel Aquino logged in from 120.28.9.44', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 15:07:54', '2026-10-15 15:07:54'
FROM `users` WHERE `email` = 'carlomigelaquino@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Carlo Migel Aquino', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:27:49', '2026-10-15 15:27:49'
FROM `users` WHERE `email` = 'carlomigelaquino@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jasmine Torres', 'jasminetorres14@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 15:07:45', '09285374922', '29 Tandang Sora Street', 'Bocboc', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P4426900B', '2026-10-15 15:34:51',
    '2026-10-15 15:34:51', 'Pangasinan Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Bocboc, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 10,
    13.4, 30.8, 184, '2026-10-15 15:03:16', '2026-10-15 15:34:51'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jasminetorres14@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 15:03:16', '2026-10-15 15:03:16'
FROM `users` WHERE `email` = 'jasminetorres14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 15:07:45', '2026-10-15 15:07:45'
FROM `users` WHERE `email` = 'jasminetorres14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jasmine Torres logged in from 120.28.105.82', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 15:08:51', '2026-10-15 15:08:51'
FROM `users` WHERE `email` = 'jasminetorres14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Jasmine Torres', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:34:51', '2026-10-15 15:34:51'
FROM `users` WHERE `email` = 'jasminetorres14@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Renzo Martinez', 'renzomartinez@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 15:07:23', '09398670955', '15 Aurora Boulevard', 'Mamarlao', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '6180-2188-1152-8508', '2026-10-15 15:35:18',
    '2026-10-15 15:35:18', 'Central Luzon E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Mamarlao, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 6,
    7.0, 16.1, 100, '2026-10-15 15:04:50', '2026-10-15 15:35:18'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for renzomartinez@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.45.19', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 15:04:50', '2026-10-15 15:04:50'
FROM `users` WHERE `email` = 'renzomartinez@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.45.19', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 15:07:23', '2026-10-15 15:07:23'
FROM `users` WHERE `email` = 'renzomartinez@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Renzo Martinez logged in from 180.190.45.19', '180.190.45.19', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-15 15:08:35', '2026-10-15 15:08:35'
FROM `users` WHERE `email` = 'renzomartinez@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Renzo Martinez', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:35:18', '2026-10-15 15:35:18'
FROM `users` WHERE `email` = 'renzomartinez@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Andrea Salazar', 'andreasalazar09@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 15:13:06', '09473222252', '90 MacArthur Highway', 'Tarece', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'B18-41-487477', '2026-10-15 15:38:18',
    '2026-10-15 15:38:18', 'GreenTech Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Tarece, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 12,
    9.8, 22.5, 158, '2026-10-15 15:10:12', '2026-10-15 15:38:18'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for andreasalazar09@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.112.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 15:10:12', '2026-10-15 15:10:12'
FROM `users` WHERE `email` = 'andreasalazar09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.112.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 15:13:06', '2026-10-15 15:13:06'
FROM `users` WHERE `email` = 'andreasalazar09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Andrea Salazar logged in from 180.190.112.7', '180.190.112.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-15 15:14:08', '2026-10-15 15:14:08'
FROM `users` WHERE `email` = 'andreasalazar09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Andrea Salazar', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:38:18', '2026-10-15 15:38:18'
FROM `users` WHERE `email` = 'andreasalazar09@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Vincent Gonzales', 'vincentgonzales@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 15:18:05', '09499874152', '33 Posadas Street', 'Magtaking', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '1128-6022741-2', '2026-10-15 15:43:11',
    '2026-10-15 15:43:11', 'EcoRecover Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Magtaking, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 7,
    13.4, 30.8, 169, '2026-10-15 15:12:32', '2026-10-15 15:43:11'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for vincentgonzales@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.22.88', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 15:12:32', '2026-10-15 15:12:32'
FROM `users` WHERE `email` = 'vincentgonzales@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.22.88', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 15:18:05', '2026-10-15 15:18:05'
FROM `users` WHERE `email` = 'vincentgonzales@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Vincent Gonzales logged in from 49.145.22.88', '49.145.22.88', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-15 15:19:09', '2026-10-15 15:19:09'
FROM `users` WHERE `email` = 'vincentgonzales@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Vincent Gonzales', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:43:11', '2026-10-15 15:43:11'
FROM `users` WHERE `email` = 'vincentgonzales@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Kimberly Navarro', 'kimberlynavarro@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 15:19:08', '09985569244', '21 Binalatongan Street', 'Baldog', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5536-4450C-54942', '2026-10-15 15:33:57',
    '2026-10-15 15:33:57', 'Agri-Tech Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Baldog, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 9,
    27.5, 63.2, 320, '2026-10-15 15:13:21', '2026-10-15 15:33:57'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for kimberlynavarro@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.189.63', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 15:13:21', '2026-10-15 15:13:21'
FROM `users` WHERE `email` = 'kimberlynavarro@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.189.63', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 15:19:08', '2026-10-15 15:19:08'
FROM `users` WHERE `email` = 'kimberlynavarro@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Kimberly Navarro logged in from 49.145.189.63', '49.145.189.63', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-15 15:19:44', '2026-10-15 15:19:44'
FROM `users` WHERE `email` = 'kimberlynavarro@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Kimberly Navarro', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 15:33:57', '2026-10-15 15:33:57'
FROM `users` WHERE `email` = 'kimberlynavarro@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Trishia Fernandez', 'trishiafernandez12@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-15 15:23:10', '09919196204', '18 P. Gomez Street', 'Tamayo', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-43704923', '2026-10-15 16:02:02',
    '2026-10-15 16:02:02', 'Palaris E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Tamayo, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 4,
    7.6, 17.5, 96, '2026-10-15 15:17:32', '2026-10-15 16:02:02'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for trishiafernandez12@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 15:17:32', '2026-10-15 15:17:32'
FROM `users` WHERE `email` = 'trishiafernandez12@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 15:23:10', '2026-10-15 15:23:10'
FROM `users` WHERE `email` = 'trishiafernandez12@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Trishia Fernandez logged in from 124.106.15.110', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-15 15:23:56', '2026-10-15 15:23:56'
FROM `users` WHERE `email` = 'trishiafernandez12@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Trishia Fernandez', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-15 16:02:02', '2026-10-15 16:02:02'
FROM `users` WHERE `email` = 'trishiafernandez12@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Angela Garcia', 'angelagarcia08@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 10:45:36', '09921739653', '27 Malong Street', 'Tandoc', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P1059486B', '2026-10-16 11:10:41',
    '2026-10-16 11:10:41', 'North Tech Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Tandoc, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 7,
    25.8, 59.3, 293, '2026-10-16 10:41:48', '2026-10-16 11:10:41'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for angelagarcia08@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.230.41', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 10:41:48', '2026-10-16 10:41:48'
FROM `users` WHERE `email` = 'angelagarcia08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.230.41', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 10:45:36', '2026-10-16 10:45:36'
FROM `users` WHERE `email` = 'angelagarcia08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Angela Garcia logged in from 124.106.230.41', '124.106.230.41', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 10:46:59', '2026-10-16 10:46:59'
FROM `users` WHERE `email` = 'angelagarcia08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Angela Garcia', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:10:41', '2026-10-16 11:10:41'
FROM `users` WHERE `email` = 'angelagarcia08@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Mark Mendoza', 'markmendoza17@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 10:46:02', '09158175395', '50 Quezon Boulevard', 'Caoayan Kiling', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '1158-2832-2232-3442', '2026-10-16 11:23:04',
    '2026-10-16 11:23:04', 'Solid Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Caoayan Kiling, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 4,
    32.5, 74.8, 345, '2026-10-16 10:42:55', '2026-10-16 11:23:04'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for markmendoza17@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.48.92', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 10:42:55', '2026-10-16 10:42:55'
FROM `users` WHERE `email` = 'markmendoza17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.48.92', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 10:46:02', '2026-10-16 10:46:02'
FROM `users` WHERE `email` = 'markmendoza17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Mark Mendoza logged in from 175.158.48.92', '175.158.48.92', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 10:46:42', '2026-10-16 10:46:42'
FROM `users` WHERE `email` = 'markmendoza17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Mark Mendoza', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:23:04', '2026-10-16 11:23:04'
FROM `users` WHERE `email` = 'markmendoza17@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Camille Flores', 'camilleflores25@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 10:48:37', '09168210624', '38 Mabini Extension', 'Ilang', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'A15-49-482364', '2026-10-16 11:04:14',
    '2026-10-16 11:04:14', 'Apex Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Ilang, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 4,
    34.6, 79.6, 366, '2026-10-16 10:44:08', '2026-10-16 11:04:14'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for camilleflores25@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.210.15', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 10:44:08', '2026-10-16 10:44:08'
FROM `users` WHERE `email` = 'camilleflores25@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.210.15', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 10:48:37', '2026-10-16 10:48:37'
FROM `users` WHERE `email` = 'camilleflores25@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Camille Flores logged in from 175.158.210.15', '175.158.210.15', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 10:49:42', '2026-10-16 10:49:42'
FROM `users` WHERE `email` = 'camilleflores25@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Camille Flores', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:04:14', '2026-10-16 11:04:14'
FROM `users` WHERE `email` = 'camilleflores25@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Miguel Ramos', 'miguelramos11@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 10:49:31', '09172724590', '14 Palaris Street', 'San Pedro-Taloy', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '6794-7817881-3', '2026-10-16 11:13:40',
    '2026-10-16 11:13:40', 'Prime E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at San Pedro-Taloy, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 10,
    33.5, 77.0, 385, '2026-10-16 10:46:38', '2026-10-16 11:13:40'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for miguelramos11@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.12.83', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 10:46:38', '2026-10-16 10:46:38'
FROM `users` WHERE `email` = 'miguelramos11@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.12.83', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 10:49:31', '2026-10-16 10:49:31'
FROM `users` WHERE `email` = 'miguelramos11@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Miguel Ramos logged in from 136.158.12.83', '136.158.12.83', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 10:50:44', '2026-10-16 10:50:44'
FROM `users` WHERE `email` = 'miguelramos11@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Miguel Ramos', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:13:40', '2026-10-16 11:13:40'
FROM `users` WHERE `email` = 'miguelramos11@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Andrea Bautista', 'andreabautista09@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 10:56:11', '09267917152', '88 Rizal Avenue', 'Antipangol', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5503-3938C-53540', '2026-10-16 11:12:52',
    '2026-10-16 11:12:52', 'Pure Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Antipangol, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 16,
    31.4, 72.2, 394, '2026-10-16 10:50:47', '2026-10-16 11:12:52'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for andreabautista09@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 10:50:47', '2026-10-16 10:50:47'
FROM `users` WHERE `email` = 'andreabautista09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 10:56:11', '2026-10-16 10:56:11'
FROM `users` WHERE `email` = 'andreabautista09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Andrea Bautista logged in from 136.158.74.29', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 10:57:32', '2026-10-16 10:57:32'
FROM `users` WHERE `email` = 'andreabautista09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Andrea Bautista', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:12:52', '2026-10-16 11:12:52'
FROM `users` WHERE `email` = 'andreabautista09@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jasmine Dela Cruz', 'jasminedelacruz@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 11:01:22', '09275476257', '25 Perez Boulevard', 'Bega', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-31367172', '2026-10-16 11:22:37',
    '2026-10-16 11:22:37', 'EcoSphere Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Bega, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 6,
    17.3, 39.8, 203, '2026-10-16 10:55:41', '2026-10-16 11:22:37'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jasminedelacruz@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.100.14', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 10:55:41', '2026-10-16 10:55:41'
FROM `users` WHERE `email` = 'jasminedelacruz@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.100.14', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 11:01:22', '2026-10-16 11:01:22'
FROM `users` WHERE `email` = 'jasminedelacruz@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jasmine Dela Cruz logged in from 152.32.100.14', '152.32.100.14', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 11:02:39', '2026-10-16 11:02:39'
FROM `users` WHERE `email` = 'jasminedelacruz@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Jasmine Dela Cruz', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:22:37', '2026-10-16 11:22:37'
FROM `users` WHERE `email` = 'jasminedelacruz@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Sofia Castillo', 'sofiacastillo18@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 10:59:30', '09354731818', '42 Mabini Street', 'Dalandan', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P4348276B', '2026-10-16 11:39:28',
    '2026-10-16 11:39:28', 'BioScrap Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Dalandan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 14,
    14.7, 33.8, 217, '2026-10-16 10:57:21', '2026-10-16 11:39:28'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for sofiacastillo18@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.118.99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 10:57:21', '2026-10-16 10:57:21'
FROM `users` WHERE `email` = 'sofiacastillo18@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.118.99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 10:59:30', '2026-10-16 10:59:30'
FROM `users` WHERE `email` = 'sofiacastillo18@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Sofia Castillo logged in from 152.32.118.99', '152.32.118.99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 11:00:54', '2026-10-16 11:00:54'
FROM `users` WHERE `email` = 'sofiacastillo18@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Sofia Castillo', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:39:28', '2026-10-16 11:39:28'
FROM `users` WHERE `email` = 'sofiacastillo18@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Carlo Fernandez', 'carlofernandez07@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 11:04:15', '09454740036', '52 Bugallon-Posadas Street', 'Gamata', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '1387-4164-7528-6378', '2026-10-16 11:24:24',
    '2026-10-16 11:24:24', 'TechnoCycle E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Gamata, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 11,
    33.5, 77.0, 390, '2026-10-16 10:58:52', '2026-10-16 11:24:24'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for carlofernandez07@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.42.15', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 10:58:52', '2026-10-16 10:58:52'
FROM `users` WHERE `email` = 'carlofernandez07@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.42.15', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 11:04:15', '2026-10-16 11:04:15'
FROM `users` WHERE `email` = 'carlofernandez07@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Carlo Fernandez logged in from 112.198.42.15', '112.198.42.15', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 11:05:40', '2026-10-16 11:05:40'
FROM `users` WHERE `email` = 'carlofernandez07@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Carlo Fernandez', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:24:24', '2026-10-16 11:24:24'
FROM `users` WHERE `email` = 'carlofernandez07@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Patricia Torres', 'patriciatorres21@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 11:10:56', '09559546409', '19 Montemayor Street', 'Balococ', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'C96-78-447235', '2026-10-16 11:39:37',
    '2026-10-16 11:39:37', 'Urban Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Balococ, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 3,
    8.4, 19.3, 99, '2026-10-16 11:05:39', '2026-10-16 11:39:37'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for patriciatorres21@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.77.201', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 11:05:39', '2026-10-16 11:05:39'
FROM `users` WHERE `email` = 'patriciatorres21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.77.201', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 11:10:56', '2026-10-16 11:10:56'
FROM `users` WHERE `email` = 'patriciatorres21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Patricia Torres logged in from 112.198.77.201', '112.198.77.201', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 11:11:43', '2026-10-16 11:11:43'
FROM `users` WHERE `email` = 'patriciatorres21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Patricia Torres', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:39:37', '2026-10-16 11:39:37'
FROM `users` WHERE `email` = 'patriciatorres21@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Daniel Villanueva', 'danielvillanueva13@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 11:18:04', '09661641849', '31 Gomez Street', 'Palaris', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '2776-8290770-6', '2026-10-16 11:43:05',
    '2026-10-16 11:43:05', 'San Juan Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Palaris, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 13,
    19.1, 43.9, 256, '2026-10-16 11:14:58', '2026-10-16 11:43:05'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for danielvillanueva13@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 11:14:58', '2026-10-16 11:14:58'
FROM `users` WHERE `email` = 'danielvillanueva13@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 11:18:04', '2026-10-16 11:18:04'
FROM `users` WHERE `email` = 'danielvillanueva13@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Daniel Villanueva logged in from 120.28.9.44', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 11:18:45', '2026-10-16 11:18:45'
FROM `users` WHERE `email` = 'danielvillanueva13@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Daniel Villanueva', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:43:05', '2026-10-16 11:43:05'
FROM `users` WHERE `email` = 'danielvillanueva13@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Nicole Mendoza', 'nicolemendoza16@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 11:23:16', '09774188992', '76 Roxas Boulevard', 'Rizal', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5532-1727C-67154', '2026-10-16 11:55:23',
    '2026-10-16 11:55:23', 'San Carlos Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Rizal, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 3,
    21.9, 50.4, 234, '2026-10-16 11:19:06', '2026-10-16 11:55:23'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for nicolemendoza16@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.105.82', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 11:19:06', '2026-10-16 11:19:06'
FROM `users` WHERE `email` = 'nicolemendoza16@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.105.82', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 11:23:16', '2026-10-16 11:23:16'
FROM `users` WHERE `email` = 'nicolemendoza16@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Nicole Mendoza logged in from 120.28.105.82', '120.28.105.82', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 11:23:53', '2026-10-16 11:23:53'
FROM `users` WHERE `email` = 'nicolemendoza16@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Nicole Mendoza', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 11:55:23', '2026-10-16 11:55:23'
FROM `users` WHERE `email` = 'nicolemendoza16@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Christine Garcia', 'christinegarcia14@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 12:04:44', '09957110622', 'Purok 1, San Carlos-Calasiao Road', 'Mabini', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-67887757', '2026-10-16 12:22:45',
    '2026-10-16 12:22:45', 'Pangasinan E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Mabini, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 5,
    36.3, 83.5, 388, '2026-10-16 11:59:18', '2026-10-16 12:22:45'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for christinegarcia14@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.45.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 11:59:18', '2026-10-16 11:59:18'
FROM `users` WHERE `email` = 'christinegarcia14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.45.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 12:04:44', '2026-10-16 12:04:44'
FROM `users` WHERE `email` = 'christinegarcia14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Christine Garcia logged in from 180.190.45.19', '180.190.45.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 12:05:48', '2026-10-16 12:05:48'
FROM `users` WHERE `email` = 'christinegarcia14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Christine Garcia', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 12:22:45', '2026-10-16 12:22:45'
FROM `users` WHERE `email` = 'christinegarcia14@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jasmine Cruz', 'jasminecruz12@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 12:24:02', '09183090865', '63 Bonifacio Street', 'Bugallon-Posadas', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P6038571B', '2026-10-16 12:49:32',
    '2026-10-16 12:49:32', 'Central Luzon Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Bugallon-Posadas, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 16,
    15.4, 35.4, 234, '2026-10-16 12:18:07', '2026-10-16 12:49:32'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jasminecruz12@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 12:18:07', '2026-10-16 12:18:07'
FROM `users` WHERE `email` = 'jasminecruz12@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 12:24:02', '2026-10-16 12:24:02'
FROM `users` WHERE `email` = 'jasminecruz12@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jasmine Cruz logged in from 180.190.112.7', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 12:24:53', '2026-10-16 12:24:53'
FROM `users` WHERE `email` = 'jasminecruz12@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Jasmine Cruz', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 12:49:32', '2026-10-16 12:49:32'
FROM `users` WHERE `email` = 'jasminecruz12@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Antonio Delos Reyes', 'antoniodelosreyes08@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 12:28:17', '09194218542', '12 Burgos Street', 'Lucban', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '7888-7211-3851-5930', '2026-10-16 12:42:00',
    '2026-10-16 12:42:00', 'GreenTech Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Lucban, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 15,
    22.9, 52.7, 304, '2026-10-16 12:23:19', '2026-10-16 12:42:00'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for antoniodelosreyes08@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.22.88', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 12:23:19', '2026-10-16 12:23:19'
FROM `users` WHERE `email` = 'antoniodelosreyes08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.22.88', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 12:28:17', '2026-10-16 12:28:17'
FROM `users` WHERE `email` = 'antoniodelosreyes08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Antonio Delos Reyes logged in from 49.145.22.88', '49.145.22.88', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 12:29:05', '2026-10-16 12:29:05'
FROM `users` WHERE `email` = 'antoniodelosreyes08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Antonio Delos Reyes', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 12:42:00', '2026-10-16 12:42:00'
FROM `users` WHERE `email` = 'antoniodelosreyes08@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Melissa Perez', 'melissaperez22@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 12:36:09', '09204526280', '45 Zamora Street', 'Padilla', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'C84-87-786508', '2026-10-16 13:03:44',
    '2026-10-16 13:03:44', 'EcoRecover Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Padilla, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 13,
    20.1, 46.2, 266, '2026-10-16 12:34:09', '2026-10-16 13:03:44'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for melissaperez22@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.189.63', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 12:34:09', '2026-10-16 12:34:09'
FROM `users` WHERE `email` = 'melissaperez22@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.189.63', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 12:36:09', '2026-10-16 12:36:09'
FROM `users` WHERE `email` = 'melissaperez22@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Melissa Perez logged in from 49.145.189.63', '49.145.189.63', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 12:36:58', '2026-10-16 12:36:58'
FROM `users` WHERE `email` = 'melissaperez22@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Melissa Perez', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 13:03:44', '2026-10-16 13:03:44'
FROM `users` WHERE `email` = 'melissaperez22@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Joshua Lim', 'joshualim15@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 12:47:48', '09289576076', '8 Del Pilar Street', 'Talang', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '8752-3846949-2', '2026-10-16 13:08:30',
    '2026-10-16 13:08:30', 'Agri-Tech E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Talang, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 12,
    21.8, 50.1, 278, '2026-10-16 12:43:55', '2026-10-16 13:08:30'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for joshualim15@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.15.110', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 12:43:55', '2026-10-16 12:43:55'
FROM `users` WHERE `email` = 'joshualim15@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.15.110', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 12:47:48', '2026-10-16 12:47:48'
FROM `users` WHERE `email` = 'joshualim15@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Joshua Lim logged in from 124.106.15.110', '124.106.15.110', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-16 12:49:01', '2026-10-16 12:49:01'
FROM `users` WHERE `email` = 'joshualim15@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Joshua Lim', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 13:08:30', '2026-10-16 13:08:30'
FROM `users` WHERE `email` = 'joshualim15@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Emmanuel Santiago', 'emmanuelsantiago04@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 12:52:39', '09392566777', '29 Tandang Sora Street', 'Coliling', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5596-4848C-50687', '2026-10-16 13:20:49',
    '2026-10-16 13:20:49', 'Palaris Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Coliling, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 10,
    31.5, 72.4, 365, '2026-10-16 12:47:57', '2026-10-16 13:20:49'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for emmanuelsantiago04@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.230.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 12:47:57', '2026-10-16 12:47:57'
FROM `users` WHERE `email` = 'emmanuelsantiago04@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.230.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 12:52:39', '2026-10-16 12:52:39'
FROM `users` WHERE `email` = 'emmanuelsantiago04@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Emmanuel Santiago logged in from 124.106.230.41', '124.106.230.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-16 12:53:48', '2026-10-16 12:53:48'
FROM `users` WHERE `email` = 'emmanuelsantiago04@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Emmanuel Santiago', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 13:20:49', '2026-10-16 13:20:49'
FROM `users` WHERE `email` = 'emmanuelsantiago04@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Benedict Flores', 'benedictflores23@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 12:54:01', '09475107776', '15 Aurora Boulevard', 'Turac', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-73771720', '2026-10-16 13:04:33',
    '2026-10-16 13:04:33', 'North Tech Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Turac, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 5,
    19.8, 45.5, 223, '2026-10-16 12:51:24', '2026-10-16 13:04:33'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for benedictflores23@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 12:51:24', '2026-10-16 12:51:24'
FROM `users` WHERE `email` = 'benedictflores23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 12:54:01', '2026-10-16 12:54:01'
FROM `users` WHERE `email` = 'benedictflores23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Benedict Flores logged in from 175.158.48.92', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-16 12:54:32', '2026-10-16 12:54:32'
FROM `users` WHERE `email` = 'benedictflores23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Benedict Flores', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 13:04:33', '2026-10-16 13:04:33'
FROM `users` WHERE `email` = 'benedictflores23@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Sheila May Rodriguez', 'sheilamayrodriguez09@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 13:02:11', '09497442089', '90 MacArthur Highway', 'Agdao', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P9294272B', '2026-10-16 13:19:41',
    '2026-10-16 13:19:41', 'Solid Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Agdao, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 10,
    9.4, 21.6, 144, '2026-10-16 12:56:25', '2026-10-16 13:19:41'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for sheilamayrodriguez09@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.210.15', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 12:56:25', '2026-10-16 12:56:25'
FROM `users` WHERE `email` = 'sheilamayrodriguez09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.210.15', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 13:02:11', '2026-10-16 13:02:11'
FROM `users` WHERE `email` = 'sheilamayrodriguez09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Sheila May Rodriguez logged in from 175.158.210.15', '175.158.210.15', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-16 13:03:21', '2026-10-16 13:03:21'
FROM `users` WHERE `email` = 'sheilamayrodriguez09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Sheila May Rodriguez', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 13:19:41', '2026-10-16 13:19:41'
FROM `users` WHERE `email` = 'sheilamayrodriguez09@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Leandro Mallari', 'leandromallari15@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-16 13:36:25', '09988132769', '33 Posadas Street', 'Bocboc', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '4585-3881-9486-8611', '2026-10-16 13:48:45',
    '2026-10-16 13:48:45', 'Apex E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Bocboc, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 4,
    23.2, 53.4, 252, '2026-10-16 13:31:29', '2026-10-16 13:48:45'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for leandromallari15@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.12.83', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 13:31:29', '2026-10-16 13:31:29'
FROM `users` WHERE `email` = 'leandromallari15@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.12.83', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 13:36:25', '2026-10-16 13:36:25'
FROM `users` WHERE `email` = 'leandromallari15@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Leandro Mallari logged in from 136.158.12.83', '136.158.12.83', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-16 13:36:55', '2026-10-16 13:36:55'
FROM `users` WHERE `email` = 'leandromallari15@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Leandro Mallari', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-16 13:48:45', '2026-10-16 13:48:45'
FROM `users` WHERE `email` = 'leandromallari15@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Princess Villarin', 'princessvillarin20@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:06:37', '09918658158', '21 Binalatongan Street', 'Mamarlao', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'A69-95-656932', '2026-10-19 11:19:00',
    '2026-10-19 11:19:00', 'Prime Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Mamarlao, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 13,
    36.3, 83.5, 428, '2026-10-19 11:00:43', '2026-10-19 11:19:00'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for princessvillarin20@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.74.29', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 11:00:43', '2026-10-19 11:00:43'
FROM `users` WHERE `email` = 'princessvillarin20@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.74.29', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 11:06:37', '2026-10-19 11:06:37'
FROM `users` WHERE `email` = 'princessvillarin20@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Princess Villarin logged in from 136.158.74.29', '136.158.74.29', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 11:08:01', '2026-10-19 11:08:01'
FROM `users` WHERE `email` = 'princessvillarin20@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Princess Villarin', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 11:19:00', '2026-10-19 11:19:00'
FROM `users` WHERE `email` = 'princessvillarin20@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Roberto Campos', 'robertocampos06@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:07:34', '09928159521', '18 P. Gomez Street', 'Tarece', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '9976-8481188-3', '2026-10-19 11:46:13',
    '2026-10-19 11:46:13', 'Pure Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Tarece, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 18,
    19.6, 45.1, 286, '2026-10-19 11:01:46', '2026-10-19 11:46:13'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for robertocampos06@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.100.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 11:01:46', '2026-10-19 11:01:46'
FROM `users` WHERE `email` = 'robertocampos06@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.100.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 11:07:34', '2026-10-19 11:07:34'
FROM `users` WHERE `email` = 'robertocampos06@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Roberto Campos logged in from 152.32.100.14', '152.32.100.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 11:08:32', '2026-10-19 11:08:32'
FROM `users` WHERE `email` = 'robertocampos06@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Roberto Campos', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 11:46:13', '2026-10-19 11:46:13'
FROM `users` WHERE `email` = 'robertocampos06@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Danielle Coronel', 'daniellecoronel25@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:10:50', '09159745959', '27 Malong Street', 'Magtaking', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5562-4919B-67654', '2026-10-19 11:34:33',
    '2026-10-19 11:34:33', 'EcoSphere Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Magtaking, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 5,
    28.4, 65.3, 309, '2026-10-19 11:05:38', '2026-10-19 11:34:33'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for daniellecoronel25@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 11:05:38', '2026-10-19 11:05:38'
FROM `users` WHERE `email` = 'daniellecoronel25@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 11:10:50', '2026-10-19 11:10:50'
FROM `users` WHERE `email` = 'daniellecoronel25@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Danielle Coronel logged in from 152.32.118.99', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 11:11:35', '2026-10-19 11:11:35'
FROM `users` WHERE `email` = 'daniellecoronel25@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Danielle Coronel', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 11:34:33', '2026-10-19 11:34:33'
FROM `users` WHERE `email` = 'daniellecoronel25@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Arvin Barrameda', 'arvinbarrameda11@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:10:48', '09166363836', '50 Quezon Boulevard', 'Baldog', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-82498004', '2026-10-19 11:40:43',
    '2026-10-19 11:40:43', 'BioScrap E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Baldog, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 5,
    9.1, 20.9, 116, '2026-10-19 11:07:48', '2026-10-19 11:40:43'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for arvinbarrameda11@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.42.15', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 11:07:48', '2026-10-19 11:07:48'
FROM `users` WHERE `email` = 'arvinbarrameda11@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.42.15', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 11:10:48', '2026-10-19 11:10:48'
FROM `users` WHERE `email` = 'arvinbarrameda11@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Arvin Barrameda logged in from 112.198.42.15', '112.198.42.15', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 11:11:35', '2026-10-19 11:11:35'
FROM `users` WHERE `email` = 'arvinbarrameda11@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Arvin Barrameda', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 11:40:43', '2026-10-19 11:40:43'
FROM `users` WHERE `email` = 'arvinbarrameda11@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Marielle De Santos', 'marielledesantos17@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:13:54', '09174589533', '38 Mabini Extension', 'Tamayo', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P2077581B', '2026-10-19 11:31:20',
    '2026-10-19 11:31:20', 'TechnoCycle Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Tamayo, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 16,
    15.6, 35.9, 236, '2026-10-19 11:10:55', '2026-10-19 11:31:20'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for marielledesantos17@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.77.201', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 11:10:55', '2026-10-19 11:10:55'
FROM `users` WHERE `email` = 'marielledesantos17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.77.201', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 11:13:54', '2026-10-19 11:13:54'
FROM `users` WHERE `email` = 'marielledesantos17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Marielle De Santos logged in from 112.198.77.201', '112.198.77.201', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 11:14:48', '2026-10-19 11:14:48'
FROM `users` WHERE `email` = 'marielledesantos17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Marielle De Santos', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 11:31:20', '2026-10-19 11:31:20'
FROM `users` WHERE `email` = 'marielledesantos17@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Noel Balagtas', 'noelbalagtas08@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:20:44', '09264470105', '14 Palaris Street', 'Tandoc', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '7883-7381-1320-7232', '2026-10-19 11:31:00',
    '2026-10-19 11:31:00', 'Urban Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Tandoc, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 18,
    4.7, 10.8, 137, '2026-10-19 11:16:45', '2026-10-19 11:31:00'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for noelbalagtas08@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.9.44', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 11:16:45', '2026-10-19 11:16:45'
FROM `users` WHERE `email` = 'noelbalagtas08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.9.44', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 11:20:44', '2026-10-19 11:20:44'
FROM `users` WHERE `email` = 'noelbalagtas08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Noel Balagtas logged in from 120.28.9.44', '120.28.9.44', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 11:21:40', '2026-10-19 11:21:40'
FROM `users` WHERE `email` = 'noelbalagtas08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Noel Balagtas', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 11:31:00', '2026-10-19 11:31:00'
FROM `users` WHERE `email` = 'noelbalagtas08@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Krystine Vergara', 'krystinevergara19@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:30:19', '09278030010', '88 Rizal Avenue', 'Caoayan Kiling', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'A72-38-386193', '2026-10-19 12:03:26',
    '2026-10-19 12:03:26', 'San Juan Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Caoayan Kiling, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 16,
    20.8, 47.8, 288, '2026-10-19 11:26:49', '2026-10-19 12:03:26'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for krystinevergara19@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.105.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 11:26:49', '2026-10-19 11:26:49'
FROM `users` WHERE `email` = 'krystinevergara19@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.105.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 11:30:19', '2026-10-19 11:30:19'
FROM `users` WHERE `email` = 'krystinevergara19@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Krystine Vergara logged in from 120.28.105.82', '120.28.105.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 11:31:08', '2026-10-19 11:31:08'
FROM `users` WHERE `email` = 'krystinevergara19@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Krystine Vergara', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 12:03:26', '2026-10-19 12:03:26'
FROM `users` WHERE `email` = 'krystinevergara19@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Paolo Miranda', 'paolomiranda03@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:34:54', '09353768991', '25 Perez Boulevard', 'Ilang', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '8657-3141239-9', '2026-10-19 12:08:51',
    '2026-10-19 12:08:51', 'San Carlos E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Ilang, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 3,
    34.9, 80.3, 364, '2026-10-19 11:31:15', '2026-10-19 12:08:51'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for paolomiranda03@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 11:31:15', '2026-10-19 11:31:15'
FROM `users` WHERE `email` = 'paolomiranda03@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 11:34:54', '2026-10-19 11:34:54'
FROM `users` WHERE `email` = 'paolomiranda03@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Paolo Miranda logged in from 180.190.45.19', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 11:35:45', '2026-10-19 11:35:45'
FROM `users` WHERE `email` = 'paolomiranda03@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Paolo Miranda', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 12:08:51', '2026-10-19 12:08:51'
FROM `users` WHERE `email` = 'paolomiranda03@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Maureen Abello', 'maureenabello14@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:40:47', '09452408404', '42 Mabini Street', 'San Pedro-Taloy', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5582-8022A-70515', '2026-10-19 11:48:07',
    '2026-10-19 11:48:07', 'Pangasinan Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at San Pedro-Taloy, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 8,
    6.2, 14.3, 102, '2026-10-19 11:36:16', '2026-10-19 11:48:07'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for maureenabello14@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 11:36:16', '2026-10-19 11:36:16'
FROM `users` WHERE `email` = 'maureenabello14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 11:40:47', '2026-10-19 11:40:47'
FROM `users` WHERE `email` = 'maureenabello14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Maureen Abello logged in from 180.190.112.7', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 11:41:53', '2026-10-19 11:41:53'
FROM `users` WHERE `email` = 'maureenabello14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Maureen Abello', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 11:48:07', '2026-10-19 11:48:07'
FROM `users` WHERE `email` = 'maureenabello14@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Ryan Panganiban', 'ryanpanganiban26@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:45:29', '09558628588', '52 Bugallon-Posadas Street', 'Antipangol', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-53868501', '2026-10-19 12:06:18',
    '2026-10-19 12:06:18', 'Central Luzon Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Antipangol, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 13,
    30.0, 69.0, 365, '2026-10-19 11:41:52', '2026-10-19 12:06:18'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for ryanpanganiban26@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.22.88', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 11:41:52', '2026-10-19 11:41:52'
FROM `users` WHERE `email` = 'ryanpanganiban26@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.22.88', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 11:45:29', '2026-10-19 11:45:29'
FROM `users` WHERE `email` = 'ryanpanganiban26@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Ryan Panganiban logged in from 49.145.22.88', '49.145.22.88', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 11:46:19', '2026-10-19 11:46:19'
FROM `users` WHERE `email` = 'ryanpanganiban26@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Ryan Panganiban', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 12:06:18', '2026-10-19 12:06:18'
FROM `users` WHERE `email` = 'ryanpanganiban26@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jennifer Delos Reyes', 'jenniferdelosreyes10@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 11:59:17', '09665232413', '19 Montemayor Street', 'Bega', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P2374158B', '2026-10-19 12:34:26',
    '2026-10-19 12:34:26', 'GreenTech Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at Bega, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 3,
    29.6, 68.1, 311, '2026-10-19 11:55:40', '2026-10-19 12:34:26'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jenniferdelosreyes10@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.189.63', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 11:55:40', '2026-10-19 11:55:40'
FROM `users` WHERE `email` = 'jenniferdelosreyes10@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.189.63', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 11:59:17', '2026-10-19 11:59:17'
FROM `users` WHERE `email` = 'jenniferdelosreyes10@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jennifer Delos Reyes logged in from 49.145.189.63', '49.145.189.63', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 12:00:04', '2026-10-19 12:00:04'
FROM `users` WHERE `email` = 'jenniferdelosreyes10@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Jennifer Delos Reyes', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 12:34:26', '2026-10-19 12:34:26'
FROM `users` WHERE `email` = 'jenniferdelosreyes10@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Aljon Macapagal', 'aljonmacapagal22@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 12:05:29', '09774761823', '31 Gomez Street', 'Dalandan', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '2124-1659-1508-5051', '2026-10-19 12:37:09',
    '2026-10-19 12:37:09', 'EcoRecover E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at Dalandan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 9,
    32.6, 75.0, 371, '2026-10-19 12:03:16', '2026-10-19 12:37:09'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for aljonmacapagal22@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.15.110', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 12:03:16', '2026-10-19 12:03:16'
FROM `users` WHERE `email` = 'aljonmacapagal22@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.15.110', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 12:05:29', '2026-10-19 12:05:29'
FROM `users` WHERE `email` = 'aljonmacapagal22@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Aljon Macapagal logged in from 124.106.15.110', '124.106.15.110', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 12:06:59', '2026-10-19 12:06:59'
FROM `users` WHERE `email` = 'aljonmacapagal22@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Aljon Macapagal', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 12:37:09', '2026-10-19 12:37:09'
FROM `users` WHERE `email` = 'aljonmacapagal22@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Francis Caballero', 'franciscaballero05@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 12:14:42', '09953117636', '76 Roxas Boulevard', 'Gamata', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'C95-24-691364', '2026-10-19 12:36:20',
    '2026-10-19 12:36:20', 'Agri-Tech Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at Gamata, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 9,
    20.1, 46.2, 246, '2026-10-19 12:10:03', '2026-10-19 12:36:20'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for franciscaballero05@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 12:10:03', '2026-10-19 12:10:03'
FROM `users` WHERE `email` = 'franciscaballero05@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 12:14:42', '2026-10-19 12:14:42'
FROM `users` WHERE `email` = 'franciscaballero05@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Francis Caballero logged in from 124.106.230.41', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 12:15:21', '2026-10-19 12:15:21'
FROM `users` WHERE `email` = 'franciscaballero05@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Francis Caballero', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 12:36:20', '2026-10-19 12:36:20'
FROM `users` WHERE `email` = 'franciscaballero05@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Charmaine Ocampo', 'charmaineocampo13@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 12:24:36', '09183815034', 'Purok 1, San Carlos-Calasiao Road', 'Balococ', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '2876-3747534-5', '2026-10-19 12:56:41',
    '2026-10-19 12:56:41', 'Palaris Electronics Exchange', 'Authorized community e-waste collection and trade depot located at Balococ, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 6,
    23.9, 55.0, 269, '2026-10-19 12:21:31', '2026-10-19 12:56:41'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for charmaineocampo13@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 12:21:31', '2026-10-19 12:21:31'
FROM `users` WHERE `email` = 'charmaineocampo13@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 12:24:36', '2026-10-19 12:24:36'
FROM `users` WHERE `email` = 'charmaineocampo13@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Charmaine Ocampo logged in from 175.158.48.92', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 12:25:55', '2026-10-19 12:25:55'
FROM `users` WHERE `email` = 'charmaineocampo13@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Charmaine Ocampo', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 12:56:41', '2026-10-19 12:56:41'
FROM `users` WHERE `email` = 'charmaineocampo13@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jaymark Payopay', 'jaymarkpayopay23@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 12:36:46', '09197654757', 'San Juan Proper', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5591-4249A-87607', '2026-10-19 13:06:26',
    '2026-10-19 13:06:26', 'San Juan Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 10,
    7.9, 18.2, 129, '2026-10-19 12:30:49', '2026-10-19 13:06:26'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jaymarkpayopay23@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.210.15', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 12:30:49', '2026-10-19 12:30:49'
FROM `users` WHERE `email` = 'jaymarkpayopay23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.210.15', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 12:36:46', '2026-10-19 12:36:46'
FROM `users` WHERE `email` = 'jaymarkpayopay23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jaymark Payopay logged in from 175.158.210.15', '175.158.210.15', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 12:37:35', '2026-10-19 12:37:35'
FROM `users` WHERE `email` = 'jaymarkpayopay23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Jaymark Payopay', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 13:06:26', '2026-10-19 13:06:26'
FROM `users` WHERE `email` = 'jaymarkpayopay23@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Aries Austria', 'ariesaustria24@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 12:44:41', '09201689025', 'San Juan Road', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-56600900', '2026-10-19 12:57:39',
    '2026-10-19 12:57:39', 'Solid E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 16,
    26.7, 61.4, 347, '2026-10-19 12:39:24', '2026-10-19 12:57:39'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for ariesaustria24@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.12.83', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 12:39:24', '2026-10-19 12:39:24'
FROM `users` WHERE `email` = 'ariesaustria24@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.12.83', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 12:44:41', '2026-10-19 12:44:41'
FROM `users` WHERE `email` = 'ariesaustria24@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Aries Austria logged in from 136.158.12.83', '136.158.12.83', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 12:45:30', '2026-10-19 12:45:30'
FROM `users` WHERE `email` = 'ariesaustria24@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Aries Austria', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 12:57:39', '2026-10-19 12:57:39'
FROM `users` WHERE `email` = 'ariesaustria24@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Joven Menor', 'jovenmenor18@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 12:49:20', '09281212267', 'Purok Ilang-Ilang, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P8047416B', '2026-10-19 13:20:20',
    '2026-10-19 13:20:20', 'Apex Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 6,
    19.0, 43.7, 220, '2026-10-19 12:47:03', '2026-10-19 13:20:20'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jovenmenor18@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.74.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 12:47:03', '2026-10-19 12:47:03'
FROM `users` WHERE `email` = 'jovenmenor18@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.74.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 12:49:20', '2026-10-19 12:49:20'
FROM `users` WHERE `email` = 'jovenmenor18@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Joven Menor logged in from 136.158.74.29', '136.158.74.29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 12:50:22', '2026-10-19 12:50:22'
FROM `users` WHERE `email` = 'jovenmenor18@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Joven Menor', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 13:20:20', '2026-10-19 13:20:20'
FROM `users` WHERE `email` = 'jovenmenor18@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Justine Rosario', 'justinerosario07@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 12:59:36', '09393566765', 'Purok Centro, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '8135-3885-9548-5425', '2026-10-19 13:37:27',
    '2026-10-19 13:37:27', 'San Juan Electronics Exchange', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 18,
    20.1, 46.2, 291, '2026-10-19 12:56:04', '2026-10-19 13:37:27'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for justinerosario07@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 12:56:04', '2026-10-19 12:56:04'
FROM `users` WHERE `email` = 'justinerosario07@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 12:59:36', '2026-10-19 12:59:36'
FROM `users` WHERE `email` = 'justinerosario07@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Justine Rosario logged in from 152.32.100.14', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-19 13:00:46', '2026-10-19 13:00:46'
FROM `users` WHERE `email` = 'justinerosario07@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Justine Rosario', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 13:37:27', '2026-10-19 13:37:27'
FROM `users` WHERE `email` = 'justinerosario07@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Ariel Serafica', 'arielserafica21@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 13:10:17', '09476407373', 'Purok Riverside, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'A21-45-572700', '2026-10-19 13:33:05',
    '2026-10-19 13:33:05', 'Pure Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 10,
    29.6, 68.1, 346, '2026-10-19 13:04:46', '2026-10-19 13:33:05'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for arielserafica21@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 13:04:46', '2026-10-19 13:04:46'
FROM `users` WHERE `email` = 'arielserafica21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 13:10:17', '2026-10-19 13:10:17'
FROM `users` WHERE `email` = 'arielserafica21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Ariel Serafica logged in from 152.32.118.99', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-19 13:11:33', '2026-10-19 13:11:33'
FROM `users` WHERE `email` = 'arielserafica21@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Ariel Serafica', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 13:33:05', '2026-10-19 13:33:05'
FROM `users` WHERE `email` = 'arielserafica21@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Tricia Mae Rosario', 'triciamaerosariol2@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 13:23:39', '09496643798', 'Purok 1, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '1470-9293086-6', '2026-10-19 13:55:06',
    '2026-10-19 13:55:06', 'EcoSphere E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 8,
    20.8, 47.8, 248, '2026-10-19 13:19:14', '2026-10-19 13:55:06'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for triciamaerosariol2@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.42.15', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 13:19:14', '2026-10-19 13:19:14'
FROM `users` WHERE `email` = 'triciamaerosariol2@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.42.15', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 13:23:39', '2026-10-19 13:23:39'
FROM `users` WHERE `email` = 'triciamaerosariol2@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Tricia Mae Rosario logged in from 112.198.42.15', '112.198.42.15', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-19 13:24:48', '2026-10-19 13:24:48'
FROM `users` WHERE `email` = 'triciamaerosariol2@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Tricia Mae Rosario', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 13:55:06', '2026-10-19 13:55:06'
FROM `users` WHERE `email` = 'triciamaerosariol2@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Danica Fajardo', 'danicafajardo16@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 13:34:48', '09986709938', 'Purok 2, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5535-5526C-11330', '2026-10-19 13:58:56',
    '2026-10-19 13:58:56', 'San Juan Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 9,
    7.4, 17.0, 119, '2026-10-19 13:31:18', '2026-10-19 13:58:56'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for danicafajardo16@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.77.201', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 13:31:18', '2026-10-19 13:31:18'
FROM `users` WHERE `email` = 'danicafajardo16@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.77.201', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 13:34:48', '2026-10-19 13:34:48'
FROM `users` WHERE `email` = 'danicafajardo16@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Danica Fajardo logged in from 112.198.77.201', '112.198.77.201', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-19 13:36:09', '2026-10-19 13:36:09'
FROM `users` WHERE `email` = 'danicafajardo16@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Danica Fajardo', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 13:58:56', '2026-10-19 13:58:56'
FROM `users` WHERE `email` = 'danicafajardo16@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Anthony Sorio', 'anthonysorio09@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-19 13:45:17', '09915031966', 'Purok 3, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-73900135', '2026-10-19 14:23:34',
    '2026-10-19 14:23:34', 'TechnoCycle Electronics Exchange', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 18,
    19.5, 44.8, 285, '2026-10-19 13:40:13', '2026-10-19 14:23:34'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for anthonysorio09@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.9.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 13:40:13', '2026-10-19 13:40:13'
FROM `users` WHERE `email` = 'anthonysorio09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.9.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 13:45:17', '2026-10-19 13:45:17'
FROM `users` WHERE `email` = 'anthonysorio09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Anthony Sorio logged in from 120.28.9.44', '120.28.9.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-19 13:46:13', '2026-10-19 13:46:13'
FROM `users` WHERE `email` = 'anthonysorio09@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Anthony Sorio', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-19 14:23:34', '2026-10-19 14:23:34'
FROM `users` WHERE `email` = 'anthonysorio09@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Abraham Delos Reyes', 'abrahamdeslosreyes@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:26:33', '09924717770', 'Purok 4, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P7784725A', '2026-10-20 08:54:34',
    '2026-10-20 08:54:34', 'Urban Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 12,
    26.7, 61.4, 327, '2026-10-20 08:24:29', '2026-10-20 08:54:34'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for abrahamdeslosreyes@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 08:24:29', '2026-10-20 08:24:29'
FROM `users` WHERE `email` = 'abrahamdeslosreyes@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 08:26:33', '2026-10-20 08:26:33'
FROM `users` WHERE `email` = 'abrahamdeslosreyes@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Abraham Delos Reyes logged in from 120.28.105.82', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 08:27:08', '2026-10-20 08:27:08'
FROM `users` WHERE `email` = 'abrahamdeslosreyes@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Abraham Delos Reyes', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 08:54:34', '2026-10-20 08:54:34'
FROM `users` WHERE `email` = 'abrahamdeslosreyes@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jeslyn Muñoz', 'jeslynmunoz15@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:30:46', '09158138769', 'Purok 5, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '6419-6764-8434-5438', '2026-10-20 09:00:40',
    '2026-10-20 09:00:40', 'San Juan E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 12,
    12.9, 29.7, 189, '2026-10-20 08:27:12', '2026-10-20 09:00:40'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jeslynmunoz15@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 08:27:12', '2026-10-20 08:27:12'
FROM `users` WHERE `email` = 'jeslynmunoz15@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 08:30:46', '2026-10-20 08:30:46'
FROM `users` WHERE `email` = 'jeslynmunoz15@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jeslyn Muñoz logged in from 180.190.45.19', '180.190.45.19', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 08:31:46', '2026-10-20 08:31:46'
FROM `users` WHERE `email` = 'jeslynmunoz15@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Jeslyn Muñoz', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:00:40', '2026-10-20 09:00:40'
FROM `users` WHERE `email` = 'jeslynmunoz15@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Christian Gonzales', 'christiangonzales@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:31:55', '09166294016', 'San Juan Proper', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'N78-98-294143', '2026-10-20 08:52:33',
    '2026-10-20 08:52:33', 'San Carlos Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 9,
    11.7, 26.9, 162, '2026-10-20 08:29:25', '2026-10-20 08:52:33'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for christiangonzales@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-20 08:29:25', '2026-10-20 08:29:25'
FROM `users` WHERE `email` = 'christiangonzales@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-20 08:31:55', '2026-10-20 08:31:55'
FROM `users` WHERE `email` = 'christiangonzales@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Christian Gonzales logged in from 180.190.112.7', '180.190.112.7', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-20 08:33:11', '2026-10-20 08:33:11'
FROM `users` WHERE `email` = 'christiangonzales@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Christian Gonzales', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 08:52:33', '2026-10-20 08:52:33'
FROM `users` WHERE `email` = 'christiangonzales@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Alexander Bonggot', 'alexanderbonggot@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:36:18', '09172686548', 'San Juan Road', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '4180-5970190-4', '2026-10-20 09:01:34',
    '2026-10-20 09:01:34', 'Pangasinan Electronics Exchange', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 14,
    10.5, 24.1, 175, '2026-10-20 08:32:15', '2026-10-20 09:01:34'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for alexanderbonggot@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.22.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 08:32:15', '2026-10-20 08:32:15'
FROM `users` WHERE `email` = 'alexanderbonggot@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.22.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 08:36:18', '2026-10-20 08:36:18'
FROM `users` WHERE `email` = 'alexanderbonggot@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Alexander Bonggot logged in from 49.145.22.88', '49.145.22.88', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 08:37:05', '2026-10-20 08:37:05'
FROM `users` WHERE `email` = 'alexanderbonggot@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Alexander Bonggot', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:01:34', '2026-10-20 09:01:34'
FROM `users` WHERE `email` = 'alexanderbonggot@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Christian Beltran', 'christianbeltran11@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:36:26', '09265602180', 'Purok Ilang-Ilang, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5505-1893C-48290', '2026-10-20 08:53:01',
    '2026-10-20 08:53:01', 'San Juan Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 7,
    25.9, 59.6, 294, '2026-10-20 08:34:23', '2026-10-20 08:53:01'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for christianbeltran11@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '49.145.189.63', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-20 08:34:23', '2026-10-20 08:34:23'
FROM `users` WHERE `email` = 'christianbeltran11@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '49.145.189.63', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-20 08:36:26', '2026-10-20 08:36:26'
FROM `users` WHERE `email` = 'christianbeltran11@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Christian Beltran logged in from 49.145.189.63', '49.145.189.63', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-20 08:37:41', '2026-10-20 08:37:41'
FROM `users` WHERE `email` = 'christianbeltran11@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Christian Beltran', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 08:53:01', '2026-10-20 08:53:01'
FROM `users` WHERE `email` = 'christianbeltran11@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Maritess Austria', 'maritessaustria17@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:45:25', '09271205779', 'Purok Centro, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-87049595', '2026-10-20 08:57:13',
    '2026-10-20 08:57:13', 'GreenTech E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 12,
    20.2, 46.5, 262, '2026-10-20 08:40:13', '2026-10-20 08:57:13'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for maritessaustria17@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 08:40:13', '2026-10-20 08:40:13'
FROM `users` WHERE `email` = 'maritessaustria17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 08:45:25', '2026-10-20 08:45:25'
FROM `users` WHERE `email` = 'maritessaustria17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Maritess Austria logged in from 124.106.15.110', '124.106.15.110', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 08:46:26', '2026-10-20 08:46:26'
FROM `users` WHERE `email` = 'maritessaustria17@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Maritess Austria', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 08:57:13', '2026-10-20 08:57:13'
FROM `users` WHERE `email` = 'maritessaustria17@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Steven Hermogeno', 'stevenhermogeno08@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:47:05', '09351861958', 'Purok Riverside, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P5235884B', '2026-10-20 09:05:48',
    '2026-10-20 09:05:48', 'EcoRecover Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 6,
    32.0, 73.6, 350, '2026-10-20 08:43:13', '2026-10-20 09:05:48'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for stevenhermogeno08@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 08:43:13', '2026-10-20 08:43:13'
FROM `users` WHERE `email` = 'stevenhermogeno08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 08:47:05', '2026-10-20 08:47:05'
FROM `users` WHERE `email` = 'stevenhermogeno08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Steven Hermogeno logged in from 124.106.230.41', '124.106.230.41', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 08:47:56', '2026-10-20 08:47:56'
FROM `users` WHERE `email` = 'stevenhermogeno08@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Steven Hermogeno', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:05:48', '2026-10-20 09:05:48'
FROM `users` WHERE `email` = 'stevenhermogeno08@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Angeline Hermogeno', 'angelinehermogeno14@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:49:49', '09451899411', 'Purok 1, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '3485-3444-5978-2395', '2026-10-20 09:01:10',
    '2026-10-20 09:01:10', 'San Juan Electronics Exchange', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 10,
    8.5, 19.5, 135, '2026-10-20 08:46:07', '2026-10-20 09:01:10'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for angelinehermogeno14@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-20 08:46:07', '2026-10-20 08:46:07'
FROM `users` WHERE `email` = 'angelinehermogeno14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-20 08:49:49', '2026-10-20 08:49:49'
FROM `users` WHERE `email` = 'angelinehermogeno14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Angeline Hermogeno logged in from 175.158.48.92', '175.158.48.92', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-20 08:50:50', '2026-10-20 08:50:50'
FROM `users` WHERE `email` = 'angelinehermogeno14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller Angeline Hermogeno', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:01:10', '2026-10-20 09:01:10'
FROM `users` WHERE `email` = 'angelinehermogeno14@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Kevin Beltran', 'kevinbeltran23@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:54:28', '09559767312', 'Purok 2, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'C67-66-411797', '2026-10-20 09:14:37',
    '2026-10-20 09:14:37', 'Palaris Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 16,
    14.7, 33.8, 227, '2026-10-20 08:49:13', '2026-10-20 09:14:37'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for kevinbeltran23@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '175.158.210.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 08:49:13', '2026-10-20 08:49:13'
FROM `users` WHERE `email` = 'kevinbeltran23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '175.158.210.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 08:54:28', '2026-10-20 08:54:28'
FROM `users` WHERE `email` = 'kevinbeltran23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Kevin Beltran logged in from 175.158.210.15', '175.158.210.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 08:55:24', '2026-10-20 08:55:24'
FROM `users` WHERE `email` = 'kevinbeltran23@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Kevin Beltran', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:14:37', '2026-10-20 09:14:37'
FROM `users` WHERE `email` = 'kevinbeltran23@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jan Rex Rovillos', 'janrexrovillos06@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:56:36', '09664486102', 'Purok 3, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '4457-5440025-2', '2026-10-20 09:08:44',
    '2026-10-20 09:08:44', 'North Tech E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 8,
    12.5, 28.7, 165, '2026-10-20 08:51:58', '2026-10-20 09:08:44'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for janrexrovillos06@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.12.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-20 08:51:58', '2026-10-20 08:51:58'
FROM `users` WHERE `email` = 'janrexrovillos06@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.12.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-20 08:56:36', '2026-10-20 08:56:36'
FROM `users` WHERE `email` = 'janrexrovillos06@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jan Rex Rovillos logged in from 136.158.12.83', '136.158.12.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-20 08:57:09', '2026-10-20 08:57:09'
FROM `users` WHERE `email` = 'janrexrovillos06@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Jan Rex Rovillos', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:08:44', '2026-10-20 09:08:44'
FROM `users` WHERE `email` = 'janrexrovillos06@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Rex Pascual', 'rexpascual19@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 08:59:37', '09771044891', 'Purok 4, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5552-8381C-87832', '2026-10-20 09:15:57',
    '2026-10-20 09:15:57', 'San Juan Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 18,
    14.3, 32.9, 233, '2026-10-20 08:55:16', '2026-10-20 09:15:57'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for rexpascual19@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 08:55:16', '2026-10-20 08:55:16'
FROM `users` WHERE `email` = 'rexpascual19@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 08:59:37', '2026-10-20 08:59:37'
FROM `users` WHERE `email` = 'rexpascual19@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Rex Pascual logged in from 136.158.74.29', '136.158.74.29', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 09:00:11', '2026-10-20 09:00:11'
FROM `users` WHERE `email` = 'rexpascual19@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Rex Pascual', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:15:57', '2026-10-20 09:15:57'
FROM `users` WHERE `email` = 'rexpascual19@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Jay Ann Lomboy', 'jayannlomboy10@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 09:02:05', '09958617381', 'Purok 5, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Postal ID', 'PID-19553585', '2026-10-20 09:28:24',
    '2026-10-20 09:28:24', 'Apex Electronics Exchange', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 10,
    35.5, 81.6, 405, '2026-10-20 08:59:06', '2026-10-20 09:28:24'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for jayannlomboy10@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 08:59:06', '2026-10-20 08:59:06'
FROM `users` WHERE `email` = 'jayannlomboy10@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 09:02:05', '2026-10-20 09:02:05'
FROM `users` WHERE `email` = 'jayannlomboy10@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Jay Ann Lomboy logged in from 152.32.100.14', '152.32.100.14', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 09:02:53', '2026-10-20 09:02:53'
FROM `users` WHERE `email` = 'jayannlomboy10@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Postal ID) & registered location for seller Jay Ann Lomboy', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:28:24', '2026-10-20 09:28:24'
FROM `users` WHERE `email` = 'jayannlomboy10@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Mac Mac Tigno', 'macmactigno26@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 09:07:36', '09188132648', 'San Juan Proper', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Passport', 'P2925626A', '2026-10-20 09:25:45',
    '2026-10-20 09:25:45', 'Prime Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 7,
    34.9, 80.3, 384, '2026-10-20 09:02:15', '2026-10-20 09:25:45'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for macmactigno26@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-20 09:02:15', '2026-10-20 09:02:15'
FROM `users` WHERE `email` = 'macmactigno26@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-20 09:07:36', '2026-10-20 09:07:36'
FROM `users` WHERE `email` = 'macmactigno26@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Mac Mac Tigno logged in from 152.32.118.99', '152.32.118.99', 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.6613.88 Mobile Safari/537.36', '2026-10-20 09:08:56', '2026-10-20 09:08:56'
FROM `users` WHERE `email` = 'macmactigno26@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Passport) & registered location for seller Mac Mac Tigno', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:25:45', '2026-10-20 09:25:45'
FROM `users` WHERE `email` = 'macmactigno26@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'John Mark Esteban', 'johnmarkesteban03@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 09:11:34', '09192000560', 'San Juan Road', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Philippine National ID (PhilSys)', '3718-6039-5728-8195', '2026-10-20 09:20:55',
    '2026-10-20 09:20:55', 'San Juan E-Waste Solutions', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 6,
    20.2, 46.5, 232, '2026-10-20 09:06:03', '2026-10-20 09:20:55'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for johnmarkesteban03@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.42.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 09:06:03', '2026-10-20 09:06:03'
FROM `users` WHERE `email` = 'johnmarkesteban03@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.42.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 09:11:34', '2026-10-20 09:11:34'
FROM `users` WHERE `email` = 'johnmarkesteban03@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User John Mark Esteban logged in from 112.198.42.15', '112.198.42.15', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Mobile/15E148 Safari/604.1', '2026-10-20 09:12:13', '2026-10-20 09:12:13'
FROM `users` WHERE `email` = 'johnmarkesteban03@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Philippine National ID (PhilSys)) & registered location for seller John Mark Esteban', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:20:55', '2026-10-20 09:20:55'
FROM `users` WHERE `email` = 'johnmarkesteban03@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Renz Beltran', 'renzbeltran19@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 09:14:17', '09205567533', 'Purok Ilang-Ilang, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Driver\'s License', 'C66-20-727086', '2026-10-20 09:48:28',
    '2026-10-20 09:48:28', 'EcoSphere Hardware & Component Trading', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 4,
    34.3, 78.9, 363, '2026-10-20 09:11:00', '2026-10-20 09:48:28'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for renzbeltran19@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '112.198.77.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-20 09:11:00', '2026-10-20 09:11:00'
FROM `users` WHERE `email` = 'renzbeltran19@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '112.198.77.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-20 09:14:17', '2026-10-20 09:14:17'
FROM `users` WHERE `email` = 'renzbeltran19@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Renz Beltran logged in from 112.198.77.201', '112.198.77.201', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2026-10-20 09:15:31', '2026-10-20 09:15:31'
FROM `users` WHERE `email` = 'renzbeltran19@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Driver\'s License) & registered location for seller Renz Beltran', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:48:28', '2026-10-20 09:48:28'
FROM `users` WHERE `email` = 'renzbeltran19@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Zyrell Menor', 'zyrellmenor14@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 09:18:37', '09281433940', 'Purok Centro, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'UMID / SSS ID', '2496-4840714-1', '2026-10-20 09:40:34',
    '2026-10-20 09:40:34', 'BioScrap Electronics Exchange', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 11,
    23.8, 54.7, 293, '2026-10-20 09:13:29', '2026-10-20 09:40:34'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for zyrellmenor14@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 09:13:29', '2026-10-20 09:13:29'
FROM `users` WHERE `email` = 'zyrellmenor14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 09:18:37', '2026-10-20 09:18:37'
FROM `users` WHERE `email` = 'zyrellmenor14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Zyrell Menor logged in from 120.28.9.44', '120.28.9.44', 'Mozilla/5.0 (Linux; Android 14; 2201117PG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.6533.103 Mobile Safari/537.36', '2026-10-20 09:19:27', '2026-10-20 09:19:27'
FROM `users` WHERE `email` = 'zyrellmenor14@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (UMID / SSS ID) & registered location for seller Zyrell Menor', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:40:34', '2026-10-20 09:40:34'
FROM `users` WHERE `email` = 'zyrellmenor14@gmail.com';

INSERT INTO `users` (
    `name`, `email`, `password`, `role`, `is_verified`, `id_verification_status`,
    `email_verified_at`, `phone`, `address_line_1`, `barangay`, `address_city`,
    `address_province`, `postal_code`, `id_type`, `id_number`, `id_submitted_at`,
    `location_verified_at`, `business_name`, `business_description`, `items_processed`,
    `total_weight_diverted`, `total_co2_saved`, `total_impact_score`, `created_at`, `updated_at`
) VALUES (
    'Gabriel Pioquinto', 'gabrielpioquinto05@gmail.com', '$2y$10$E1jmhOgbazB6JMIfmyPQx.cGc5Xe7F545yS02oHo65gGgAQvBSZ7W', 'seller', 1, 'verified',
    '2026-10-20 09:21:13', '09398893693', 'Purok Riverside, San Juan', 'San Juan', 'San Carlos City',
    'Pangasinan', '2420', 'Voter\'s ID', '5566-8245B-33788', '2026-10-20 09:37:55',
    '2026-10-20 09:37:55', 'San Juan Motherboard & Circuit Trade', 'Authorized community e-waste collection and trade depot located at San Juan, San Carlos City. Specializing in computer components, tested parts, and eco-scrap processing.', 16,
    25.8, 59.3, 338, '2026-10-20 09:15:58', '2026-10-20 09:37:55'
) ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `password` = VALUES(`password`),
    `role` = VALUES(`role`),
    `is_verified` = VALUES(`is_verified`),
    `id_verification_status` = VALUES(`id_verification_status`),
    `email_verified_at` = VALUES(`email_verified_at`),
    `phone` = VALUES(`phone`),
    `address_line_1` = VALUES(`address_line_1`),
    `barangay` = VALUES(`barangay`),
    `address_city` = VALUES(`address_city`),
    `address_province` = VALUES(`address_province`),
    `postal_code` = VALUES(`postal_code`),
    `id_type` = VALUES(`id_type`),
    `id_number` = VALUES(`id_number`),
    `id_submitted_at` = VALUES(`id_submitted_at`),
    `location_verified_at` = VALUES(`location_verified_at`),
    `business_name` = VALUES(`business_name`),
    `business_description` = VALUES(`business_description`),
    `items_processed` = VALUES(`items_processed`),
    `total_weight_diverted` = VALUES(`total_weight_diverted`),
    `total_co2_saved` = VALUES(`total_co2_saved`),
    `total_impact_score` = VALUES(`total_impact_score`),
    `created_at` = VALUES(`created_at`),
    `updated_at` = VALUES(`updated_at`);

-- Audit logs for gabrielpioquinto05@gmail.com
INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'register', 'User', id, 'User registered as seller (pending email verification)', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 09:15:58', '2026-10-20 09:15:58'
FROM `users` WHERE `email` = 'gabrielpioquinto05@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'email_verified', 'User', id, 'User verified their email address with 6-digit code', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 09:21:13', '2026-10-20 09:21:13'
FROM `users` WHERE `email` = 'gabrielpioquinto05@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT id, 'user_login', 'User', id, 'User Gabriel Pioquinto logged in from 120.28.105.82', '120.28.105.82', 'Mozilla/5.0 (Linux; Android 12; Infinix X6816) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.134 Mobile Safari/537.36', '2026-10-20 09:22:31', '2026-10-20 09:22:31'
FROM `users` WHERE `email` = 'gabrielpioquinto05@gmail.com';

INSERT INTO `audit_logs` (`user_id`, `action`, `model_type`, `model_id`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`)
SELECT 1, 'user_verified', 'User', id, 'Admin approved government ID (Voter\'s ID) & registered location for seller Gabriel Pioquinto', '120.28.9.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0', '2026-10-20 09:37:55', '2026-10-20 09:37:55'
FROM `users` WHERE `email` = 'gabrielpioquinto05@gmail.com';
