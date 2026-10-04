<?php
/**
 * ملف إدخال البيانات الأولية في قاعدة البيانات
 * قم بتشغيل هذا الملف مرة واحدة فقط بعد إنشاء قاعدة البيانات
 */

require_once 'config.php';

$conn = getDBConnection();

// بيانات السيناريوهات (20 سيناريو)
$scenarios_data = [
    [
        'number' => 1,
        'title' => 'What is your decision?',
        'description' => '1. Using AI to summarize instead of reading the entire original text
A student uses an automated summarization tool to condense research papers instead of reading the entire text. They are then asked to discuss and understand the content. What is the correct ethical behavior?',
        'image' => 'images/p1.jpg',
        'options' => [
            [
                'text' => 'Summarization is only permissible if the student indicates in the bibliography that the summary is automated.',
                'feedback' => '❗️This is a logical and ethical choice because it achieves transparency. The student can use the summarization tool, but they must clarify that it is automated to avoid misleading information. ✅'
            ],
            [
                'text' => 'Automated summarization is never permissible because it reduces comprehension.',
                'feedback' => '❗️While relying solely on summarization may impair deep understanding, a complete ban reduces the potential for using AI tools as an aid. ❌'
            ],
            [
                'text' => 'Automated summarization is permissible if the student subsequently rewrites the entire content themselves from memory.',
                'feedback' => '❗️This is a middle ground, with the positive side of motivating the student to reformulate and reflect on the information. But there is still a risk in relying on the summary as a primary reference and ignoring the original text, and this may cause the loss of important details.⚠️'
            ]
        ]
    ],
    [
        'number' => 2,
        'title' => 'What is your decision?',
        'description' => 'Transparency in AI Tools Used by Faculty
A professor uses an AI tool to generate test or assessment questions without informing students or explaining the tool used. What should they do?',
        'image' => 'images/p2.jpg',
        'options' => [
            [
                'text' => 'There is no need to disclose the information as long as the questions are consistent with the curriculum.',
                'feedback' => '❗️ This option is ethically inappropriate, as omitting to mention the use of AI may undermine transparency between professor and students. ⚠️'
            ],
            [
                'text' => 'Students should be informed that part of the question generation was done using AI to ensure transparency.',
                'feedback' => '❗️ Disclosure builds trust between student and professor and gives students a broader understanding of the nature of the educational process. ✅'
            ],
            [
                'text' => 'It can be concealed if the tool makes the questions better or requires less effort on the part of the professor',
                'feedback' => '❗️ This option is problematic, as it justifies the concealment under the pretext of improving quality or reducing effort. Although the goal may seem practical, the lack of transparency may lead to a loss of trust among students'
            ]
        ]
    ],
    [
        'number' => 3,
        'title' => 'What is your decision?',
        'description' => 'Choosing Roles in a Group Project Using AI Assistance: In a group project, one member uses AI to help generate an idea and design the presentation, while the other members do not use it. How should contributions be fairly divided?',
        'image' => 'images/p3.jpg',
        'options' => [
            [
                'text' => 'Acknowledge that the student who used AI did additional work, and it is fair to consider that in the evaluation.',
                'feedback' => '❗️ This option is the fairest, as it recognizes effort whether through traditional or modern tools. ✅'
            ],
            [
                'text' => 'Prohibit any use of AI in the group project to ensure equality.',
                'feedback' => ' ❗️ A total ban may deprive students of learning how to responsibly integrate AI into teamwork. ⚠️'
            ],
            [
                'text' => 'Using AI is automatically considered an advantage and reduces the work of other members.',
                'feedback' => '❗️ This option is unfair because it diminishes the value of the contribution of the student who used AI. ❌'
            ]
        ]
    ],
    [
        'number' => 4,
        'title' => 'What is your decision?',
        'description' => 'Privacy Concerns When Using Learning Analytics:A university intends to use data from students\' interactions with a digital platform to analyze who is "at risk" of failing or dropping out, without students\' clear consent. What is the ethical action?',
        'image' => 'images/p4.jpg',
        'options' => [
            [
                'text' => 'Continue using the data because the goal is educationally beneficial.',
                'feedback' => '❗️ This option is unethical because it ignores students\' rights to privacy and informed consent ❌.'
            ],
            [
                'text' => 'Hide data collection because students might object and it could disrupt the project.',
                'feedback' => ' ❗️ This option is unacceptable as it is based on deception and lack of transparency. Hiding information under the pretext of "project benefit" undermines trust and may have serious legal and ethical consequences. ⚠️'
            ],
            [
                'text' => 'Obtain students\' consent, ensure data protection, and make the data visible to them if possible.',
                'feedback' => ' ❗️ This is the correct ethical behavior, balancing educational analytics benefits with respect for students\' privacy. ✅'
            ]
        ]
    ],
    [
        'number' => 5,
        'title' => 'What is your decision?',
        'description' => 'Training on Academic Integrity and Students\' Knowledge of AI:
A study found that students with better awareness of academic integrity rules use AI less for cheating or plagiarism. What is the best action for the university?',
        'image' => 'images/p5.jpg',
        'options' => [
            [
                'text' => 'Focus only on penalties for those caught cheating using AI.',
                'feedback' => '❗️ This option is insufficient because it relies on punishment after the fact rather than prevention. Penalties alone do not build a culture of integrity and may push students to cheat more covertly. ⚠️'
            ],
            [
                'text' => 'Provide awareness courses and training on academic integrity and the responsible use of AI.',
                'feedback' => ' ❗️ This is the optimal and ethical choice because it focuses on education and empowerment rather than prohibition. Training students on responsible AI use fosters academic integrity and reduces misuse. ✅'
            ],
            [
                'text' => 'Allow AI use without training as long as it is not directly used for cheating.',
                'feedback' => ' ❗️ This option is risky as it opens the door to misunderstanding and misuse, harming the credibility of the educational process. ❌'
            ]
        ]
    ],
    // سنضيف باقي السيناريوهات (6-20) - يمكنك إضافتها بنفس الطريقة
    // أو قراءتها من ملفات HTML تلقائياً
];

