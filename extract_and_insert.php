<?php
/**
 * ملف لاستخراج البيانات من ملفات HTML وإدخالها في قاعدة البيانات
 * هذا الملف يقرأ جميع ملفات index*.html ويستخرج السيناريوهات والخيارات والردود
 */

require_once 'config.php';

function extractScenarioNumber($filename) {
    // استخراج رقم السيناريو من اسم الملف
    if (basename($filename) === 'index.html') {
        return 1;
    }
    
    $match = preg_match('/index(\d+)\.html/', basename($filename), $matches);
    if ($match && isset($matches[1])) {
        return intval($matches[1]);
    }
    
    return 0;
}

function extractScenarioFromHTML($htmlContent, $filePath) {
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));
    
    $xpath = new DOMXPath($dom);
    
    $scenario = [
        'number' => extractScenarioNumber($filePath),
        'title' => 'What is your decision?',
        'description' => '',
        'image' => '',
        'options' => []
    ];
    
    // استخراج العنوان
    $titleNodes = $xpath->query("//div[@class='scenario-box']//h2");
    if ($titleNodes->length > 0) {
        $scenario['title'] = trim($titleNodes->item(0)->textContent);
    }
    
    // استخراج الوصف (السيناريو)
    $descNodes = $xpath->query("//div[@class='scenario-box']//p");
    if ($descNodes->length > 0) {
        // نأخذ أول <p> بعد h2 (الذي يحتوي على السيناريو)
        $scenario['description'] = trim($descNodes->item(0)->textContent);
    }
    
    // استخراج مسار الصورة
    $imgNodes = $xpath->query("//div[@class='image-side']//img");
    if ($imgNodes->length > 0) {
        $imgSrc = $imgNodes->item(0)->getAttribute('src');
        // تحويل backslash إلى forward slash
        $scenario['image'] = str_replace('\\', '/', $imgSrc);
    }
    
    // استخراج الخيارات
    $optionNodes = $xpath->query("//div[@class='option']");
    $order = 1;
    
    foreach ($optionNodes as $optionNode) {
        $optionText = '';
        $feedbackText = '';
        
        // استخراج نص الخيار (كل النص ما عدا feedback)
        $optInput = $xpath->query(".//input[@type='radio']", $optionNode);
        if ($optInput->length > 0) {
            // النص بعد input هو نص الخيار
            $optionNode->removeChild($optInput->item(0));
        }
        
        // استخراج feedback
        $feedbackDiv = $xpath->query(".//div[@class='feedback']", $optionNode);
        if ($feedbackDiv->length > 0) {
            $feedbackText = trim($feedbackDiv->item(0)->textContent);
            $optionNode->removeChild($feedbackDiv->item(0));
        }
        
        // النص المتبقي هو نص الخيار
        $optionText = trim($optionNode->textContent);
        $optionText = preg_replace('/\s+/', ' ', $optionText); // إزالة المسافات الزائدة
        
        if (!empty($optionText)) {
            $scenario['options'][] = [
                'text' => $optionText,
                'feedback' => $feedbackText,
                'order' => $order
            ];
            $order++;
        }
    }
    
    return $scenario;
}

function insertScenario($conn, $scenario_data) {
    $number = intval($scenario_data['number']);
    $title = $conn->real_escape_string($scenario_data['title']);
    $description = $conn->real_escape_string($scenario_data['description']);
    $image = $conn->real_escape_string($scenario_data['image']);
    
    if ($number == 0) {
        return false;
    }
    
    // التحقق من وجود السيناريو
    $checkQuery = "SELECT id FROM scenarios WHERE scenario_number = $number";
    $checkResult = $conn->query($checkQuery);
    
    if ($checkResult && $checkResult->num_rows > 0) {
        $row = $checkResult->fetch_assoc();
        $scenario_id = $row['id'];
        echo "السيناريو رقم $number موجود (ID: $scenario_id). يتم تحديثه...\n";
        
        // تحديث السيناريو
        $updateQuery = "UPDATE scenarios SET 
                       title = '$title',
                       description = '$description',
                       image_path = '$image'
                       WHERE id = $scenario_id";
        $conn->query($updateQuery);
        
        // حذف الخيارات القديمة
        $deleteOptions = "DELETE FROM options WHERE scenario_id = $scenario_id";
        $conn->query($deleteOptions);
    } else {
        // إدخال السيناريو الجديد
        $insertQuery = "INSERT INTO scenarios (scenario_number, title, description, image_path) 
                       VALUES ($number, '$title', '$description', '$image')";
        
        if ($conn->query($insertQuery)) {
            $scenario_id = $conn->insert_id;
            echo "✓ تم إدخال السيناريو رقم $number (ID: $scenario_id)\n";
        } else {
            echo "✗ خطأ في إدخال السيناريو رقم $number: " . $conn->error . "\n";
            return false;
        }
    }
    
    // إدخال الخيارات
    foreach ($scenario_data['options'] as $option_data) {
        $option_text = $conn->real_escape_string($option_data['text']);
        $feedback_text = $conn->real_escape_string($option_data['feedback']);
        $order = intval($option_data['order']);
        
        $optionQuery = "INSERT INTO options (scenario_id, option_text, feedback_text, option_order) 
                       VALUES ($scenario_id, '$option_text', '$feedback_text', $order)";
        
        if ($conn->query($optionQuery)) {
            echo "  ✓ الخيار $order\n";
        } else {
            echo "  ✗ خطأ في الخيار $order: " . $conn->error . "\n";
        }
    }
    
    return true;
}

// بدء الاستخراج والإدخال
$conn = getDBConnection();

echo "====================================\n";
echo "استخراج وإدخال البيانات من ملفات HTML\n";
echo "====================================\n\n";

// قراءة جميع ملفات index*.html
$htmlFiles = glob(__DIR__ . '/index*.html');

// ترتيب الملفات حسب رقم السيناريو
usort($htmlFiles, function($a, $b) {
    $numA = extractScenarioNumber($a);
    $numB = extractScenarioNumber($b);
    return $numA - $numB;
});

foreach ($htmlFiles as $filePath) {
    echo "\n--- معالجة: " . basename($filePath) . " ---\n";
    
    $htmlContent = file_get_contents($filePath);
    
    if ($htmlContent === false) {
        echo "✗ خطأ في قراءة الملف\n";
        continue;
    }
    
    $scenario = extractScenarioFromHTML($htmlContent, $filePath);
    
    if ($scenario['number'] > 0) {
        echo "السيناريو رقم: {$scenario['number']}\n";
        echo "العنوان: {$scenario['title']}\n";
        echo "عدد الخيارات: " . count($scenario['options']) . "\n";
        
        insertScenario($conn, $scenario);
    } else {
        echo "✗ لم يتم تحديد رقم السيناريو\n";
    }
}

echo "\n\n====================================\n";
echo "اكتمل الاستخراج والإدخال!\n";
echo "====================================\n";

closeDBConnection($conn);
?>

