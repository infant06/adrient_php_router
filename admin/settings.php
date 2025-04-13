<?php
require_once '../config/db.php';
require_once 'function.php';

// Check if user is logged in and has admin privileges
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Set page title
$page_title = 'Website Settings';

// Get all available routes for SEO settings
$routes = getRoutes();

// Get existing settings
$settings = getSettings($conn);
$general_settings = $settings['general'] ?? [];
$seo_settings = $settings['seo'] ?? [];
$social_settings = $settings['social'] ?? [];
$email_settings = $settings['email'] ?? [];

// Helper function to get setting value with default
function getValue($settings, $key, $default = '')
{
    return isset($settings[$key]) ? $settings[$key] : $default;
}

// Include header
include 'includes/header.php';
?>

<h1>Website Settings</h1>

<div id="alert-container"></div>

<!-- Settings Tabs -->
<ul class="nav nav-tabs" id="settingsTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab">General Settings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="seo-tab" data-bs-toggle="tab" href="#seo" role="tab">SEO Settings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="social-tab" data-bs-toggle="tab" href="#social" role="tab">Social Media</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="email-tab" data-bs-toggle="tab" href="#email" role="tab">Email Configuration</a>
    </li>
</ul>

<div class="tab-content">
    <!-- General Settings Tab -->
    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
        <form id="generalSettingsForm" method="POST" enctype="multipart/form-data" onsubmit="return false;">
            <input type="hidden" name="event" value="save_general_settings">
            <input type="hidden" name="general_settings" value="1">

            <div class="setting-group">
                <h3>Site Identity</h3>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" class="form-control" id="site_name" name="site_name"
                            value="<?php echo getValue($general_settings, 'site_name', 'Sansia NGO'); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="site_tagline" class="form-label">Tagline</label>
                        <input type="text" class="form-control" id="site_tagline" name="site_tagline"
                            value="<?php echo getValue($general_settings, 'site_tagline', 'Empowering Communities'); ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        <?php if (!empty($general_settings['logo'])): ?>
                            <div class="mt-2">
                                <img src="../assets/uploads/<?php echo $general_settings['logo']; ?>" alt="Logo"
                                    class="preview-image">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="favicon" class="form-label">Favicon</label>
                        <input type="file" class="form-control" id="favicon" name="favicon"
                            accept="image/x-icon,image/png,image/gif">
                        <?php if (!empty($general_settings['favicon'])): ?>
                            <div class="mt-2">
                                <img src="../assets/uploads/<?php echo $general_settings['favicon']; ?>" alt="Favicon"
                                    class="favicon-preview">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="setting-group">
                <h3>Contact Information</h3>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="contact_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email"
                            value="<?php echo getValue($general_settings, 'contact_email', 'info@sansia.org'); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="contact_phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                            value="<?php echo getValue($general_settings, 'contact_phone', '+1234567890'); ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address"
                        rows="3"><?php echo getValue($general_settings, 'address', '123 Main St, City, Country'); ?></textarea>
                </div>
            </div>

            <div class="setting-group">
                <h3>Footer Information</h3>
                <div class="mb-3">
                    <label for="footer_text" class="form-label">Footer Text</label>
                    <textarea class="form-control" id="footer_text" name="footer_text"
                        rows="3"><?php echo getValue($general_settings, 'footer_text', '© ' . date('Y') . ' Sansia NGO. All rights reserved.'); ?></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save General Settings</button>
        </form>
    </div>

    <!-- SEO Settings Tab -->
    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
        <form id="seoSettingsForm" method="POST" enctype="multipart/form-data" onsubmit="return false;">
            <input type="hidden" name="event" value="save_seo_settings">
            <input type="hidden" name="seo_settings" value="1">

            <div class="setting-group">
                <h3 class="mb-3">SEO Settings for Each Page</h3>
                <p class="text-muted mb-4">Customize SEO settings for each page on your website. These settings help
                    improve
                    your site's visibility on search engines.</p>

                <div class="row">
                    <?php foreach ($routes as $index => $route): ?>
                        <?php
                        $page_key = routeToPageKey($route);
                        $page_title = formatPageName($route);
                        // Generate a random pastel background color for each page
                        $hue = ($index * 55) % 360; // Different hue for each page
                        $bgColor = "hsl({$hue}, 70%, 93%)";
                        ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm"
                                style="border-left: 5px solid hsl(<?php echo $hue; ?>, 70%, 60%);">
                                <div class="card-header" style="background-color: <?php echo $bgColor; ?>;">
                                    <h4 class="mb-0"><?php echo $page_title; ?></h4>
                                    <small class="text-muted"><?php echo $route; ?></small>
                                    <input type="hidden" name="page_keys[]" value="<?php echo $page_key; ?>">
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-tag-fill me-1"></i> Title Tag
                                        </label>
                                        <input type="text" class="form-control" name="titles[]"
                                            value="<?php echo getValue($seo_settings, "{$page_key}_title", $page_title . ' | Sansia NGO'); ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-file-text-fill me-1"></i> Meta Description
                                        </label>
                                        <textarea class="form-control" name="descriptions[]"
                                            rows="3"><?php echo getValue($seo_settings, "{$page_key}_description", ''); ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-tags-fill me-1"></i> Meta Keywords
                                        </label>
                                        <input type="text" class="form-control" name="keywords[]"
                                            value="<?php echo getValue($seo_settings, "{$page_key}_keywords", ''); ?>">
                                        <small class="text-muted">Separate keywords with commas</small>
                                    </div>

                                    <div class="mb-1">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-image-fill me-1"></i> Open Graph Image
                                        </label>
                                        <input type="file" class="form-control" name="og_images[]" accept="image/*">
                                        <?php if (!empty($seo_settings["{$page_key}_og_image"])): ?>
                                            <div class="mt-2">
                                                <img src="../assets/uploads/<?php echo $seo_settings["{$page_key}_og_image"]; ?>"
                                                    alt="OG Image" class="preview-image img-thumbnail"
                                                    style="max-height: 100px;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (($index + 1) % 2 === 0): ?>
                        </div>
                        <div class="row">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save SEO Settings</button>
        </form>
    </div>

    <!-- Social Media Tab -->
    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
        <form id="socialSettingsForm" method="POST" onsubmit="return false;">
            <input type="hidden" name="event" value="save_social_settings">
            <input type="hidden" name="social_settings" value="1">

            <div class="setting-group">
                <h3>Social Media Links</h3>
                <div class="mb-3">
                    <label for="facebook" class="form-label">Facebook URL</label>
                    <input type="url" class="form-control" id="facebook" name="facebook"
                        value="<?php echo getValue($social_settings, 'facebook', ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="twitter" class="form-label">Twitter URL</label>
                    <input type="url" class="form-control" id="twitter" name="twitter"
                        value="<?php echo getValue($social_settings, 'twitter', ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram URL</label>
                    <input type="url" class="form-control" id="instagram" name="instagram"
                        value="<?php echo getValue($social_settings, 'instagram', ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="linkedin" class="form-label">LinkedIn URL</label>
                    <input type="url" class="form-control" id="linkedin" name="linkedin"
                        value="<?php echo getValue($social_settings, 'linkedin', ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="youtube" class="form-label">YouTube URL</label>
                    <input type="url" class="form-control" id="youtube" name="youtube"
                        value="<?php echo getValue($social_settings, 'youtube', ''); ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Social Media Settings</button>
        </form>
    </div>

    <!-- Email Configuration Tab -->
    <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
        <form id="emailSettingsForm" method="POST" onsubmit="return false;">
            <input type="hidden" name="event" value="save_email_settings">
            <input type="hidden" name="email_settings" value="1">

            <div class="mb-3">
                <label for="mail_mailer" class="form-label">Mail Driver</label>
                <select class="form-control" id="mail_mailer" name="mail_mailer">
                    <option value="smtp" <?php echo (getValue($email_settings, 'mail_mailer', '') == 'smtp') ? 'selected' : ''; ?>>SMTP</option>
                    <option value="mail" <?php echo (getValue($email_settings, 'mail_mailer', '') == 'mail') ? 'selected' : ''; ?>>PHP Mail</option>
                </select>
            </div>

            <div id="smtp-settings"
                class="<?php echo (getValue($email_settings, 'mail_mailer', '') != 'smtp') ? 'd-none' : ''; ?>">
                <div class="mb-3">
                    <label for="smtp_host" class="form-label">SMTP Host</label>
                    <input type="text" class="form-control" id="smtp_host" name="smtp_host"
                        value="<?php echo getValue($email_settings, 'smtp_host', ''); ?>">
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="smtp_port" class="form-label">SMTP Port</label>
                        <input type="text" class="form-control" id="smtp_port" name="smtp_port"
                            value="<?php echo getValue($email_settings, 'smtp_port', ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="smtp_encryption" class="form-label">Encryption</label>
                        <select class="form-control" id="smtp_encryption" name="smtp_encryption">
                            <option value="tls" <?php echo (getValue($email_settings, 'smtp_encryption', '') == 'tls') ? 'selected' : ''; ?>>TLS</option>
                            <option value="ssl" <?php echo (getValue($email_settings, 'smtp_encryption', '') == 'ssl') ? 'selected' : ''; ?>>SSL</option>
                            <option value="none" <?php echo (getValue($email_settings, 'smtp_encryption', '') == 'none') ? 'selected' : ''; ?>>None</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="smtp_username" class="form-label">SMTP Username</label>
                    <input type="text" class="form-control" id="smtp_username" name="smtp_username"
                        value="<?php echo getValue($email_settings, 'smtp_username', ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="smtp_password" class="form-label">SMTP Password</label>
                    <input type="password" class="form-control" id="smtp_password" name="smtp_password" value="">
                    <div class="form-text">Leave blank to keep the current password.</div>
                </div>
            </div>

            <div class="mb-3">
                <label for="mail_from_address" class="form-label">From Email Address</label>
                <input type="email" class="form-control" id="mail_from_address" name="mail_from_address"
                    value="<?php echo getValue($email_settings, 'mail_from_address', ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="mail_from_name" class="form-label">From Name</label>
                <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                    value="<?php echo getValue($email_settings, 'mail_from_name', ''); ?>" required>
            </div>

            <div class="mb-4">
                <button type="button" id="test-email-btn" class="btn btn-secondary me-2">Test Email
                    Configuration</button>
                <button type="submit" class="btn btn-primary">Save Email Settings</button>
            </div>
        </form>
    </div>
</div>

<!-- Initialize settings page functionality -->
<script id="init-admin-page" data-page="settings"></script>

<?php include 'includes/footer.php'; ?>