// دالة لإدخال سيناريو
function insertScenario($conn, $scenario_data) {
    // تنظيف البيانات من SQL Injection
    $number = intval($scenario_data['number']);
    $title = $conn->real_escape_string($scenario_data['title']);
    $description = $conn->real_escape_string($scenario_data['description']);
    $image = $conn->real_escape_string($scenario_data['image']);
    
    // التحقق من وجود السيناريو
    $checkQuery = "SELECT id FROM scenarios WHERE scenario_number = $number";
    $checkResult = $conn->query($checkQuery);
    
    if ($checkResult && $checkResult->num_rows > 0) {
        $row = $checkResult->fetch_assoc();
        $scenario_id = $row['id'];
        echo "السيناريو رقم $number موجود بالفعل (ID: $scenario_id). يتم تحديثه...\n";
        
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
            echo "تم إدخال السيناريو رقم $number بنجاح (ID: $scenario_id)\n";
        } else {
            echo "خطأ في إدخال السيناريو رقم $number: " . $conn->error . "\n";
            return false;
        }
    }
    
    // إدخال الخيارات
    $order = 1;
    foreach ($scenario_data['options'] as $option_data) {
        $option_text = $conn->real_escape_string($option_data['text']);
        $feedback_text = $conn->real_escape_string($option_data['feedback']);
        
        $optionQuery = "INSERT INTO options (scenario_id, option_text, feedback_text, option_order) 
                       VALUES ($scenario_id, '$option_text', '$feedback_text', $order)";
        
        if ($conn->query($optionQuery)) {
            echo "  ✓ تم إدخال الخيار $order\n";
        } else {
            echo "  ✗ خطأ في إدخال الخيار $order: " . $conn->error . "\n";
        }
        
        $order++;
    }
    
    return true;
}

// إدخال جميع السيناريوهات
echo "بدء إدخال البيانات...\n\n";

foreach ($scenarios_data as $scenario) {
    insertScenario($conn, $scenario);
    echo "\n";
}

echo "\nتم إدخال جميع البيانات بنجاح!\n";
echo "ملاحظة: إذا كنت تريد إضافة باقي السيناريوهات (6-20)، يمكنك إضافتها بنفس الطريقة أو استخدام ملف extract_data.php لاستخراجها تلقائياً.\n";

closeDBConnection($conn);
?>

