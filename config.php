<?php
/**
 * ملف الإعدادات للاتصال بقاعدة البيانات
 */

// إعدادات قاعدة البيانات
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'arshed_db');

// الاتصال بقاعدة البيانات
function getDBConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // التحقق من الاتصال
        if ($conn->connect_error) {
            die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
        }
        
        // تعيين الترميز للدعم العربي
        $conn->set_charset("utf8mb4");
        
        return $conn;
    } catch (Exception $e) {
        die("خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage());
    }
}

// إغلاق الاتصال
function closeDBConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>

