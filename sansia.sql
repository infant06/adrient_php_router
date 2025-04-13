-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2025 at 07:26 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sansia`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `short_description` text COLLATE utf8_bin,
  `content` text COLLATE utf8_bin,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `short_description`, `content`, `image`, `category_id`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 'Transforming Communities Through Education', 'How education initiatives are changing lives in underserved communities', '<p>Education is the most powerful tool for transforming communities. At Sansia NGO, we believe that every child deserves access to quality education regardless of their background.</p><p>Through our various educational initiatives across multiple regions, we have witnessed firsthand how education can break the cycle of poverty and create lasting change. This article explores our journey in establishing learning centers in rural areas and the impact they have had on local communities.</p><p>Over the past year, we have built 5 new learning centers, trained 25 local teachers, and provided educational resources to over 500 children. The results speak for themselves - improved literacy rates, higher school attendance, and growing community involvement in educational matters.</p>', 'education-initiative.jpg', 2, 1, '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(2, 'Clean Water Project Reaches 10 New Villages', 'Celebrating the success of our ongoing clean water initiative', '<p>Access to clean water is a fundamental human right, yet millions around the world still lack this basic necessity. Our Clean Water Project has been working tirelessly to address this critical issue in remote communities.</p><p>We are thrilled to announce that our initiative has recently expanded to include 10 additional villages, bringing clean, safe drinking water to approximately 15,000 more people. This expansion marks a significant milestone in our mission to combat waterborne diseases and improve quality of life in underserved regions.</p><p>The project involves installing water purification systems, digging wells, and educating communities about water conservation and hygiene practices. Our team works closely with local leaders to ensure sustainability and community ownership of these resources.</p>', 'clean-water.jpg', 4, 2, '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(3, 'Youth Leadership Camp Empowers Future Leaders', 'A recap of our most successful youth camp to date', '<p>The future belongs to the youth, and empowering them with the right skills and mindset is crucial for sustainable development. Our annual Youth Leadership Camp aims to nurture the next generation of community leaders and change-makers.</p><p>This year\'s camp brought together 150 young individuals from diverse backgrounds for a week of intensive leadership training, team-building activities, and community service projects. The participants engaged in workshops on critical thinking, effective communication, project management, and ethical leadership.</p><p>The highlight of the camp was the community project competition, where teams designed and presented solutions to real challenges facing their communities. The winning project, which focused on reducing plastic waste through an innovative recycling program, will receive funding and mentorship to bring their idea to life.</p>', 'youth-leadership.jpg', 1, 1, '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(4, 'Healthcare Clinic Celebrates One Year Anniversary', 'Looking back at a year of providing essential medical care', '<p>Healthcare accessibility remains a significant challenge in many communities, particularly in rural areas where medical facilities are scarce. A year ago, Sansia NGO opened a healthcare clinic to address this critical need, and today we celebrate the remarkable impact it has had.</p><p>Over the past 12 months, our clinic has served more than 5,000 patients, conducted 200 health education sessions, and provided vaccinations to 1,200 children. Our dedicated team of healthcare professionals has worked tirelessly to ensure that quality medical care is available to everyone in the community, regardless of their ability to pay.</p><p>In addition to treating illnesses, the clinic has focused on preventive care and health education, empowering community members to take charge of their wellbeing. Monthly health workshops have covered topics such as nutrition, maternal health, disease prevention, and first aid.</p>', 'healthcare-clinic.jpg', 3, 2, '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(5, 'Environmental Conservation: Planting 5000 Trees', 'Our reforestation efforts are making a significant impact', '<p>Climate change and deforestation pose existential threats to our planet and communities. At Sansia NGO, we are committed to environmental conservation through our reforestation program, which aims to restore degraded landscapes and promote biodiversity.</p><p>We are proud to report that our recent campaign successfully planted 5,000 native trees across several regions. This achievement was made possible through the collaborative efforts of 300 volunteers, local schools, and community organizations who dedicated their time and energy to this vital cause.</p><p>The benefits of this initiative extend beyond environmental restoration. The reforested areas will help prevent soil erosion, enhance water retention, create habitats for wildlife, and contribute to carbon sequestration. Moreover, the project has created economic opportunities for local communities through sustainable forestry practices and ecotourism potential.</p>', 'tree-planting.jpg', 4, 3, '2025-04-13 11:15:26', '2025-04-13 11:15:26');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `type` enum('blog','service','event','contact') COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `type`, `description`, `created_at`) VALUES
(1, 'Community Development', 'blog', 'Articles about community development projects and initiatives', '2025-04-13 11:15:26'),
(2, 'Education', 'blog', 'Posts related to educational programs and achievements', '2025-04-13 11:15:26'),
(3, 'Healthcare', 'blog', 'Information about healthcare initiatives and programs', '2025-04-13 11:15:26'),
(4, 'Environment', 'blog', 'Content focused on environmental conservation and sustainability', '2025-04-13 11:15:26'),
(5, 'Youth Programs', 'service', 'Services focused on youth development and empowerment', '2025-04-13 11:15:26'),
(6, 'Community Outreach', 'service', 'Outreach programs for community engagement', '2025-04-13 11:15:26'),
(7, 'Health Services', 'service', 'Healthcare and wellness services for communities', '2025-04-13 11:15:26'),
(8, 'Educational Support', 'service', 'Educational assistance and resources', '2025-04-13 11:15:26'),
(9, 'Fundraising', 'event', 'Events aimed at raising funds for various causes', '2025-04-13 11:15:26'),
(10, 'Workshop', 'event', 'Educational and skill-building workshops', '2025-04-13 11:15:26'),
(11, 'Community Gathering', 'event', 'Events that bring the community together', '2025-04-13 11:15:26'),
(12, 'Volunteer Training', 'event', 'Training sessions for volunteers and staff', '2025-04-13 11:15:26'),
(13, 'General Inquiry', 'contact', 'General questions about the organization', '2025-04-13 11:15:26'),
(14, 'Volunteer Application', 'contact', 'Inquiries about volunteering opportunities', '2025-04-13 11:15:26'),
(15, 'Donation', 'contact', 'Questions related to donations and financial support', '2025-04-13 11:15:26'),
(16, 'Partnership', 'contact', 'Partnership proposals and collaborations', '2025-04-13 11:15:26');

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `subject` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `message` text COLLATE utf8_bin NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` enum('new','in_progress','completed') COLLATE utf8_bin DEFAULT 'new',
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `contact_submissions`
--

