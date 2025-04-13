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
}
?>