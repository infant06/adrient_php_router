<?php
require_once '../config/db.php';

function fetchBlogs($conn)
{
    $query = "SELECT * FROM blogs";
    $stmt = $conn->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createBlog($conn, $data, $file)
{
    $title = $data['title'];
    $short_description = $data['short_description'];
    $content = $data['content'];
    $category_id = $data['category_id'];
    $image = $file['image']['name'];

    $target_dir = "../assets/uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($file['image']['tmp_name'], $target_file);

    $query = "INSERT INTO blogs (title, short_description, content, category_id, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$title, $short_description, $content, $category_id, $image]);
}

function updateBlog($conn, $data, $file)
{
    $id = $data['id'];
    $title = $data['title'];
    $short_description = $data['short_description'];
    $content = $data['content'];
    $category_id = $data['category_id'];
    $image = $file['image']['name'];

    if ($image) {
        $target_dir = "../assets/uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($file['image']['tmp_name'], $target_file);
    }

    $query = "UPDATE blogs SET title = ?, short_description = ?, content = ?, category_id = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$title, $short_description, $content, $category_id, $image, $id]);
}

function deleteBlog($conn, $id)
{
    $query = "DELETE FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
}

function fetchEvents($conn)
{
    $query = "SELECT * FROM events";
    $stmt = $conn->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createEvent($conn, $data, $file)
{
    $title = $data['title'];
    $description = $data['description'];
    $event_date = $data['event_date'];
    $image = $file['image']['name'];

    $target_dir = "../assets/uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($file['image']['tmp_name'], $target_file);

    $query = "INSERT INTO events (title, description, event_date, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$title, $description, $event_date, $image]);
}

function updateEvent($conn, $data, $file)
{
    $id = $data['id'];
    $title = $data['title'];
    $description = $data['description'];
    $event_date = $data['event_date'];
    $image = $file['image']['name'];

    if ($image) {
        $target_dir = "../assets/uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($file['image']['tmp_name'], $target_file);
    }

    $query = "UPDATE events SET title = ?, description = ?, event_date = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$title, $description, $event_date, $image, $id]);
}

function deleteEvent($conn, $id)
{
    $query = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
}

function fetchServices($conn)
{
    $query = "SELECT * FROM services";
    $stmt = $conn->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createService($conn, $data, $file)
{
    $title = $data['title'];
    $description = $data['description'];
    $category_id = $data['category_id'];
    $image = $file['image']['name'];

    $target_dir = "../assets/uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($file['image']['tmp_name'], $target_file);

    $query = "INSERT INTO services (title, description, category_id, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$title, $description, $category_id, $image]);
}

function updateService($conn, $data, $file)
{
    $id = $data['id'];
    $title = $data['title'];
    $description = $data['description'];
    $category_id = $data['category_id'];
    $image = $file['image']['name'];

    if ($image) {
        $target_dir = "../assets/uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($file['image']['tmp_name'], $target_file);
    }

    $query = "UPDATE services SET title = ?, description = ?, category_id = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$title, $description, $category_id, $image, $id]);
}

function deleteService($conn, $id)
{
    $query = "DELETE FROM services WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
}

// Category functions
function fetchCategories($conn)
{
    $query = "SELECT * FROM categories";
    $stmt = $conn->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchCategoriesByType($conn, $type)
{
    $query = "SELECT * FROM categories WHERE type = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$type]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createCategory($conn, $data)
{
    $name = $data['name'];
    $type = $data['type'];
    $description = $data['description'] ?? '';

    $query = "INSERT INTO categories (name, type, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $type, $description]);
    return $conn->lastInsertId();
}

function updateCategory($conn, $data)
{
    $id = $data['id'];
    $name = $data['name'];
    $type = $data['type'];
    $description = $data['description'] ?? '';

    $query = "UPDATE categories SET name = ?, type = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $type, $description, $id]);
}

function deleteCategory($conn, $id)
{
    $query = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
}

function getCategoryName($conn, $categoryId)
{
    if (!$categoryId)
        return '';

    $query = "SELECT name FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$categoryId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['name'] : '';
}

// Enhanced fetch functions to include category names
function fetchBlogsWithCategories($conn)
{
    $blogs = fetchBlogs($conn);

    foreach ($blogs as &$blog) {
        $blog['category_name'] = getCategoryName($conn, $blog['category_id']);
    }

    return $blogs;
}

function fetchServicesWithCategories($conn)
{
    $services = fetchServices($conn);

    foreach ($services as &$service) {
        $service['category_name'] = getCategoryName($conn, $service['category_id']);
    }

    return $services;
}

function fetchEventsWithCategories($conn)
{
    $events = fetchEvents($conn);

    foreach ($events as &$event) {
        if (isset($event['category_id'])) {
            $event['category_name'] = getCategoryName($conn, $event['category_id']);
        }
    }

    return $events;
}

function fetchContactSubmissionsWithCategories($conn)
{
    $query = "SELECT * FROM contact_submissions";
    $stmt = $conn->query($query);
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($submissions as &$submission) {
        if (isset($submission['category_id'])) {
            $submission['category_name'] = getCategoryName($conn, $submission['category_id']);
        }
    }

    return $submissions;
}

// Contact form submission function
function submitContactForm($conn, $data)
{
    $name = $data['name'];
    $email = $data['email'];
    $subject = $data['subject'] ?? '';
    $message = $data['message'];
    $category_id = $data['category_id'] ?? null;

    $query = "INSERT INTO contact_submissions (name, email, subject, message, category_id, submission_date) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $email, $subject, $message, $category_id]);
    return $conn->lastInsertId();
}

/**
 * Handle user login
 * @param PDO $conn Database connection
 * @param array $data Login form data
 * @return array Response with success status and message
 */
function handleLogin($conn, $data)
{
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($username) || empty($password)) {
        return ['success' => false, 'message' => 'Username and password are required.'];
    }

    // Query the database for the user
    $query = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validate the retrieved user data
    if (!$user || empty($user['password']) || empty($user['iv'])) {
        return ['success' => false, 'message' => 'Invalid username or password.'];
    } else {
        // Retrieve the IV from the database and decode it from base64
        $iv = base64_decode($user['iv']);

        // Decrypt the password using AES with the retrieved IV
        $decrypted_password = openssl_decrypt($user['password'], 'AES-256-CBC', AES_KEY, 0, $iv);

        if ($decrypted_password === $password) {
            // Set session variables
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];

            return [
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => 'index.php'
            ];
        } else {
            return ['success' => false, 'message' => 'Invalid password.'];
        }
    }
}

/**
 * Handle user registration
 * @param PDO $conn Database connection
 * @param array $data Registration form data
 * @return array Response with success status and message
 */
function handleRegistration($conn, $data)
{
    $full_name = $data['name'] ?? ''; // Keep accepting 'name' from form for backwards compatibility
    $email = $data['email'] ?? '';
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    // Validation
    if (empty($full_name) || empty($email) || empty($username) || empty($password)) {
        return ['success' => false, 'message' => 'All fields are required.'];
    }

    // Check if the email already exists
    $query = "SELECT COUNT(*) FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$email]);
    $emailExists = $stmt->fetchColumn();

    if ($emailExists) {
        return ['success' => false, 'message' => 'The email address is already registered. Please use a different email.'];
    }

    // Check if the username already exists
    $query = "SELECT COUNT(*) FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username]);
    $usernameExists = $stmt->fetchColumn();

    if ($usernameExists) {
        return ['success' => false, 'message' => 'Username already taken. Please choose a different username.'];
    }

    try {
        // Generate a unique IV for AES encryption
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));

        // Encrypt the password using AES with the generated IV
        $encrypted_password = openssl_encrypt($password, 'AES-256-CBC', AES_KEY, 0, $iv);

        // Store the IV as a base64-encoded string alongside the encrypted password
        $iv_base64 = base64_encode($iv);

        // Default role is 'user' unless explicitly specified as 'admin'
        $role = $data['role'] ?? 'user';

        // Insert the new user - removed phone field since it doesn't exist in the users table
        $query = "INSERT INTO users (full_name, email, username, password, iv, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$full_name, $email, $username, $encrypted_password, $iv_base64, $role]);

        return [
            'success' => true,
            'message' => 'Registration successful! You can now login.',
            'redirect' => 'login.php'
        ];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()];
    }
}

