<?php
/**
 * ملف لتحديث البيانات في قاعدة البيانات
 * يستخدم البيانات الصحيحة من insert_data.php ويحدّث السيناريوهات الموجودة
 */

require_once 'config.php';

// بيانات السيناريوهات (من insert_data.php)
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
    [
        'number' => 6,
        'title' => 'What is your decision?',
        'description' => 'Reliability and Quality of AI-Generated Content in Lectures
A professor uses AI-generated texts in lectures, but some facts are incorrect or mixed. What is the duty?',
        'image' => 'images/p6.jpg',
        'options' => [
            [
                'text' => 'Continue using the texts as they are because students can expect updates later.',
                'feedback' => '❗️ Unacceptable, as presenting false or inaccurate information undermines trust and negatively affects learning. ❌'
            ],
            [
                'text' => 'Carefully review content, correct errors, and indicate that it was human-checked before use.',
                'feedback' => '❗️ This is the ethical and correct choice, combining AI benefits with academic responsibility. Human review and transparency enhance lecture quality. ✅'
            ],
            [
                'text' => 'Stop using AI in educational content because errors are inevitable.',
                'feedback' => ' ❗️ Overly strict, as it eliminates AI\'s significant educational benefits. The better approach is controlled use with human review. ⚠️'
            ]
        ]
    ],
    [
        'number' => 7,
        'title' => 'What is your decision?',
        'description' => 'Unequal Access to AI Tools:Some students lack good devices or internet, but all are required to use online AI tools.What should the university do?',
        'image' => 'images/p7.jpg',
        'options' => [
            [
                'text' => 'Force everyone to meet the requirement, as it is part of the challenge.',
                'feedback' => ' ❗️This option is unfair because it ignores differences in students\' technical resources. The goal of education is to ensure equal opportunities, not to test individual access to technology.❌'
            ],
            [
                'text' => 'Provide alternatives or technical support for those in need, ensuring equal opportunities.',
                'feedback' => '❗️ This is the best option because it promotes fairness and ensures that all students can use AI tools equally — whether through providing devices, internet support, or alternative tools.✅'
            ],
            [
                'text' => 'Consider it a personal issue; students must find their own solutions.',
                'feedback' => ' ❗️This option reflects a lack of institutional responsibility, as it places the entire burden on students and could disadvantage those with limited resources.⚠️'
            ]
        ]
    ],
    [
        'number' => 8,
        'title' => 'What is your decision?',
        'description' => 'Using AI to Generate Creative Content (Art, Music, Literature)
A student uses AI to generate parts of a creative work (story or song) and then submits the whole work as their own. What should be done?',
        'image' => 'images/p8.jpg',
        'options' => [
            [
                'text' => 'Consider the work entirely authored by the student if they only selected the outputs.',
                'feedback' => '❗️ Ethically incorrect, as attributing all creativity to the student without disclosure is misleading. ❌'
            ],
            [
                'text' => 'The student should indicate that parts were generated by AI and that they edited or modified them.',
                'feedback' => '❗️ Disclosure reflects academic integrity and balances AI use with creative rights. ✅'
            ],
            [
                'text' => 'Prohibit AI use in artistic academic work entirely.',
                'feedback' => '❗️ May limit learning and creative experimentation; better to allow it with clear guidelines. ⚠️'
            ]
        ]
    ],
    [
        'number' => 9,
        'title' => 'What is your decision?',
        'description' => 'Ethical Responsibility When Relying on AI in Research Evaluation
An academic journal accepts a paper where AI was used for writing and analysis, but the authors did not disclose it. What should reviewers do?',
        'image' => 'images/p9.jpg',
        'options' => [
            [
                'text' => 'Accept the paper as long as it presents a new contribution.',
                'feedback' => '❗️ Insufficient; lack of disclosure harms transparency and research credibility. ❌'
            ],
            [
                'text' => 'Reject the paper outright due to AI use without permission.',
                'feedback' => '❗️ May deprive new contributions; better to request disclosure and corrections. ⚠️'
            ],
            [
                'text' => 'Require authors to fully disclose AI use in research methodology and writing.',
                'feedback' => '❗️ Ensures academic integrity and allows reviewers to properly assess the researchers\' contribution. ✅'
            ]
        ]
    ],
    [
        'number' => 10,
        'title' => 'What is your decision?',
        'description' => 'Balancing Teacher Job Security and Task Automation via AI
A faculty member feels that automating tasks (assignments, student evaluation) with AI may reduce their teaching role. What is the ethical behavior for the institution?',
        'image' => 'images/p10.jpg',
        'options' => [
            [
                'text' => 'Involve faculty in designing tools and deciding when/how they are used to ensure understanding and professional support.',
                'feedback' => '❗️ Balances AI benefits with protecting teachers\' roles and professional support. ✅'
            ],
            [
                'text' => 'Encourage full automation to reduce costs.',
                'feedback' => '❗️ Unbalanced; marginalizes teachers\' roles and reduces professional support. ⚠️'
            ],
            [
                'text' => 'Impose tools on everyone without consultation because change is necessary.',
                'feedback' => '❗️ Unfair; may create resistance and weaken education quality due to lack of involvement. ❌'
            ]
        ]
    ],
    [
        'number' => 11,
        'title' => 'What is your decision?',
        'description' => 'Enabling Performance Innovation via AI vs. Maintaining Academic Challenge
A student uses AI to create ready-made solution models for practice questions without learning the method. What should be done?',
        'image' => 'images/p11.jpg',
        'options' => [
            [
                'text' => 'Encourage the student because it saves time.',
                'feedback' => '❗️ Incorrect; may lead to full reliance on AI without understanding the content. ❌'
            ],
            [
                'text' => 'Guide the student to use AI as a helper to clarify ideas, then attempt solutions themselves first.',
                'feedback' => '❗️ Encourages effective learning and responsible tool use. ✅'
            ],
            [
                'text' => 'Prevent the student from viewing AI-generated solutions entirely.',
                'feedback' => '❗️ Overly strict; deprives students of additional learning opportunities. ⚠️'
            ]
        ]
    ],
    [
        'number' => 12,
        'title' => 'What is your decision?',
        'description' => 'Recognizing Errors in AI Assessment of Generated Texts
An AI detection tool indicates the text is fully AI-generated, but human inspection shows personal style and genuine content. How should this be handled?',
        'image' => 'images/p12.jpg',
        'options' => [
            [
                'text' => 'Accept the claim based solely on the tool and penalize the student.',
                'feedback' => '❗️ Unacceptable; full reliance on the tool may wrong the student. ❌'
            ],
            [
                'text' => 'Ignore the tool entirely because it is not accurate.',
                'feedback' => '❗️ Illogical; the tool may provide important indications if verified properly. ⚠️'
            ],
            [
                'text' => 'Use the tool as an indicator, then conduct a human review before any disciplinary action.',
                'feedback' => '❗️ Balances detection accuracy with protecting student rights. ✅'
            ]
        ]
    ],
    [
        'number' => 13,
        'title' => 'What is your decision?',
        'description' => 'Ensuring AI Tools Suit Academic Specialization
A professor in a specialized subject wants to use AI to generate advanced exercises, but the tool is not specialized in the field. What is best?',
        'image' => 'images/p13.jpg',
        'options' => [
            [
                'text' => 'Use it immediately as it saves time.',
                'feedback' => '❗️ Unsafe; may produce incorrect or unsuitable content. ❌'
            ],
            [
                'text' => 'Test the tool for specialization, review by experts, and ensure it produces accurate and suitable exercises.',
                'feedback' => '❗️ Optimal choice; maintains content quality and academic safety. ✅'
            ],
            [
                'text' => 'Prohibit AI use in advanced subjects as errors are unacceptable.',
                'feedback' => '❗️ Overly strict; may deprive students of intelligent automation benefits. ⚠️'
            ]
        ]
    ],
    [
        'number' => 14,
        'title' => 'What is your decision?',
        'description' => 'Intellectual Property Issues for AI-Generated Work
A student uses AI to generate images or visual content and includes it in research or a presentation without verifying commercial rights or licenses. What should be done?',
        'image' => 'images/p14.jpg',
        'options' => [
            [
                'text' => 'Ensure content is free of ownership restrictions, has proper licenses, or obtain permission.',
                'feedback' => '❗️ Ethical option; protects the student and institution from legal and ethical issues. ✅'
            ],
            [
                'text' => 'If it\'s for academic purposes, no need to check licenses.',
                'feedback' => '❗️ Incorrect; may lead to using protected materials without permission, even academically. ❌'
            ],
            [
                'text' => 'Use content without modification because the goal is educational.',
                'feedback' => '❗️ Unacceptable; educational purposes still require respecting rights. ⚠️'
            ]
        ]
    ],
    [
        'number' => 15,
        'title' => 'What is your decision?',
        'description' => 'Integrating AI in University Policies with a Clear Timeline
A university has no written AI policy. Some faculty use it, others do not, causing student confusion. What should be done?',
        'image' => 'images/p15.jpg',
        'options' => [
            [
                'text' => 'Wait until faculty agree spontaneously.',
                'feedback' => '❗️ Ineffective; leads to continued confusion. ❌'
            ],
            [
                'text' => 'Develop a clear written university policy, inform students and faculty, including disclosure requirements and potential penalties.',
                'feedback' => '❗️ Correct option; provides clarity and organization, reducing confusion. ✅'
            ],
            [
                'text' => 'Leave it open until more research emerges.',
                'feedback' => '❗️ Impractical; delay harms the educational process. ⚠️'
            ]
        ]
    ],
    [
        'number' => 16,
        'title' => 'What is your decision?',
        'description' => 'Ethical Challenges in Assessing Students from Different Language Backgrounds Using AI Tools
An AI detection or automated assessment tool treats all students the same, but non-native English speakers appear to use AI more due to different language patterns. How should the university address this?',
        'image' => 'images/p16.jpg',
        'options' => [
            [
                'text' => 'Review the tool for linguistic bias, introduce correction mechanisms, and provide support for non-native speakers.',
                'feedback' => '❗️ Ethical; ensures fairness and equality in assessment. ✅'
            ],
            [
                'text' => 'Make no changes — rules apply to everyone.',
                'feedback' => '❗️ Unfair; may penalize non-native English speakers due to tool bias. ❌'
            ],
            [
                'text' => 'Exclude international students from AI use entirely until the university completes assessment.',
                'feedback' => '❗️ Unacceptable; deprives students of resources and increases discrimination. ⚠️'
            ]
        ]
    ],
    [
        'number' => 17,
        'title' => 'What is your decision?',
        'description' => 'Ensuring Continuous Monitoring and Updates of AI Tools
A university adopts an AI tool for student assessment, but the tool\'s algorithm is not regularly updated, leading to outdated or biased results. What should be done?',
        'image' => 'images/p17.jpg',
        'options' => [
            [
                'text' => 'Continue using it without updates to maintain consistency.',
                'feedback' => '❗️ Risky; outdated tools may produce inaccurate or biased results. ❌'
            ],
            [
                'text' => 'Establish a regular review and update schedule, monitor performance, and ensure the tool remains accurate and fair.',
                'feedback' => '❗️ Ethical and practical; maintains tool reliability and fairness. ✅'
            ],
            [
                'text' => 'Stop using all AI tools until perfect solutions are found.',
                'feedback' => '❗️ Overly restrictive; prevents benefiting from AI advancements. ⚠️'
            ]
        ]
    ],
    [
        'number' => 18,
        'title' => 'What is your decision?',
        'description' => 'Addressing Student Concerns About AI Replacing Human Instruction
Students express fear that AI tools will replace professors and reduce personal interaction. How should the university respond?',
        'image' => 'images/p18.jpg',
        'options' => [
            [
                'text' => 'Ignore concerns and focus on AI implementation.',
                'feedback' => '❗️ Disrespectful; ignores student needs and reduces trust. ❌'
            ],
            [
                'text' => 'Communicate clearly that AI complements human instruction, maintain personal interaction, and involve students in decision-making.',
                'feedback' => '❗️ Ethical and effective; balances technology with human connection. ✅'
            ],
            [
                'text' => 'Replace most human interaction with AI to show efficiency.',
                'feedback' => '❗️ Counterproductive; may harm learning quality and student satisfaction. ⚠️'
            ]
        ]
    ],
    [
        'number' => 19,
        'title' => 'What is your decision?',
        'description' => 'Managing AI Tool Costs and Student Access
A university requires expensive AI tools that some students cannot afford. What is the ethical approach?',
        'image' => 'images/p19.jpg',
        'options' => [
            [
                'text' => 'Require all students to purchase the tools individually.',
                'feedback' => '❗️ Unfair; creates financial barriers and inequality. ❌'
            ],
            [
                'text' => 'Provide institutional licenses, offer alternatives, or financial assistance to ensure equal access.',
                'feedback' => '❗️ Ethical; promotes equity and ensures all students can benefit. ✅'
            ],
            [
                'text' => 'Allow only those who can afford it to use the tools.',
                'feedback' => '❗️ Discriminatory; violates principles of equal educational opportunity. ⚠️'
            ]
        ]
    ],
    [
        'number' => 20,
        'title' => 'What is your decision?',
        'description' => 'Involving Students in Policy Design for AI Use
A university issues AI use policy for purchases and teaching without consulting students or knowing their opinions. What is best?',
        'image' => 'images/p20.jpg',
        'options' => [
            [
                'text' => 'The university only needs faculty and tech expert opinions.',
                'feedback' => '❗️ Unbalanced; may neglect student needs and opinions. ❌'
            ],
            [
                'text' => 'Involve students as contributors in policy design to balance academic goals with student needs.',
                'feedback' => '❗️ Ethical; promotes participation, fairness, and transparency. ✅'
            ],
            [
                'text' => 'Leave policy to an administrative office only because they are best at legal writing.',
                'feedback' => '❗️ Insufficient; may lead to incomplete and non-inclusive policy. ⚠️'
            ]
        ]
    ]
];

