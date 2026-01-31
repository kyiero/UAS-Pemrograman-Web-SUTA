-- Database: cms_suta
-- Religious Study / Pengajian CMS

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table structure for table `users`
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','author','viewer') DEFAULT 'viewer',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `categories`
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text,
  `icon` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `articles`
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `views` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `schedules`
CREATE TABLE `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `ustadz` varchar(100) NOT NULL,
  `location` varchar(200) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `event_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `settings`
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_type` varchar(50) DEFAULT 'text',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user
-- Password: admin123 (hashed with bcrypt)
INSERT INTO `users` (`username`, `email`, `password`, `full_name`, `role`, `is_active`) VALUES
('admin', 'admin@pengajian.local', '$2y$10$/EqQjj9MkfrEftKOIBDLBeJL94B0Ve87LnBLLLP55B7pXIF4/sbcW', 'Administrator', 'admin', 1);

-- Insert default categories
INSERT INTO `categories` (`name`, `slug`, `description`, `icon`, `is_active`) VALUES
('Tafsir Al-Quran', 'tafsir-al-quran', 'Kajian mendalam tentang tafsir dan makna Al-Quran', 'fa-book-quran', 1),
('Hadits', 'hadits', 'Pembahasan hadits Nabi Muhammad SAW', 'fa-scroll', 1),
('Fiqih', 'fiqih', 'Hukum Islam dan pembahasan fiqih', 'fa-scale-balanced', 1),
('Akhlaq', 'akhlaq', 'Pembahasan tentang akhlak dan adab Islami', 'fa-heart', 1),
('Sirah Nabawiyah', 'sirah-nabawiyah', 'Sejarah kehidupan Rasulullah SAW', 'fa-mosque', 1),
('Aqidah', 'aqidah', 'Pembahasan tentang aqidah dan tauhid', 'fa-star-and-crescent', 1);

-- Insert default settings
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`) VALUES
('site_name', 'CMS Pengajian', 'text'),
('site_description', 'Portal Kajian Islam dan Pengajian', 'text'),
('site_keywords', 'pengajian, islam, kajian, hadits, tafsir, fiqih', 'text'),
('site_email', 'info@pengajian.local', 'email'),
('articles_per_page', '10', 'number'),
('enable_registration', '0', 'boolean');

-- Insert sample articles
INSERT INTO `articles` (`category_id`, `user_id`, `title`, `slug`, `content`, `excerpt`, `status`, `is_featured`, `published_at`) VALUES
(1, 1, 'Pengenalan Tafsir Al-Quran', 'pengenalan-tafsir-al-quran', 
'<p>Tafsir Al-Quran adalah ilmu yang membahas tentang makna dan maksud ayat-ayat Al-Quran. Mempelajari tafsir sangat penting agar kita dapat memahami pesan-pesan Allah SWT dengan benar.</p>

<h3>Pentingnya Mempelajari Tafsir</h3>
<p>Mempelajari tafsir membantu kita:</p>
<ul>
<li>Memahami makna ayat dengan benar</li>
<li>Mengetahui konteks turunnya ayat (asbabun nuzul)</li>
<li>Mengamalkan Al-Quran dalam kehidupan sehari-hari</li>
<li>Terhindar dari pemahaman yang salah</li>
</ul>

<h3>Metode Mempelajari Tafsir</h3>
<p>Ada beberapa metode dalam mempelajari tafsir, antara lain:</p>
<ol>
<li>Tafsir bil Ma\'tsur (tafsir dengan riwayat)</li>
<li>Tafsir bil Ra\'yi (tafsir dengan akal/ijtihad)</li>
<li>Tafsir Maudhu\'i (tafsir tematik)</li>
</ol>',
'Pengenalan dasar tentang ilmu tafsir Al-Quran dan pentingnya mempelajarinya dalam memahami firman Allah SWT.', 
'published', 1, NOW()),

(2, 1, 'Mengenal Ilmu Hadits', 'mengenal-ilmu-hadits',
'<p>Hadits adalah segala sesuatu yang disandarkan kepada Nabi Muhammad SAW, baik berupa perkataan, perbuatan, maupun ketetapan. Ilmu hadits sangat penting sebagai sumber hukum Islam kedua setelah Al-Quran.</p>

<h3>Klasifikasi Hadits</h3>
<p>Hadits diklasifikasikan berdasarkan beberapa aspek:</p>
<ul>
<li><strong>Berdasarkan kualitas:</strong> Shahih, Hasan, Dhaif</li>
<li><strong>Berdasarkan jumlah perawi:</strong> Mutawatir, Ahad</li>
<li><strong>Berdasarkan sanad:</strong> Muttashil, Munqathi</li>
</ul>

<h3>Cara Meriwayatkan Hadits</h3>
<p>Para ulama telah menetapkan metode yang ketat dalam meriwayatkan hadits untuk menjaga kemurniannya, termasuk sistem sanad dan penelitian terhadap para perawi.</p>',
'Pemahaman dasar tentang ilmu hadits, klasifikasi, dan pentingnya dalam Islam.',
'published', 1, NOW()),

(3, 1, 'Dasar-Dasar Fiqih Islam', 'dasar-dasar-fiqih-islam',
'<p>Fiqih adalah pemahaman tentang hukum-hukum syariat Islam yang bersifat praktis, yang diambil dari dalil-dalil yang terperinci.</p>

<h3>Sumber Hukum Fiqih</h3>
<p>Sumber utama hukum fiqih meliputi:</p>
<ol>
<li>Al-Quran</li>
<li>As-Sunnah</li>
<li>Ijma (kesepakatan ulama)</li>
<li>Qiyas (analogi hukum)</li>
</ol>

<h3>Hukum Taklifi</h3>
<p>Dalam fiqih, terdapat lima kategori hukum:</p>
<ul>
<li>Wajib (Fardhu)</li>
<li>Sunnah (Mandub)</li>
<li>Mubah (Jaiz)</li>
<li>Makruh</li>
<li>Haram</li>
</ul>',
'Pengenalan dasar-dasar ilmu fiqih dan sumber-sumber hukum Islam.',
'published', 0, NOW());

-- Insert sample schedules
INSERT INTO `schedules` (`title`, `description`, `ustadz`, `location`, `event_date`, `event_time`, `duration`) VALUES
('Kajian Tafsir Juz Amma', 'Kajian rutin tafsir surat-surat pendek dalam juz 30', 'Ustadz Ahmad Fauzi', 'Masjid Al-Ikhlas', DATE_ADD(CURDATE(), INTERVAL 3 DAY), '19:30:00', '90 menit'),
('Kajian Hadits Shahih Bukhari', 'Pembahasan hadits-hadits pilihan dari Shahih Bukhari', 'Ustadz Muhammad Ridwan', 'Masjid Nurul Huda', DATE_ADD(CURDATE(), INTERVAL 5 DAY), '20:00:00', '60 menit'),
('Belajar Fiqih Ibadah', 'Membahas fiqih praktis dalam kehidupan sehari-hari', 'Ustadz Abdullah Salam', 'Islamic Center', DATE_ADD(CURDATE(), INTERVAL 7 DAY), '15:00:00', '120 menit'),
('Kajian Akhlak Tasawuf', 'Pembahasan tentang akhlak dan penyucian jiwa', 'Ustadz Yusuf Hakim', 'Masjid At-Taqwa', DATE_ADD(CURDATE(), INTERVAL 10 DAY), '19:00:00', '90 menit');

COMMIT;