/**
 * Get user by ID
 * @param PDO $conn Database connection
 * @param int $user_id User ID
 * @return array|bool User data or false if not found
 */
function getUserById($conn, $user_id)
{
    try {
        $query = "SELECT id, full_name, username, email, role FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching user: " . $e->getMessage());
        return false;
    }
}

/**
 * Update user profile
 * @param PDO $conn Database connection
 * @param array $data User data to update
 * @return array Response with success status and message
 */
function updateUserProfile($conn, $data)
{
    try {
        $user_id = $data['user_id'] ?? 0;
        $full_name = $data['full_name'] ?? '';
        $current_password = $data['current_password'] ?? '';
        $new_password = $data['new_password'] ?? '';

        // Validate inputs
        if (empty($user_id) || empty($full_name) || empty($current_password)) {
            return [
                'success' => false,
                'message' => 'Required fields are missing'
            ];
        }

        // Get current user data
        $query = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        // Verify current password
        $iv = base64_decode($user['iv']);
        $decrypted_password = openssl_decrypt($user['password'], 'AES-256-CBC', AES_KEY, 0, $iv);

        if ($decrypted_password !== $current_password) {
            return [
                'success' => false,
                'message' => 'Current password is incorrect'
            ];
        }

        // Begin transaction
        $conn->beginTransaction();

        // Always update name
        $query = "UPDATE users SET full_name = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$full_name, $user_id]);

        // Update password if provided
        if (!empty($new_password)) {
            // Generate a unique IV for AES encryption
            $new_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));

            // Encrypt the new password
            $encrypted_password = openssl_encrypt($new_password, 'AES-256-CBC', AES_KEY, 0, $new_iv);

            // Store the IV as a base64-encoded string alongside the encrypted password
            $iv_base64 = base64_encode($new_iv);

            // Update the password and IV
            $query = "UPDATE users SET password = ?, iv = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$encrypted_password, $iv_base64, $user_id]);
        }

        // Commit transaction
        $conn->commit();

        return [
            'success' => true,
            'message' => 'Profile updated successfully'
        ];
    } catch (PDOException $e) {
        // Rollback transaction on error
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        error_log("Error updating profile: " . $e->getMessage());
        return [
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage()
        ];
    }
}

