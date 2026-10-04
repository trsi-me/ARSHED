# ARSHED

اسم المجلد: `ARSHED`. عنوان الصفحة في `index.html`: `Arshad - Interactive Scenarios`. النص الظاهر في الشريط: `Arshad`.

## 1. ما هو المشروع

تطبيق ويب يعرض سيناريوهات أخلاقية عن استخدام الذكاء الاصطناعي في التعليم. كل سيناريو صفحة HTML (`index.html` ثم `index2.html` حتى `index20.html`). بعد التحميل يجلب `app.js` العنوان والوصف والصورة والخيارات من `api.php`، ويخزنها في MySQL عبر الجدولين `scenarios` و`options`.

واجهة الصفحات بالإنجليزية (`lang="en"`). تعليقات PHP ورسائل أخطاء `api.php` و`app.js` بالعربية.

## 2. لماذا يوجد هذا المشروع

`insert_data.php` يصف محتواه بأنه إدخال بيانات أولية، ويخزن 20 سيناريو عن سلوك الطالب أو الجامعة مع أدوات الذكاء الاصطناعي (تلخيص، نزاهة أكاديمية، تحليلات تعلم، انتحال، ومخاوف الخصوصية). `extract_and_insert.php` يقرأ ملفات `index*.html` ويملأ القاعدة منها.

هدف مكتوب خارج الكود (مقرر، جهة، تاريخ تسليم): غير موثق.

## 3. من يستخدمه

| الطرف | ما يظهر في الملفات |
| --- | --- |
| زائر الصفحة | يفتح صفحة سيناريو، يختار خياراً، يضغط `Submit Decision` |
| من يشغّل السكربتات | يشغّل `database.sql` ثم `extract_and_insert.php` أو `insert_data.php` أو `update_data.php` |
| حسابات مستخدمين | غير موجود في الملفات الحالية |

روابط `Sign up` و`Training Content` و`Challenges` و`AI vs. Traditional` و`Contact Us` في `index.html` تشير إلى `#`.

## 4. ماذا يستطيع النظام أن يفعل

- عرض سيناريو حسب رقم الملف عبر `getScenarioNumber()` في `app.js`.
- جلب سيناريو واحد: `api.php?action=get_scenario&number=` أو `&id=`.
- جلب كل السيناريوهات: `api.php?action=get_all_scenarios` (لا يستدعيه `app.js` في الكود الحالي).
- إظهار نص التغذية الراجعة للخيار المختار عبر `showFeedback()`.
- استخراج السيناريوهات من HTML وإدخالها: `extract_and_insert.php`.
- إدخال مجموعة ثابتة من 20 سيناريو: `insert_data.php`.
- تحديث سيناريوهات موجودة: `update_data.php` والدالة `updateScenario()`.

تسجيل، دفع، شهادات، لوحة إدارة: غير موجود في الملفات الحالية.

## 5. كيف يعمل النظام

1. المتصفح يفتح `index.html` أو `indexN.html`.
2. `DOMContentLoaded` يستدعي `getScenarioNumber()` ثم `loadScenario()`.
3. `fetch` يطلب `api.php?action=get_scenario&number=...`.
4. `api.php` يتصل عبر `getDBConnection()` في `config.php` ويقرأ `scenarios` ثم `options` مرتبة بـ `option_order`.
5. `app.js` يكتب `title` في `h2`، و`description` في أول `p`، و`image_path` في `.image-side img`، ويبني عناصر `.option`.
6. الضغط على `.submit-btn` ينفذ `showFeedback()` ويظهر `.feedback` للخيار المحدد إن كان `opt1` أو `opt2` أو `opt3`.

## 6. أمثلة واقعية

المثال مأخوذ من أول عنصر في `$scenarios_data` داخل `insert_data.php`:

- الرقم: 1
- العنوان: `What is your decision?`
- الموضوع: طالب يستخدم أداة تلخيص آلي بدل قراءة النص الأصلي
- الصورة المخزنة في المصفوفة: `images/p1.jpg`
- أحد الخيارات: توضيح أن الملخص آلي في قائمة المراجع
- التغذية الراجعة لهذا الخيار تصف الخيار بأنه شفاف