$conn = getDBConnection();

echo "====================================\n";
echo "تحديث البيانات في قاعدة البيانات\n";
echo "====================================\n\n";

function updateScenario($conn, $scenario_data) {
    $number = intval($scenario_data['number']);
    $title = $conn->real_escape_string($scenario_data['title']);
    $description = $conn->real_escape_string($scenario_data['description']);
    $image = $conn->real_escape_string($scenario_data['image']);
    
    // البحث عن السيناريو
    $checkQuery = "SELECT id FROM scenarios WHERE scenario_number = $number";
    $checkResult = $conn->query($checkQuery);
    
    if ($checkResult && $checkResult->num_rows > 0) {
        $row = $checkResult->fetch_assoc();
        $scenario_id = $row['id'];
        
        // تحديث السيناريو
        $updateQuery = "UPDATE scenarios SET 
                       title = '$title',
                       description = '$description',
                       image_path = '$image'
                       WHERE id = $scenario_id";
        
        if ($conn->query($updateQuery)) {
            echo "✅ تم تحديث السيناريو رقم $number (ID: $scenario_id)\n";
        } else {
            echo "❌ خطأ في تحديث السيناريو رقم $number: " . $conn->error . "\n";
            return false;
        }
        
        // حذف الخيارات القديمة
        $deleteOptions = "DELETE FROM options WHERE scenario_id = $scenario_id";
        $conn->query($deleteOptions);
        
        // إدخال الخيارات الجديدة
        $order = 1;
        foreach ($scenario_data['options'] as $option_data) {
            $option_text = $conn->real_escape_string($option_data['text']);
            $feedback_text = $conn->real_escape_string($option_data['feedback']);
            
            $optionQuery = "INSERT INTO options (scenario_id, option_text, feedback_text, option_order) 
                           VALUES ($scenario_id, '$option_text', '$feedback_text', $order)";
            
            if ($conn->query($optionQuery)) {
                echo "  ✓ تم إضافة الخيار $order\n";
            } else {
                echo "  ✗ خطأ في الخيار $order: " . $conn->error . "\n";
            }
            $order++;
        }
        
        return true;
    } else {
        echo "⚠️ السيناريو رقم $number غير موجود، سيتم إنشاؤه...\n";
        
        // إنشاء السيناريو الجديد
        $insertQuery = "INSERT INTO scenarios (scenario_number, title, description, image_path) 
                       VALUES ($number, '$title', '$description', '$image')";
        
        if ($conn->query($insertQuery)) {
            $scenario_id = $conn->insert_id;
            echo "✅ تم إنشاء السيناريو رقم $number (ID: $scenario_id)\n";
            
            // إدخال الخيارات
            $order = 1;
            foreach ($scenario_data['options'] as $option_data) {
                $option_text = $conn->real_escape_string($option_data['text']);
                $feedback_text = $conn->real_escape_string($option_data['feedback']);
                
                $optionQuery = "INSERT INTO options (scenario_id, option_text, feedback_text, option_order) 
                               VALUES ($scenario_id, '$option_text', '$feedback_text', $order)";
                
                if ($conn->query($optionQuery)) {
                    echo "  ✓ تم إضافة الخيار $order\n";
                } else {
                    echo "  ✗ خطأ في الخيار $order: " . $conn->error . "\n";
                }
                $order++;
            }
            
            return true;
        } else {
            echo "❌ خطأ في إنشاء السيناريو رقم $number: " . $conn->error . "\n";
            return false;
        }
    }
}

// تحديث جميع السيناريوهات
foreach ($scenarios_data as $scenario) {
    updateScenario($conn, $scenario);
    echo "\n";
}

echo "\n====================================\n";
echo "✅ اكتمل التحديث!\n";
echo "====================================\n";
echo "\nملاحظة: تم تحديث أول 5 سيناريوهات.\n";
echo "لإضافة باقي السيناريوهات (6-20)، يمكنك:\n";
echo "1. إضافتها يدوياً في هذا الملف\n";
echo "2. أو استعادة ملفات HTML الأصلية واستخدام extract_and_insert.php\n\n";

closeDBConnection($conn);
?>