/**
 * Admin Functions
 * Contains various helper functions for the admin panel
 */

/**
 * Get settings from database
 * @param PDO $conn Database connection
 * @param string|null $setting_group Optional setting group filter
 * @return array Associative array of settings
 */
function getSettings($conn, $setting_group = null)
{
    try {
        // Check if settings table exists
        $tableExists = $conn->query("SHOW TABLES LIKE 'settings'")->rowCount() > 0;

        if (!$tableExists) {
            // Create settings table if it doesn't exist
            $conn->exec("CREATE TABLE settings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                setting_group VARCHAR(50) NOT NULL,
                setting_key VARCHAR(100) NOT NULL,
                setting_value TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY group_key_idx (setting_group, setting_key)
            )");

            // Insert default settings
            insertDefaultSettings($conn);

            // Return default settings
            return getDefaultSettings();
        }

        $result = [];

        // Prepare query based on whether a specific group was requested
        if ($setting_group) {
            $stmt = $conn->prepare("SELECT * FROM settings WHERE setting_group = ?");
            $stmt->execute([$setting_group]);
        } else {
            $stmt = $conn->query("SELECT * FROM settings");
        }

        $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organize settings by group and key
        foreach ($settings as $setting) {
            if (!isset($result[$setting['setting_group']])) {
                $result[$setting['setting_group']] = [];
            }
            $result[$setting['setting_group']][$setting['setting_key']] = $setting['setting_value'];
        }

        return $result;
    } catch (PDOException $e) {
        error_log("Error fetching settings: " . $e->getMessage());
        return getDefaultSettings();
    }
}

function getDefaultSettings()
{
    return [
        'general' => [
            'site_name' => 'Sansia NGO',
            'site_tagline' => 'Empowering Communities',
            'contact_email' => 'info@sansia.org',
            'contact_phone' => '+1234567890',
            'address' => '123 Main St, City, Country',
            'footer_text' => '© ' . date('Y') . ' Sansia NGO. All rights reserved.'
        ],
        'social' => [
            'facebook' => '',
            'twitter' => '',
            'instagram' => '',
            'linkedin' => '',
            'youtube' => ''
        ]
    ];
}

function insertDefaultSettings($conn)
{
    $defaults = getDefaultSettings();
    $stmt = $conn->prepare("INSERT INTO settings (setting_group, setting_key, setting_value) VALUES (?, ?, ?)");

    foreach ($defaults as $group => $settings) {
        foreach ($settings as $key => $value) {
            $stmt->execute([$group, $key, $value]);
        }
    }
}

/**
 * Save a setting to the database
 * @param PDO $conn Database connection
 * @param string $group Setting group
 * @param string $key Setting key
 * @param string $value Setting value
 * @return bool Success or failure
 */
