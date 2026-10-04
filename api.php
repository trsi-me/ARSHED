<?php
/**
 * API لجلب البيانات من قاعدة البيانات
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once 'config.php';

// جلب جميع السيناريوهات
if (isset($_GET['action']) && $_GET['action'] == 'get_all_scenarios') {
    $conn = getDBConnection();
    
    $query = "SELECT s.*, 
              (SELECT COUNT(*) FROM options WHERE scenario_id = s.id) as options_count
              FROM scenarios s 
              ORDER BY s.scenario_number ASC";
    
    $result = $conn->query($query);
    
    $scenarios = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $scenarios[] = $row;
        }
    }
    
    closeDBConnection($conn);
    echo json_encode($scenarios, JSON_UNESCAPED_UNICODE);
    exit;
}

// جلب سيناريو محدد مع خياراته
if (isset($_GET['action']) && $_GET['action'] == 'get_scenario') {
    $scenario_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $scenario_number = isset($_GET['number']) ? intval($_GET['number']) : 0;
    
    if ($scenario_id == 0 && $scenario_number == 0) {
        echo json_encode(['error' => 'يرجى تحديد معرف السيناريو أو رقمه'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $conn = getDBConnection();
    
    // التحقق من وجود اتصال
    if (!$conn) {
        echo json_encode(['error' => 'فشل الاتصال بقاعدة البيانات'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // بناء الاستعلام
    if ($scenario_id > 0) {
        $whereClause = "s.id = " . intval($scenario_id);
    } else {
        $whereClause = "s.scenario_number = " . intval($scenario_number);
    }
    
    // جلب السيناريو
    $query = "SELECT * FROM scenarios s WHERE $whereClause LIMIT 1";
    $result = $conn->query($query);
    
    // التحقق من وجود أخطاء في الاستعلام
    if (!$result) {
        closeDBConnection($conn);
        echo json_encode(['error' => 'خطأ في الاستعلام: ' . $conn->error], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    if ($result->num_rows == 0) {
        closeDBConnection($conn);
        echo json_encode(['error' => 'السيناريو غير موجود في قاعدة البيانات. تأكد من تشغيل extract_and_insert.php لإدخال البيانات'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $scenario = $result->fetch_assoc();
    
    // جلب الخيارات
    $optionsQuery = "SELECT * FROM options WHERE scenario_id = " . $scenario['id'] . " ORDER BY option_order ASC";
    $optionsResult = $conn->query($optionsQuery);
    
    $options = [];
    if ($optionsResult && $optionsResult->num_rows > 0) {
        while ($row = $optionsResult->fetch_assoc()) {
            $options[] = $row;
        }
    }
    
    $scenario['options'] = $options;
    
    closeDBConnection($conn);
    echo json_encode($scenario, JSON_UNESCAPED_UNICODE);
    exit;
}

// رسالة خطأ إذا لم يتم تحديد action
echo json_encode(['error' => 'يرجى تحديد الإجراء المطلوب'], JSON_UNESCAPED_UNICODE);
?>