INSERT INTO `contact_submissions` (`id`, `name`, `email`, `subject`, `message`, `category_id`, `status`, `submission_date`) VALUES
(1, 'James Wilson', 'james.wilson@example.com', 'Volunteer Opportunities', 'I\'m interested in volunteering for your organization. I have experience in teaching and would like to help with your educational programs. Please let me know what opportunities are available and how I can get involved.', 14, 'new', '2025-04-13 11:15:26'),
(2, 'Emily Johnson', 'emily.j@example.com', 'Donation Question', 'I would like to make a monthly donation to support your clean water initiative. Could you provide information about how the funds will be used and what percentage goes directly to program implementation? Thank you for the important work you\'re doing.', 15, 'in_progress', '2025-04-13 11:15:26'),
(3, 'David Martinez', 'david.m@example.com', 'Partnership Proposal', 'Our company is interested in partnering with Sansia NGO for our corporate social responsibility program. We believe there are synergies between our goals and your mission. I would appreciate the opportunity to discuss potential collaboration opportunities.', 16, 'new', '2025-04-13 11:15:26'),
(4, 'Sarah Thompson', 'sarah.t@example.com', 'School Visit Request', 'I am a teacher at Lincoln High School and would like to arrange for someone from your organization to speak to our students about environmental conservation and community service. We think this would be a valuable experience for our students.', 13, 'completed', '2025-04-13 11:15:26'),
(5, 'Michael Brown', 'michael.b@example.com', 'Newsletter Subscription', 'I recently learned about your organization and the important work you do. I would like to subscribe to your newsletter to stay informed about your projects and upcoming events.', 13, 'new', '2025-04-13 11:15:26');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `event_date` datetime NOT NULL,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `image`, `category_id`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Annual Charity Gala', 'Join us for our biggest fundraising event of the year. Enjoy an evening of entertainment, auctions, and networking while supporting our various community initiatives.', '2025-06-15 18:00:00', 'charity-gala.jpg', 9, 'Grand Ballroom, Hilton Hotel', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(2, 'Community Health Workshop', 'A comprehensive workshop on preventive healthcare, nutrition, and wellness practices. Free health screenings will be available for all attendees.', '2025-04-25 10:00:00', 'health-workshop.jpg', 10, 'Sansia Community Center', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(3, 'Volunteer Orientation', 'New volunteers are invited to learn about our organization, ongoing projects, and how they can contribute their skills and time to make a difference.', '2025-05-10 14:00:00', 'volunteer-orientation.jpg', 12, 'Sansia Headquarters, Training Room 2', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(4, 'Earth Day Celebration', 'Celebrate Earth Day with tree planting, recycling activities, environmental education, and a community cleanup. Family-friendly event with activities for all ages.', '2025-04-22 09:00:00', 'earth-day.jpg', 11, 'City Park', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(5, 'Youth Leadership Conference', 'A day-long conference featuring inspiring speakers, skill-building workshops, and networking opportunities for young people aged 16-25 interested in community leadership.', '2025-07-12 09:30:00', 'youth-conference.jpg', 10, 'University Conference Center', '2025-04-13 11:15:26', '2025-04-13 11:15:26');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `image`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'After-School Tutoring Program', 'Free academic support for students in grades 1-12, focusing on core subjects like math, science, language arts, and reading comprehension. Our trained tutors work with small groups or provide one-on-one assistance tailored to each student\'s needs.', 'tutoring.jpg', 8, '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(2, 'Community Healthcare Clinic', 'Providing accessible healthcare services including general check-ups, vaccinations, maternal care, and health education. Our clinic operates on a sliding scale fee system to ensure everyone can receive the care they need regardless of financial circumstances.', 'healthcare.jpg', 7, '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(3, 'Youth Mentorship Program', 'Connecting young people with positive role models who provide guidance, support, and encouragement. Mentors help youth develop life skills, explore career interests, and navigate challenges while building self-confidence and resilience.', 'mentorship.jpg', 5, '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(4, 'Environmental Conservation Projects', 'Engaging communities in environmental stewardship through tree planting, habitat restoration, recycling initiatives, and environmental education. We organize regular clean-up events and work with schools to develop eco-friendly practices.', 'conservation.jpg', 6, '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(5, 'Job Skills Training', 'Equipping individuals with marketable skills through workshops, certification courses, and hands-on training. Programs include computer literacy, financial management, vocational skills, and entrepreneurship development.', 'job-skills.jpg', 8, '2025-04-13 11:15:26', '2025-04-13 11:15:26');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_group` varchar(50) COLLATE utf8_bin NOT NULL,
  `setting_key` varchar(100) COLLATE utf8_bin NOT NULL,
  `setting_value` text COLLATE utf8_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_group`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'general', 'site_name', 'Sansia NGO - Community Development Organization', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(2, 'general', 'site_description', 'Sansia NGO is a non-profit organization dedicated to community development, education, healthcare, and environmental conservation.', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(3, 'general', 'contact_email', 'info@sansia.org', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(4, 'general', 'contact_phone', '+1 (555) 123-4567', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(5, 'general', 'address', '123 Main Street, Suite 456, New York, NY 10001', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(6, 'seo', 'home_title', 'Sansia NGO - Empowering Communities Through Sustainable Development', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(7, 'seo', 'home_description', 'Sansia NGO works with communities around the world to implement sustainable development projects in education, healthcare, and environmental conservation.', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(8, 'seo', 'home_keywords', 'NGO, non-profit, community development, sustainable development, education, healthcare, environment', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(9, 'seo', 'home_og_image', 'https://example.com/images/sansia-og-image.jpg', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(10, 'seo', '_about_title', 'About Sansia NGO - Our Mission, Vision, and Values', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(11, 'seo', '_about_description', 'Learn about Sansia NGO\'s mission, vision, values, team, and our approach to sustainable community development.', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(12, 'seo', '_about_keywords', 'about us, NGO mission, vision, values, team, sustainable development', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(13, 'seo', '_about_og_image', 'https://example.com/images/about-og-image.jpg', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(14, 'seo', '_contact_title', 'Contact Sansia NGO - Get in Touch With Our Team', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(15, 'seo', '_contact_description', 'Contact Sansia NGO for partnership opportunities, volunteering, donations, or general inquiries. We\'re here to help.', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(16, 'seo', '_contact_keywords', 'contact NGO, get in touch, volunteer, donate, partnership', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(17, 'seo', '_contact_og_image', 'https://example.com/images/contact-og-image.jpg', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(18, 'seo', '_blog_title', 'Sansia NGO Blog - News, Updates, and Stories from the Field', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(19, 'seo', '_blog_description', 'Stay updated with Sansia NGO\'s latest news, project updates, success stories, and insights from our work in communities worldwide.', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(20, 'seo', '_blog_keywords', 'NGO blog, community development news, project updates, success stories', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(21, 'seo', '_blog_og_image', 'https://example.com/images/blog-og-image.jpg', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(22, 'seo', '_services_title', 'Our Services - How Sansia NGO Helps Communities', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(23, 'seo', '_services_description', 'Explore the range of services and programs offered by Sansia NGO to support sustainable community development.', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(24, 'seo', '_services_keywords', 'NGO services, community programs, education services, healthcare initiatives, environmental projects', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(25, 'seo', '_services_og_image', 'https://example.com/images/services-og-image.jpg', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(26, 'social', 'facebook', 'https://facebook.com/sansia.ngo', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(27, 'social', 'twitter', 'https://twitter.com/sansia_ngo', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(28, 'social', 'instagram', 'https://instagram.com/sansia_ngo', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(29, 'social', 'linkedin', 'https://linkedin.com/company/sansia-ngo', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(30, 'social', 'youtube', 'https://youtube.com/c/SansiaNGO', '2025-04-13 11:15:26', '2025-04-13 11:15:26'),
(31, 'email', 'mail_mailer', 'smtp', '2025-04-13 12:06:26', '2025-04-13 12:06:26'),
(32, 'email', 'smtp_host', 'smtp.hostinger.com', '2025-04-13 12:06:26', '2025-04-13 12:06:26'),
(33, 'email', 'smtp_port', ' 465', '2025-04-13 12:06:26', '2025-04-13 12:06:26'),
(34, 'email', 'smtp_encryption', 'tls', '2025-04-13 12:06:26', '2025-04-13 12:06:26'),
(35, 'email', 'smtp_username', 'demo@adrient.com', '2025-04-13 12:06:26', '2025-04-13 12:06:26'),
(36, 'email', 'mail_from_address', 'demo@adrient.com', '2025-04-13 12:06:26', '2025-04-13 12:06:26'),
(37, 'email', 'mail_from_name', 'Adrient tech', '2025-04-13 12:06:26', '2025-04-13 12:06:26'),
(38, 'email', 'smtp_password', 'adrient12', '2025-04-13 12:06:26', '2025-04-13 12:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `traffic_logs`
--

CREATE TABLE `traffic_logs` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `page_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `visit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_agent` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `referrer` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `traffic_logs`
--

INSERT INTO `traffic_logs` (`id`, `ip_address`, `page_name`, `visit_time`, `user_agent`, `referrer`) VALUES
(1, '192.168.1.1', 'Home', '2025-04-12 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(2, '192.168.1.2', 'About', '2025-04-11 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(3, '192.168.1.3', 'Services', '2025-04-10 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(4, '192.168.1.4', 'Blog', '2025-04-09 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(5, '192.168.1.5', 'Contact', '2025-04-08 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(6, '192.168.1.6', 'Home', '2025-04-07 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(7, '192.168.1.7', 'About', '2025-04-06 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(8, '192.168.1.8', 'Services', '2025-04-05 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(9, '192.168.1.9', 'Blog', '2025-04-04 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(10, '192.168.1.10', 'Contact', '2025-04-03 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(11, '192.168.1.11', 'Home', '2025-04-02 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(12, '192.168.1.12', 'About', '2025-04-01 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(13, '192.168.1.13', 'Services', '2025-03-31 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(14, '192.168.1.14', 'Blog', '2025-03-30 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(15, '192.168.1.15', 'Contact', '2025-03-29 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(16, '192.168.50.82', 'Home', '2025-04-10 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(17, '192.168.138.92', 'Home', '2025-03-22 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(18, '192.168.76.53', 'Home', '2025-04-10 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(19, '192.168.41.111', 'Blog', '2025-04-08 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(20, '192.168.209.144', 'About', '2025-04-12 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(21, '192.168.55.233', 'Contact', '2025-03-18 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(22, '192.168.178.204', 'Contact', '2025-04-09 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(23, '192.168.9.179', 'Services', '2025-03-16 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(24, '192.168.122.146', 'Services', '2025-04-02 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(25, '192.168.171.50', 'Contact', '2025-04-08 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(26, '192.168.24.228', 'Home', '2025-04-05 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(27, '192.168.205.51', 'Services', '2025-04-04 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(28, '192.168.213.61', 'Blog', '2025-03-25 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(29, '192.168.73.110', 'About', '2025-04-06 11:15:26', 'Mozilla/5.0', 'https://google.com'),
(30, '192.168.98.33', 'Services', '2025-04-13 11:15:26', 'Mozilla/5.0', 'https://google.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `full_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `iv` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `phone` bigint(250) DEFAULT NULL,
  `role` enum('admin','editor','user') COLLATE utf8_bin NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `iv`, `phone`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$8I0txX96A0QVlPH3Z9pV.O/xQ.339BnIbFJLPAq8CxMGvnBJidJiO', 'admin@sansia.org', 'Admin User', NULL, NULL, 'admin', '2025-04-13 11:15:26'),
(2, 'editor', '$2y$10$oPM5U8Z2WAOusZAuJOffB.Ab6T04M/0FXLFHQ1TdULGctXDQgiKN.', 'editor@sansia.org', 'Editor User', NULL, NULL, 'editor', '2025-04-13 11:15:26'),
(3, 'user', '$2y$10$qG2DalISkeT/G8uJklj48eUMQI7ydzb9wMj9F6Jn8ejFpZ2VHJkG2', 'user@example.com', 'Regular User', NULL, NULL, 'user', '2025-04-13 11:15:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_setting` (`setting_group`,`setting_key`);

--
-- Indexes for table `traffic_logs`
--
ALTER TABLE `traffic_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `traffic_logs`
--
ALTER TABLE `traffic_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