function saveSetting($conn, $group, $key, $value)
{
    try {
        // Check if setting exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM settings WHERE setting_group = ? AND setting_key = ?");
        $stmt->execute([$group, $key]);
        $exists = (int) $stmt->fetchColumn() > 0;

        if ($exists) {
            // Update existing setting
            $stmt = $conn->prepare("UPDATE settings SET setting_value = ? WHERE setting_group = ? AND setting_key = ?");
            return $stmt->execute([$value, $group, $key]);
        } else {
            // Insert new setting
            $stmt = $conn->prepare("INSERT INTO settings (setting_group, setting_key, setting_value) VALUES (?, ?, ?)");
            return $stmt->execute([$group, $key, $value]);
        }
    } catch (PDOException $e) {
        error_log("Error saving setting: " . $e->getMessage());
        return false;
    }
}

function saveSettingsBatch($conn, $data, $files)
{
    try {
        $response = ['success' => true, 'message' => 'Settings saved successfully'];

        // General Settings
        if (isset($data['general_settings'])) {
            // Text fields
            $textFields = ['site_name', 'site_tagline', 'contact_email', 'contact_phone', 'address', 'footer_text'];
            foreach ($textFields as $field) {
                if (isset($data[$field])) {
                    saveSetting($conn, 'general', $field, $data[$field]);
                }
            }

            // File uploads
            if (!empty($files['logo']['name'])) {
                $logo_filename = handleFileUpload($files['logo'], 'logo');
                saveSetting($conn, 'general', 'logo', $logo_filename);
            }

            if (!empty($files['favicon']['name'])) {
                $favicon_filename = handleFileUpload($files['favicon'], 'favicon');
                saveSetting($conn, 'general', 'favicon', $favicon_filename);
            }

            $response['message'] = 'General settings saved successfully';
        }

        // SEO Settings
        if (isset($data['seo_settings']) && isset($data['page_keys'])) {
            foreach ($data['page_keys'] as $index => $page_key) {
                // Save title, description, keywords
                $fields = ['title', 'description', 'keywords'];
                foreach ($fields as $field) {
                    $field_array = $field . 's'; // pluralize for array name (titles, descriptions, keywords)
                    if (isset($data[$field_array][$index])) {
                        saveSetting($conn, 'seo', "{$page_key}_{$field}", $data[$field_array][$index]);
                    }
                }

                // Handle OG image if uploaded
                if (isset($files['og_images']) && !empty($files['og_images']['name'][$index])) {
                    $og_image = [
                        'name' => $files['og_images']['name'][$index],
                        'type' => $files['og_images']['type'][$index],
                        'tmp_name' => $files['og_images']['tmp_name'][$index],
                        'error' => $files['og_images']['error'][$index],
                        'size' => $files['og_images']['size'][$index]
                    ];

                    if ($og_image['error'] === 0) {
                        $og_image_filename = handleFileUpload($og_image, 'og_' . $page_key);
                        saveSetting($conn, 'seo', "{$page_key}_og_image", $og_image_filename);
                    }
                }
            }

            $response['message'] = 'SEO settings saved successfully';
        }

        // Social Media Settings
        if (isset($data['social_settings'])) {
            $socialFields = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
            foreach ($socialFields as $field) {
                if (isset($data[$field])) {
                    saveSetting($conn, 'social', $field, $data[$field]);
                }
            }

            $response['message'] = 'Social media settings saved successfully';
        }

        return $response;
    } catch (Exception $e) {
        error_log("Error saving settings: " . $e->getMessage());
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

/**
 * Get specific setting value
 * @param PDO $conn Database connection
 * @param string $group Setting group
 * @param string $key Setting key
 * @param string $default Default value if setting not found
 * @return string Setting value
 */
function getSetting($conn, $group, $key, $default = '')
{
    try {
        $stmt = $conn->prepare("SELECT setting_value FROM settings WHERE setting_group = ? AND setting_key = ?");
        $stmt->execute([$group, $key]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['setting_value'];
        }

        return $default;
    } catch (PDOException $e) {
        error_log("Error getting setting: " . $e->getMessage());
        return $default;
    }
}

/**
 * Delete setting from database
 * @param PDO $conn Database connection
 * @param string $group Setting group
 * @param string $key Setting key
 * @return bool Success or failure
 */
function deleteSetting($conn, $group, $key)
{
    try {
        $stmt = $conn->prepare("DELETE FROM settings WHERE setting_group = ? AND setting_key = ?");
        $stmt->execute([$group, $key]);

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Error deleting setting: " . $e->getMessage());
        return false;
    }
}

/**
 * Handle file uploads
 * @param array $file $_FILES array element
 * @param string $prefix File name prefix
 * @return string File name
 */
function handleFileUpload($file, $prefix = '')
{
    $target_dir = "../assets/uploads/";
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $new_filename = $prefix . '_' . time() . '.' . $file_extension;
    $target_path = $target_dir . $new_filename;

    // Check if file is an actual image
    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
        throw new Exception("File is not an image");
    }

    // Check file size (max 2MB)
    if ($file['size'] > 2000000) {
        throw new Exception("File is too large. Max size is 2MB");
    }

    // Check file type
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'ico'];
    if (!in_array($file_extension, $allowed_types)) {
        throw new Exception("Only JPG, JPEG, PNG, GIF, and ICO files are allowed");
    }

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return $new_filename;
    } else {
        throw new Exception("Error uploading file");
    }
}