`index.html` يبدأ بنص ثابت `Loading scenario...` إلى أن يصل الرد من `api.php`.

## 7. رحلة المستخدم

1. فتح `index.html` (السيناريو 1) أو التنقل من `.pagination` إلى `index2.html` ... `index20.html`.
2. انتظار استبدال النص بعنوان ووصف وخيارات من القاعدة.
3. اختيار زر اختيار `radio` باسم `decision`.
4. الضغط على `Submit Decision`.
5. قراءة `.feedback` الظاهر.
6. الانتقال للصفحة التالية من الروابط أسفل الصندوق. رابط `Next>` في `index.html` يشير إلى `index2.html`.

لا توجد جلسة ولا حفظ لاختيار المستخدم في القاعدة.

## 8. الوحدات والأقسام

| الملف أو المجلد | الدور |
| --- | --- |
| `index.html`, `index2.html` ... `index20.html` | صفحات السيناريوهات |
| `styles.css` | تنسيق الصندوق والصورة |
| `app.js` | `loadScenario`, `showErrorMessage`, `showFeedback`, `getScenarioNumber` |
| `api.php` | قراءة فقط |
| `config.php` | `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`, `getDBConnection`, `closeDBConnection` |
| `database.sql` | إنشاء `arshed_db` والجدولين |
| `extract_and_insert.php` | `extractScenarioNumber`, `extractScenarioFromHTML`, `insertScenario` |
| `insert_data.php` | إدخال المصفوفة الثابتة |
| `update_data.php` | `updateScenario` |

شريط التنقل يذكر أقساماً (`Home`, `Training Content`, `Challenges`, `Scenarios`, `AI vs. Traditional`, `Contact Us`). الملف `Arshed-html.html` الذي تشير إليه روابط Home: غير موجود في الملفات الحالية.

## 9. الشركات والكيانات

اسم منتج أو جامعة أو شركة مالكة: غير موثق. السيناريوهات تتحدث عن جامعة وطالب كأمثلة نصية داخل الوصف، وليست جداول كيانات.

## 10. الصلاحيات

لا جداول مستخدمين ولا فحص جلسة. `api.php` يضبط `Access-Control-Allow-Origin: *` و`Access-Control-Allow-Methods: GET`. أي عميل يصل إلى العنوان يستطيع قراءة السيناريوهات.

سكربتات الإدخال (`insert_data.php`, `update_data.php`, `extract_and_insert.php`) بلا مصادقة في الكود المقروء.

## 11. الأتمتة وسير العمل

لا طوابير ولا مهام مجدولة. التشغيل اليدوي:

1. تنفيذ `database.sql`.
2. تشغيل أحد سكربتات التعبئة مرة حسب تعليق `insert_data.php`: «قم بتشغيل هذا الملف مرة واحدة فقط بعد إنشاء قاعدة البيانات».
3. تصفح الصفحات عبر خادم PHP.

`showFeedback()` تغطي ثلاثة معرفات فقط: `feedback1`, `feedback2`, `feedback3`.

## 12. التكامل بين الوحدات

```
indexN.html --> app.js --> api.php --> config.php --> MySQL (scenarios, options)
index*.html --> extract_and_insert.php --> نفس الجداول
insert_data.php / update_data.php --> نفس الجداول
```

صفحات HTML تحتوي أيضاً خيارات ثابتة في المصدر. بعد التحميل يستبدلها `loadScenario` إن نجح الطلب.

## 13. المصطلحات

| المصطلح | المعنى في هذا المشروع |
| --- | --- |
| scenario | صف في `scenarios` برقم `scenario_number` فريد |
| option | صف في `options` مرتبط بـ `scenario_id` |
| feedback_text | النص الذي يظهر بعد Submit |
| option_order | ترتيب الخيار |
| action | معامل GET في `api.php`: `get_all_scenarios` أو `get_scenario` |

