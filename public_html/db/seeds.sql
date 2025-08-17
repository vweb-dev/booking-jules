-- Luxury Talent Booking - RCE - Database Seeds
-- version 1.0

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
-- Seeding data for table `talent_media`
--
INSERT INTO `talent_media` (`user_id`, `media_type`, `file_path`, `thumb_path`, `aspect_ratio`, `approval_status`) VALUES
(3, 'image', 'uploads/photos/sample-9-16.jpg', 'uploads/photos/thumb-sample-9-16.jpg', '9:16', 'approved');

-- Note: A sample image file 'sample-9-16.jpg' should be placed in the `public_html/uploads/photos` directory for this seed to work fully.
-- A placeholder will be added to the assets directory later.