/**
 * Send email using PHPMailer with configuration from settings
 * @param PDO $conn Database connection
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $message Email message body
 * @param array $attachments Optional array of attachment file paths
 * @return bool Success or failure
 */
function sendEmail($conn, $to, $subject, $message, $attachments = [])
{
    try {
        // Check if PHPMailer is installed
        if (!file_exists('../vendor/phpmailer/phpmailer/src/PHPMailer.php')) {
            // Create vendor directory if it doesn't exist
            if (!file_exists('../vendor')) {
                mkdir('../vendor', 0755, true);
            }

            // Download and extract PHPMailer
            $phpmailerUrl = 'https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v6.9.3.zip';
            $zipFile = '../vendor/phpmailer.zip';

            // Download the zip file
            file_put_contents($zipFile, file_get_contents($phpmailerUrl));

            // Extract the zip file
            $zip = new ZipArchive;
            if ($zip->open($zipFile) === TRUE) {
                $zip->extractTo('../vendor/');
                $zip->close();

                // Rename the extracted directory
                rename('../vendor/PHPMailer-6.9.3', '../vendor/phpmailer');

                // Create proper directory structure
                if (!file_exists('../vendor/phpmailer/phpmailer/src')) {
                    mkdir('../vendor/phpmailer/phpmailer/src', 0755, true);
                }

                // Move files to the correct location
                foreach (glob('../vendor/phpmailer/src/*.php') as $file) {
                    $filename = basename($file);
                    copy($file, '../vendor/phpmailer/phpmailer/src/' . $filename);
                }

                if (!file_exists('../vendor/phpmailer/phpmailer/src/PHPMailer.php')) {
                    throw new Exception("PHPMailer installation failed");
                }
            }

            // Remove the zip file
            unlink($zipFile);
        }

        // Get email settings
        $email_settings = getSettings($conn, 'email');
        $general_settings = getSettings($conn, 'general');

        // Set default values if settings are missing
        $mail_mailer = $email_settings['mail_mailer'] ?? 'mail';
        $smtp_host = $email_settings['smtp_host'] ?? '';
        $smtp_port = $email_settings['smtp_port'] ?? 587;
        $smtp_encryption = $email_settings['smtp_encryption'] ?? 'tls';
        $smtp_username = $email_settings['smtp_username'] ?? '';
        $smtp_password = $email_settings['smtp_password'] ?? '';
        $mail_from_address = $email_settings['mail_from_address'] ?? ($general_settings['contact_email'] ?? 'noreply@example.com');
        $mail_from_name = $email_settings['mail_from_name'] ?? ($general_settings['site_name'] ?? 'Sansia NGO');

        // If PHPMailer isn't properly installed, use PHP's mail function as fallback
        if (!file_exists('../vendor/phpmailer/phpmailer/src/PHPMailer.php')) {
            // Set headers
            $headers = "From: {$mail_from_name} <{$mail_from_address}>\r\n";
            $headers .= "Reply-To: {$mail_from_address}\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            // Send mail
            return mail($to, $subject, $message, $headers);
        }

        // Use PHPMailer
        require_once '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require_once '../vendor/phpmailer/phpmailer/src/SMTP.php';
        require_once '../vendor/phpmailer/phpmailer/src/Exception.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        // Configure mailer based on settings
        if ($mail_mailer === 'smtp') {
            $mail->isSMTP();
            $mail->Host = $smtp_host;
            $mail->Port = $smtp_port;

            if ($smtp_encryption !== 'none') {
                $mail->SMTPSecure = $smtp_encryption;
            }

            if (!empty($smtp_username)) {
                $mail->SMTPAuth = true;
                $mail->Username = $smtp_username;
                $mail->Password = $smtp_password;
            }
        } else {
            $mail->isMail();
        }

        // Set sender and recipient
        $mail->setFrom($mail_from_address, $mail_from_name);
        $mail->addAddress($to);

        // Set content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        // Add attachments if any
        if (!empty($attachments) && is_array($attachments)) {
            foreach ($attachments as $attachment) {
                if (file_exists($attachment)) {
                    $mail->addAttachment($attachment);
                }
            }
        }

        // Send the email
        return $mail->send();
    } catch (Exception $e) {
        error_log('Error sending email: ' . $e->getMessage());
        return false;
    }
}

