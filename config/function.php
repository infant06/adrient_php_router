<?php
// Common functions and utilities for the website

class Utility
{
    // Example public function
    public static function formatDate($date)
    {
        return date('F j, Y', strtotime($date));
    }

    // Example private function
    private static function logError($message)
    {
        error_log($message);
    }

    // Example public function to call private function
    public static function handleError($message)
    {
        self::logError($message);
    }

    /**
     * Securely upload a file with validation
     * 
     * @param array $file $_FILES array element
     * @param string $prefix Optional filename prefix
     * @param string $targetDir Target directory (default: "../assets/uploads/")
     * @param array $allowedTypes Optional array of allowed file extensions (default: images and PDFs)
     * @param int $maxSize Maximum file size in bytes (default: 5MB)
     * @return array Result with status, message, and filename if successful
     */
    public static function uploadFile($file, $prefix = '', $targetDir = "../assets/uploads/", $allowedTypes = [], $maxSize = 5242880)
    {
        // Initialize result array
        $result = [
            'success' => false,
            'message' => '',
            'filename' => ''
        ];

        try {
            // Check if file was uploaded properly
            if (!isset($file) || $file['error'] != UPLOAD_ERR_OK) {
                $error = self::getFileUploadErrorMessage($file['error'] ?? UPLOAD_ERR_NO_FILE);
                throw new Exception("Upload failed: {$error}");
            }

            // Get file information
            $originalName = basename($file['name']);
            $fileSize = $file['size'];
            $tmpName = $file['tmp_name'];
            $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            // Define blocked file extensions (security risk)
            $blockedTypes = [
                'php',
                'php3',
                'php4',
                'php5',
                'php7',
                'phtml',
                'phar',
                'js',
                'jsx',
                'html',
                'htm',
                'xhtml',
                'shtml',
                'asp',
                'aspx',
                'exe',
                'sh',
                'bat',
                'cmd',
                'cgi',
                'pl',
                'dll',
                'msi',
                'vb',
                'vbs',
                'wsf',
                'py',
                'jar',
                'zip',
                'rar',
                'tar',
                'gz',
                '7z'
            ];

            // If no allowed types specified, use default safe types
            if (empty($allowedTypes)) {
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'pdf'];
            }

            // Check if file extension is blocked
            if (in_array($fileExtension, $blockedTypes)) {
                throw new Exception("Security Error: File type '{$fileExtension}' is not allowed");
            }

            // Check if file extension is allowed
            if (!in_array($fileExtension, $allowedTypes)) {
                throw new Exception("Invalid file type. Allowed types: " . implode(', ', $allowedTypes));
            }

            // Check file size
            if ($fileSize > $maxSize) {
                $maxSizeMB = $maxSize / (1024 * 1024);
                throw new Exception("File is too large. Maximum size is {$maxSizeMB}MB");
            }

            // Get MIME type using finfo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            // Validate MIME type matches expected type for extension
            $validMimeTypes = [
                // Images
                'jpg' => ['image/jpeg'],
                'jpeg' => ['image/jpeg'],
                'png' => ['image/png'],
                'gif' => ['image/gif'],
                'bmp' => ['image/bmp'],
                'webp' => ['image/webp'],
                // PDF
                'pdf' => ['application/pdf']
            ];

            // Only validate if the extension is in our known list
            if (isset($validMimeTypes[$fileExtension])) {
                if (!in_array($mimeType, $validMimeTypes[$fileExtension])) {
                    throw new Exception("File content doesn't match its extension (detected: {$mimeType})");
                }
            }

            // For images, verify the file is actually an image
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                $imgInfo = @getimagesize($tmpName);
                if ($imgInfo === false) {
                    throw new Exception("File is not a valid image");
                }

                // Additional image validation - check file signatures (magic bytes)
                $fp = fopen($tmpName, 'rb');
                if ($fp === false) {
                    throw new Exception("Cannot open uploaded file for signature verification");
                }

                $bytes = fread($fp, 8);
                fclose($fp);

                if ($fileExtension === 'jpg' || $fileExtension === 'jpeg') {
                    // JPEG signature: FF D8 FF
                    if (bin2hex(substr($bytes, 0, 3)) !== 'ffd8ff') {
                        throw new Exception("Invalid JPEG file signature");
                    }
                } elseif ($fileExtension === 'png') {
                    // PNG signature: 89 50 4E 47 0D 0A 1A 0A
                    if (bin2hex(substr($bytes, 0, 8)) !== '89504e470d0a1a0a') {
                        throw new Exception("Invalid PNG file signature");
                    }
                } elseif ($fileExtension === 'gif') {
                    // GIF signature: 47 49 46 38
                    if (substr($bytes, 0, 4) !== 'GIF8') {
                        throw new Exception("Invalid GIF file signature");
                    }
                }
            }

            // For PDFs, validate signature (magic bytes)
            if ($fileExtension === 'pdf') {
                $fp = fopen($tmpName, 'rb');
                if ($fp === false) {
                    throw new Exception("Cannot open uploaded file for PDF signature verification");
                }

                $bytes = fread($fp, 4);
                fclose($fp);

                // PDF signature: 25 50 44 46 (%PDF)
                if ($bytes !== '%PDF') {
                    throw new Exception("Invalid PDF file signature");
                }
            }

            // Create target directory if it doesn't exist
            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0755, true)) {
                    throw new Exception("Failed to create upload directory");
                }
            }

            // Ensure target directory is writable
            if (!is_writable($targetDir)) {
                throw new Exception("Upload directory is not writable");
            }

            // Sanitize filename: remove spaces, special chars, etc.
            // Generate unique filename to prevent overwriting
            $sanitizedPrefix = preg_replace('/[^a-zA-Z0-9_-]/', '', $prefix);
            $uniqueId = uniqid(rand(), true);
            $timestamp = time();
            $newFilename = $sanitizedPrefix . '_' . $uniqueId . '_' . $timestamp . '.' . $fileExtension;
            $targetPath = $targetDir . $newFilename;

            // Check if target path already exists (extremely unlikely but still)
            if (file_exists($targetPath)) {
                throw new Exception("A file with the same name already exists");
            }

            // Attempt to move the uploaded file
            if (!move_uploaded_file($tmpName, $targetPath)) {
                throw new Exception("Failed to move uploaded file");
            }

            // Set appropriate permissions for the uploaded file
            chmod($targetPath, 0644);

            $result['success'] = true;
            $result['message'] = "File uploaded successfully";
            $result['filename'] = $newFilename;

        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            self::logError("File upload error: " . $e->getMessage());
        }

        return $result;
    }

    /**
     * Get descriptive error message for file upload errors
     *
     * @param int $errorCode PHP file upload error code
     * @return string Human-readable error message
     */
    private static function getFileUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "The uploaded file exceeds the upload_max_filesize directive in php.ini";
            case UPLOAD_ERR_FORM_SIZE:
                return "The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form";
            case UPLOAD_ERR_PARTIAL:
                return "The uploaded file was only partially uploaded";
            case UPLOAD_ERR_NO_FILE:
                return "No file was uploaded";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Missing a temporary folder";
            case UPLOAD_ERR_CANT_WRITE:
                return "Failed to write file to disk";
            case UPLOAD_ERR_EXTENSION:
                return "A PHP extension stopped the file upload";
            default:
                return "Unknown upload error";
        }
    }
}
?>