## 14. الأسئلة الشائعة

**لماذا تبقى الصفحة على Loading scenario؟**  
`showErrorMessage` في `app.js` تذكر تشغيل خادم PHP وفتح `http://localhost/ARSHED/index.html` وتشغيل `extract_and_insert.php`.

**كم سيناريو؟**  
تعليق `insert_data.php`: 20 سيناريو. الصفحات الموجودة: `index.html` و`index2.html` حتى `index20.html`.

**هل يُحفظ القرار؟**  
لا. `showFeedback` يغيّر `display` في الصفحة فقط.

## 15. المعمارية (ASCII)

```
[المتصفح]
    |  index.html ... index20.html + styles.css
    |  app.js  fetch GET
    v
[api.php]
    |  getDBConnection()
    v
[MySQL arshed_db]
    scenarios 1--* options

[تشغيل يدوي]
extract_and_insert.php | insert_data.php | update_data.php
    --> نفس القاعدة
```

## 16. التقنيات المستخدمة

| التقنية | أين |
| --- | --- |
| HTML | صفحات `index*.html` |
| CSS | `styles.css` وأنماط داخل الصفحة |
| JavaScript | `app.js` |
| PHP مع `mysqli` | `config.php`, `api.php`, سكربتات الإدخال |
| MySQL `utf8mb4` / `utf8mb4_unicode_ci` | `database.sql` |
| Tailwind من CDN | `https://cdn.tailwindcss.com/3.4.16` في `index.html` |
| خط Inter وPacifico | روابط Google Fonts |
| Remix Icon | `cdnjs` إصدار `4.6.0` في وسم الصفحة |

إطار PHP، Composer، `.env`: غير موجود في الملفات الحالية.

## 17. هيكل المشروع

```
ARSHED/
├── index.html
├── index2.html ... index20.html
├── styles.css
├── app.js
├── api.php
├── config.php
├── database.sql
├── extract_and_insert.php
├── insert_data.php
├── update_data.php
└── README.md
```

مجلد `images` المشار إليه في `index.html` (`images\p1.jpg`) وفي بيانات `insert_data.php`: غير موجود في الملفات الحالية.

## 18. واجهة المستخدم

- شريط علوي أبيض، لون `primary` في إعداد Tailwind: `#8b5cf6`.
- صندوق `.scenario-box`: عنوان، وصف، خيارات، زر، ترقيم صفحات.
- جانب `.image-side` للصورة.
- الاتجاه في `index.html`: `ltr` واللغة `en`.
- وسم `<link rel="icon">`: غير موجود في `index.html`.

## 19. الخادم

PHP عبر `mysqli`. الإعدادات في `config.php`:

| الثابت | القيمة في الملف |
| --- | --- |
| `DB_HOST` | `localhost` |
| `DB_USER` | `root` |
| `DB_NAME` | `arshed_db` |
| `DB_PASS` | فارغة في الملف |

عند فشل الاتصال تستدعي `getDBConnection` الدالة `die` مع نص الخطأ. لا خادم تطبيق منفصل ولا منفذ موثق.

## 20. مسار الطلب (real example)

طلب: `GET api.php?action=get_scenario&number=1`

1. الترويسة `Content-Type: application/json; charset=utf-8`.
2. إن كان `id` و`number` كلاهما 0: JSON فيه `error` = `يرجى تحديد معرف السيناريو أو رقمه`.
3. الاستعلام: `SELECT * FROM scenarios s WHERE s.scenario_number = 1 LIMIT 1`.
4. إن لم يوجد صف: رسالة تطلب تشغيل `extract_and_insert.php`.
5. ثم `SELECT * FROM options WHERE scenario_id = ... ORDER BY option_order ASC`.
6. الرد يضم حقول السيناريو ومفتاح `options`.

إن غاب `action`: `يرجى تحديد الإجراء المطلوب`.

## 21. قاعدة البيانات (real tables)

القاعدة: `arshed_db`.

**scenarios**

