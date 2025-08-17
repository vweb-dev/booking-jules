-- Luxury Talent Booking - RCE - Database Seeds
-- version 1.1

SET NAMES utf8mb4;
SET time_zone = '+00:00';

--
-- Seeding data for table `roles`
--
INSERT INTO `roles` (`id`, `role_name`, `description`) VALUES
(1, 'Super Admin', 'System-wide administrator with access to all settings.'),
(2, 'Tenant Admin', 'Administrator for a specific company/tenant.'),
(3, 'Talent', 'Talent user with a public profile.'),
(4, 'Client', 'Client user who can book talent.');

--
-- Seeding data for table `companies`
--
INSERT INTO `companies` (`id`, `name`, `tier`) VALUES
(1, 'Elite Model Management', 'Elite'),
(2, 'Basic Talent Agency', 'Basic');

--
-- Seeding data for table `users`
-- Note: All users have the password 'password123'
-- The hash is: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
--
INSERT INTO `users` (`id`, `role_id`, `company_id`, `email`, `password_hash`, `first_name`, `last_name`, `is_active`) VALUES
(1, 1, NULL, 'sa@luxetalent.app', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Super', 'Admin', 1),
(2, 2, 1, 'admin@elitemodel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Smith', 1),
(3, 3, 1, 'gisele@elitemodel.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Gisele', 'Bundchen', 1),
(4, 4, 1, 'tom@brady.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Tom', 'Brady', 1);

--
-- Seeding data for table `talent_profiles`
--
INSERT INTO `talent_profiles` (`user_id`, `company_id`, `public_profile_url`, `bio`, `location_city`, `location_state`, `location_country`, `lat`, `lng`, `willing_to_travel`, `privacy_level`, `age`, `height_cm`, `hair_color`, `eye_color`) VALUES
(3, 1, 'gisele-b', 'International supermodel.', 'New York', 'NY', 'USA', 40.7128, -74.0060, 1, 'public', 35, 180, 'Blonde', 'Blue');


--
-- Note on media seeding:
-- The initial seed for `talent_media` has been removed because the environment
-- prevents the creation of the required placeholder image file. The application
-- will install and run correctly, but the initial explore feed will be empty
-- until a Tenant Admin approves uploaded media.
--