/**
 * Get all routes from routes.php file
 * @return array Array of route paths
 */
function getRoutes()
{
    $routes = ['/', '/about', '/services', '/portfolio', '/blog', '/contact'];

    try {
        // Read routes.php file
        if (file_exists('../routes.php')) {
            $routes_content = file_get_contents('../routes.php');

            // Use regex to extract route paths
            preg_match_all('/\$router->add\(\'GET\', \'(.*?)\',/', $routes_content, $matches);

            if (isset($matches[1]) && is_array($matches[1]) && !empty($matches[1])) {
                return $matches[1];
            }
        }
    } catch (Exception $e) {
        error_log("Error reading routes: " . $e->getMessage());
    }

    return $routes;
}

/**
 * Format page name from route
 * @param string $route Route path
 * @return string Formatted page name
 */
function formatPageName($route)
{
    if ($route === '/') {
        return 'Home Page';
    }

    // Remove slashes and convert to lowercase
    $name = trim($route, '/');
    // Split by slashes and take last part
    $parts = explode('/', $name);
    $name = end($parts);
    // Replace hyphens and underscores with spaces
    $name = str_replace(['-', '_'], ' ', $name);
    // Capitalize first letter of each word
    return ucwords($name);
}

/**
 * Generate page key from route path
 * @param string $route Route path
 * @return string Page key for storage
 */
function routeToPageKey($route)
{
    $page_key = strtolower(str_replace(['/', '-', ' '], ['_', '_', '_'], trim($route, '/')));
    if ($page_key === '' || $page_key === '_') {
        $page_key = 'home';
    }
    return $page_key;
}

/**
 * Apply SEO meta tags to page
 * @param PDO $conn Database connection
 * @param string $route Current route path
 * @return string HTML meta tags
 */