| العمود | النوع |
| --- | --- |
| id | INT AUTO_INCREMENT PRIMARY KEY |
| scenario_number | INT NOT NULL UNIQUE |
| title | VARCHAR(255) NOT NULL |
| description | TEXT NOT NULL |
| image_path | VARCHAR(255) NOT NULL |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP ON UPDATE |

**options**

| العمود | النوع |
| --- | --- |
| id | INT AUTO_INCREMENT PRIMARY KEY |
| scenario_id | INT NOT NULL, مفتاح خارجي إلى `scenarios(id)` مع `ON DELETE CASCADE` |
| option_text | TEXT NOT NULL |
| feedback_text | TEXT NOT NULL |
| option_order | INT NOT NULL DEFAULT 1 |
| created_at, updated_at | TIMESTAMP |

فهرس: `idx_scenario_id`.

## 22. واجهات البرمجة

| الطريقة | المسار | الوظيفة |
| --- | --- | --- |
| GET | `api.php?action=get_all_scenarios` | كل الصفوف مع `options_count` مرتبة بـ `scenario_number` |
| GET | `api.php?action=get_scenario&id=` | سيناريو بالمعرف مع الخيارات |
| GET | `api.php?action=get_scenario&number=` | سيناريو بالرقم مع الخيارات |

لا POST ولا توثيق OpenAPI.

## 23. تسجيل الدخول والصلاحيات

غير موجود في الملفات الحالية. رابط `Sign up` لا يفتح صفحة.

## 24. الحماية

- `intval` على `id` و`number` قبل تركيبهما في SQL.
- الاستعلام يبنى كنص (`$whereClause`) وليس عبارة محضّرة (`prepare`).
- `Access-Control-Allow-Origin: *`.
- أخطاء SQL قد تُعاد في JSON (`خطأ في الاستعلام` مع `$conn->error`).
- سكربتات الكتابة على القاعدة بلا تحقق هوية.
- لا CSRF ولا تشفير كلمات مرور لأن لا حسابات.

## 25. الإعدادات

الملف الوحيد: `config.php`. لا `.env` ولا `.env.example`.

## 26. التكاملات الخارجية

- Tailwind CDN `3.4.16`
- Google Fonts: Pacifico وInter
- Remix Icon `4.6.0` من cdnjs

تحليلات، بريد، دفع: غير موجود في الملفات الحالية.

## 27. المهام المجدولة

غير موجود في الملفات الحالية.

## 28. تخزين الملفات

المسار النصي يُحفظ في `scenarios.image_path` (مثال من `insert_data.php`: `images/p1.jpg`). `extract_and_insert.php` يحوّل `\` إلى `/` في `src` للصورة. رفع ملفات: غير موجود.

## 29. السجلات والمتابعة

`app.js` يكتب إلى `console` (رقم السيناريو، حالة HTTP، JSON). لا مجلد `logs` ولا جدول تدقيق.

## 30. التثبيت

1. PHP مع امتداد `mysqli` وMySQL محلي. رقم إصدار PHP: غير موثق.
2. تنفيذ `database.sql` (ينشئ `arshed_db`).
3. مطابقة `config.php` مع مستخدم MySQL المحلي.
4. تشغيل `extract_and_insert.php` أو `insert_data.php` عبر المتصفح أو CLI مرة واحدة.
5. فتح الصفحة من خادم ويب يشغّل PHP، كما في نص `showErrorMessage`: `http://localhost/ARSHED/index.html`.

فتح الملف مباشرة كـ `file://` يمنع `fetch` إلى `api.php`.

## 31. دليل التطوير

- رقم السيناريو: `index.html` = 1، و`indexN.html` = N، حسب `getScenarioNumber` و`extractScenarioNumber`.
- معامل اختياري في الرابط: `?scenario=`.
- لإضافة سيناريو: صف في `scenarios` وصفوف في `options`، وصفحة HTML مطابقة إن بقي التنقل اليدوي في `.pagination`.
- `showFeedback` يحتاج الإبقاء على أسماء `opt1`..`opt3` إن بقيت الدالة كما هي.

