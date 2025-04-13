<?php
// Common configurations and functions
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();
// Define server root and asset paths
define('SERVER_ROOT', __DIR__);
define('ASSET_FOLDER', SERVER_ROOT . '/assets');
define('UPLOAD_FOLDER', SERVER_ROOT . '/uploads');
define('THEME_FOLDER', SERVER_ROOT . '/theme');

// Include database configuration
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/function.php';

// Common functions
function getAssetPath($path)
{
    return ASSET_FOLDER . '/' . $path;
}

function getUploadPath($path)
{
    return UPLOAD_FOLDER . '/' . $path;
}
$theme_path = THEME_FOLDER . '/adrient/';


?>