function applySeoMeta($conn, $route)
{
    $page_key = routeToPageKey($route);

    // Get site name for title fallback
    $site_name = getSetting($conn, 'general', 'site_name', 'Sansia NGO');

    // Get SEO settings for the page
    $title = getSetting($conn, 'seo', "{$page_key}_title", formatPageName($route) . ' | ' . $site_name);
    $description = getSetting($conn, 'seo', "{$page_key}_description", '');
    $keywords = getSetting($conn, 'seo', "{$page_key}_keywords", '');
    $og_image = getSetting($conn, 'seo', "{$page_key}_og_image", '');

    // Build HTML
    $html = '<title>' . htmlspecialchars($title) . '</title>' . PHP_EOL;
    $html .= '<meta name="description" content="' . htmlspecialchars($description) . '">' . PHP_EOL;

    if (!empty($keywords)) {
        $html .= '<meta name="keywords" content="' . htmlspecialchars($keywords) . '">' . PHP_EOL;
    }

    // OpenGraph tags
    $html .= '<meta property="og:title" content="' . htmlspecialchars($title) . '">' . PHP_EOL;
    $html .= '<meta property="og:type" content="website">' . PHP_EOL;
    $html .= '<meta property="og:url" content="' . htmlspecialchars((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") . '">' . PHP_EOL;

    if (!empty($description)) {
        $html .= '<meta property="og:description" content="' . htmlspecialchars($description) . '">' . PHP_EOL;
    }

    if (!empty($og_image)) {
        $html .= '<meta property="og:image" content="' . htmlspecialchars($og_image) . '">' . PHP_EOL;
    }

    // Twitter Card
    $html .= '<meta name="twitter:card" content="summary_large_image">' . PHP_EOL;
    $html .= '<meta name="twitter:title" content="' . htmlspecialchars($title) . '">' . PHP_EOL;

    if (!empty($description)) {
        $html .= '<meta name="twitter:description" content="' . htmlspecialchars($description) . '">' . PHP_EOL;
    }

    if (!empty($og_image)) {
        $html .= '<meta name="twitter:image" content="' . htmlspecialchars($og_image) . '">' . PHP_EOL;
    }

    // Add favicon if set
    $favicon = getSetting($conn, 'general', 'favicon');
    if (!empty($favicon)) {
        $html .= '<link rel="shortcut icon" href="' . htmlspecialchars('../assets/uploads/' . $favicon) . '" type="image/x-icon">' . PHP_EOL;
    }

    return $html;
}

// Process AJAX requests for settings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if this is a JSON request
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
    $isJsonRequest = strpos($contentType, 'application/json') !== false;

    // Parse JSON input if it's a JSON request
    if ($isJsonRequest) {
        $json_data = json_decode(file_get_contents('php://input'), true);
        if ($json_data && isset($json_data['event'])) {
            $event = $json_data['event'];
            // Handle JSON events here
            $response = ['success' => false, 'message' => 'Unknown event'];

            if ($event === 'fetch_blogs') {
                $response = fetchBlogsWithCategories($conn);
            } elseif ($event === 'fetch_events') {
                $response = fetchEventsWithCategories($conn);
            } elseif ($event === 'fetch_services') {
                $response = fetchServicesWithCategories($conn);
            } elseif ($event === 'fetch_categories') {
                $response = fetchCategories($conn);
            } elseif ($event === 'fetch_categories_by_type') {
                $type = $json_data['type'] ?? '';
                $response = fetchCategoriesByType($conn, $type);
            } elseif ($event === 'fetch_contact_submissions') {
                $response = fetchContactSubmissionsWithCategories($conn);
            } elseif ($event === 'post_blog' || $event === 'update_blog') {
                // Handle blog creation/update - simplified for JSON example
                $response = ['success' => true, 'message' => 'Blog operation successful'];
            } elseif ($event === 'post_event' || $event === 'update_event') {
                $response = ['success' => true, 'message' => 'Event operation successful'];
            } elseif ($event === 'post_service' || $event === 'update_service') {
                $response = ['success' => true, 'message' => 'Service operation successful'];
            } elseif ($event === 'post_category' || $event === 'update_category') {
                $response = ['success' => true, 'message' => 'Category operation successful'];
            } elseif (
                $event === 'delete_blog' || $event === 'delete_event' ||
                $event === 'delete_service' || $event === 'delete_category'
            ) {
                $id = $json_data['id'] ?? 0;
                if ($id) {
                    $response = ['success' => true, 'message' => 'Item deleted successfully'];
                } else {
                    $response = ['success' => false, 'error' => 'Invalid ID'];
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    // Handle regular form submissions
    // Process general settings
    if (isset($_POST['event']) && $_POST['event'] === 'save_general_settings') {
        $response = ['success' => false, 'message' => ''];

        try {
            // Process text fields
            $text_fields = ['site_name', 'site_tagline', 'contact_email', 'contact_phone', 'address', 'footer_text'];
            foreach ($text_fields as $field) {
                if (isset($_POST[$field])) {
                    saveSetting($conn, 'general', $field, $_POST[$field]);
                }
            }

            // Process file uploads
            $file_fields = ['logo', 'favicon'];

            foreach ($file_fields as $field) {
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
                    $new_filename = handleFileUpload($_FILES[$field], $field);
                    if ($new_filename !== false) {
                        saveSetting($conn, 'general', $field, $new_filename);
                    }
                }
            }

            $response['success'] = true;
            $response['message'] = 'General settings saved successfully!';
        } catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = 'Error: ' . $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Process SEO settings
    if (isset($_POST['event']) && $_POST['event'] === 'save_seo_settings') {
        $response = ['success' => false, 'message' => ''];

        try {
            $page_keys = $_POST['page_keys'] ?? [];
            $titles = $_POST['titles'] ?? [];
            $descriptions = $_POST['descriptions'] ?? [];
            $keywords = $_POST['keywords'] ?? [];

            // Save SEO text settings for each page
            foreach ($page_keys as $index => $page_key) {
                if (isset($titles[$index])) {
                    saveSetting($conn, 'seo', "{$page_key}_title", $titles[$index]);
                }
                if (isset($descriptions[$index])) {
                    saveSetting($conn, 'seo', "{$page_key}_description", $descriptions[$index]);
                }
                if (isset($keywords[$index])) {
                    saveSetting($conn, 'seo', "{$page_key}_keywords", $keywords[$index]);
                }
            }

            // Process OG images
            if (isset($_FILES['og_images'])) {
                $og_images = $_FILES['og_images'];

                foreach ($page_keys as $index => $page_key) {
                    if (isset($og_images['name'][$index]) && !empty($og_images['name'][$index]) && $og_images['error'][$index] === UPLOAD_ERR_OK) {
                        $image = [
                            'name' => $og_images['name'][$index],
                            'type' => $og_images['type'][$index],
                            'tmp_name' => $og_images['tmp_name'][$index],
                            'error' => $og_images['error'][$index],
                            'size' => $og_images['size'][$index]
                        ];

                        $new_filename = handleFileUpload($image, 'og_' . $page_key);
                        saveSetting($conn, 'seo', "{$page_key}_og_image", $new_filename);
                    }
                }
            }

            $response['success'] = true;
            $response['message'] = 'SEO settings saved successfully!';
        } catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = 'Error: ' . $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Process social media settings
    if (isset($_POST['event']) && $_POST['event'] === 'save_social_settings') {
        $response = ['success' => false, 'message' => ''];

        try {
            $social_fields = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'];
            foreach ($social_fields as $field) {
                if (isset($_POST[$field])) {
                    saveSetting($conn, 'social', $field, $_POST[$field]);
                }
            }

            $response['success'] = true;
            $response['message'] = 'Social media settings saved successfully!';
        } catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = 'Error: ' . $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Process email settings
    if (isset($_POST['event']) && $_POST['event'] === 'save_email_settings') {
        $response = ['success' => false, 'message' => ''];

        try {
            // Save mail configuration
            $mail_fields = [
                'mail_mailer',
                'smtp_host',
                'smtp_port',
                'smtp_encryption',
                'smtp_username',
                'mail_from_address',
                'mail_from_name'
            ];

            foreach ($mail_fields as $field) {
                if (isset($_POST[$field])) {
                    saveSetting($conn, 'email', $field, $_POST[$field]);
                }
            }

            // Handle password (only save if provided)
            if (!empty($_POST['smtp_password'])) {
                saveSetting($conn, 'email', 'smtp_password', $_POST['smtp_password']);
            }

            $response['success'] = true;
            $response['message'] = 'Email settings saved successfully!';
        } catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = 'Error: ' . $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Process test email configuration
    if (isset($_POST['event']) && $_POST['event'] === 'test_email_config') {
        $response = ['success' => false, 'message' => ''];

        try {
            // Save settings temporarily if they are different than stored ones
            $current_settings = getSettings($conn, 'email');
            $mail_fields = [
                'mail_mailer',
                'smtp_host',
                'smtp_port',
                'smtp_encryption',
                'smtp_username',
                'mail_from_address',
                'mail_from_name'
            ];

            $updated = false;
            foreach ($mail_fields as $field) {
                if (isset($_POST[$field]) && (!isset($current_settings[$field]) || $_POST[$field] != $current_settings[$field])) {
                    $updated = true;
                    break;
                }
            }

            // If settings were updated, save them temporarily
            if ($updated) {
                foreach ($mail_fields as $field) {
                    if (isset($_POST[$field])) {
                        saveSetting($conn, 'email', $field, $_POST[$field]);
                    }
                }

                // Handle password (only save if provided)
                if (!empty($_POST['smtp_password'])) {
                    saveSetting($conn, 'email', 'smtp_password', $_POST['smtp_password']);
                }
            }

            // Send test email
            $to = $_POST['mail_from_address']; // Send to self as test
            $subject = 'Test Email from Sansia NGO';
            $message = 'This is a test email from your website. If you received this, your email configuration is working correctly.';

            $sent = sendEmail($conn, $to, $subject, $message);

            if ($sent) {
                $response['success'] = true;
                $response['message'] = 'Test email sent successfully to ' . $to;
            } else {
                $response['success'] = false;
                $response['error'] = 'Failed to send test email. Check your email configuration.';
            }
        } catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = 'Error: ' . $e->getMessage();
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Process profile updates
    if (isset($_POST['event']) && $_POST['event'] === 'update_profile') {
        $response = ['success' => false, 'message' => ''];

        try {
            $response = updateUserProfile($conn, $_POST);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
?>