## 32. النشر

غير موثق. لا `Dockerfile` ولا ملف استضافة ولا نطاق في الكود. `config.php` يستخدم `localhost` و`root`.

## 33. النسخ الاحتياطي والاستعادة

غير موثق. الاستعادة العملية من الملفات: إعادة تنفيذ `database.sql` ثم أحد سكربتات التعبئة. لا سكربت نسخ احتياطي.

## 34. تشخيص المشكلات

| العرض | ما يقوله الكود |
| --- | --- |
| رسالة لا يمكن الاتصال بالخادم | تشغيل XAMPP أو WAMP والفتح عبر localhost |
| السيناريو غير موجود | تشغيل `extract_and_insert.php` |
| فشل الاتصال | نص `die` من `getDBConnection` يتضمن `connect_error` |
| التغذية لا تظهر لخيار رابع | `showFeedback` تفحص ثلاثة عناصر فقط |

## 35. الاعتماديات

لا `composer.json` ولا `package.json`. الاعتماد على CDN مذكور في القسم 16، وعلى PHP وMySQL.

## 36. القيود المعروفة

- واجهة السيناريو إنجليزية بينما رسائل الخطأ عربية.
- روابط الشريط ما عدا Home وScenarios لا تؤدي إلى صفحات (`#`)، وHome يطلب ملفاً غير موجود (`Arshed-html.html`).
- لا حفظ للإجابات.
- `showFeedback` محدودة بثلاثة خيارات.
- صور `images/` غير موجودة في الملفات الحالية.
- لا أيقونة تبويب (`favicon`) في `index.html`.
- استعلامات `api.php` ليست Prepared Statements.

## 37. حالة النظام الحالية

الملفات الحالية تطبيق قراءة للسيناريوهات مع سكربتات تعبئة يدوية. لا اختبارات آلية ولا ملف إصدار.

تعارض اسم: المجلد `ARSHED`، والعنوان المعروض `Arshad`.

## 38. قرارات المعمارية

استنتاج من الكود: الصفحات ثابتة لكل رقم، والبيانات تُجلب من القاعدة حتى يمكن تحديث النص دون تعديل كل HTML، مع الإبقاء على نسخة HTML يستطيع `extract_and_insert.php` قراءتها بـ `DOMDocument` و`DOMXPath`.

## 39. سجل التغييرات

غير موثق. لا مستودع git موثق داخل هذا المجلد في الملفات المقروءة، ولا ملف سجل إصدارات.

## System Overview

Ethical AI-in-education scenarios. Twenty HTML pages load one row from `scenarios` plus child `options` through `api.php`. Three PHP scripts fill or update MySQL. No accounts.

## Quick Reference

| البند | القيمة |
| --- | --- |
| القاعدة | `arshed_db` |
| الجداول | `scenarios`, `options` |
| القراءة | `api.php` |
| الواجهة | `app.js` + `index.html` ... `index20.html` |
| التعبئة | `extract_and_insert.php` أو `insert_data.php` |
| التحديث | `update_data.php` |

## Quick Start

```
mysql -u root -p < database.sql
```

ثم افتح `extract_and_insert.php` أو `insert_data.php` من خادم PHP، ثم `index.html`.

## For Non-Technical Users

تفتح صفحة، تقرأ الموقف، تختار قراراً، وتضغط Submit Decision لترى التعليق على هذا القرار. القرار لا يُرسل إلى قاعدة بيانات. إن ظهر تحذير أحمر، الصفحة لم تصل إلى PHP أو القاعدة فارغة.

## For Developers

ابدأ من `getScenarioNumber` و`loadScenario` في `app.js` ثم فرعي `action` في `api.php`. مخطط الجداول في `database.sql`. بيانات العينة الكاملة في مصفوفة `$scenarios_data` داخل `insert_data.php`. لا تضع كلمات مرور في الوثائق؛ `DB_PASS` في `config.php` فارغة حالياً.
