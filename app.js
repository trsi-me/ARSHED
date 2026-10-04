// دالة جلب السيناريو من قاعدة البيانات
async function loadScenario(scenarioNumber) {
  try {
    console.log('🔍 جاري جلب السيناريو رقم:', scenarioNumber);
    const apiUrl = `api.php?action=get_scenario&number=${scenarioNumber}`;
    console.log('📍 رابط API:', apiUrl);

    const response = await fetch(apiUrl);

    console.log('📡 حالة الاستجابة:', response.status, response.statusText);

    if (!response.ok) {
      console.error('❌ خطأ HTTP:', response.status);
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const contentType = response.headers.get('content-type');
    console.log('📄 نوع المحتوى:', contentType);

    const data = await response.json();
    console.log('✅ البيانات المستلمة:', data);

    if (data.error) {
      console.error('❌ خطأ من API:', data.error);
      showErrorMessage('خطأ: ' + data.error);
      return;
    }

    // عرض البيانات الكاملة في Console للمساعدة في التشخيص
    console.log('📦 محتوى البيانات الكامل:', JSON.stringify(data, null, 2));
    console.log('🔑 بيانات مهمة:', {
      id: data.id,
      title: data.title,
      description: data.description ? data.description.substring(0, 50) + '...' : 'لا يوجد',
      options_count: data.options ? data.options.length : 0
    });

    if (!data || !data.id) {
      console.error('❌ البيانات فارغة أو غير صحيحة:', data);
      showErrorMessage('السيناريو غير موجود في قاعدة البيانات. تأكد من تشغيل extract_and_insert.php');
      return;
    }

    // تحديث عنوان السيناريو
    const titleElement = document.querySelector('.scenario-box h2');
    console.log('🔍 عنصر العنوان:', titleElement ? 'موجود ✅' : 'غير موجود ❌');
    if (titleElement) {
      titleElement.textContent = data.title || 'What is your decision?';
      console.log('✅ تم تحديث العنوان:', titleElement.textContent);
    } else {
      console.error('❌ لا يمكن العثور على عنصر العنوان');
    }

    // تحديث نص السيناريو
    const descriptionElement = document.querySelector('.scenario-box p');
    console.log('🔍 عنصر الوصف:', descriptionElement ? 'موجود ✅' : 'غير موجود ❌');
    if (descriptionElement) {
      descriptionElement.textContent = data.description || '';
      console.log('✅ تم تحديث الوصف، الطول:', descriptionElement.textContent.length);
    } else {
      console.error('❌ لا يمكن العثور على عنصر الوصف');
    }

    // تحديث الصورة
    const imageElement = document.querySelector('.image-side img');
    if (imageElement && data.image_path) {
      imageElement.src = data.image_path;
      imageElement.alt = data.title || 'Scenario';
    }

    // تحديث الخيارات
    console.log('🔍 عدد الخيارات المستلمة:', data.options ? data.options.length : 0);

    if (data.options && data.options.length > 0) {
      console.log('✅ الخيارات موجودة، جاري عرضها...');

      // حذف الخيارات القديمة (باستثناء الـ h2 و p و button و pagination)
      const existingOptions = document.querySelectorAll('.option');
      console.log('🗑️ حذف الخيارات القديمة:', existingOptions.length);
      existingOptions.forEach(opt => opt.remove());

      // إضافة الخيارات الجديدة قبل زر Submit
      const submitBtn = document.querySelector('.submit-btn');
      console.log('🔍 زر Submit:', submitBtn ? 'موجود ✅' : 'غير موجود ❌');

      if (!submitBtn) {
        console.error('❌ لا يمكن العثور على زر Submit - لن يتم إضافة الخيارات!');
        return;
      }

      data.options.forEach((option, index) => {
        console.log(`📝 إضافة الخيار ${index + 1}:`, option.option_text.substring(0, 50) + '...');

        const optionDiv = document.createElement('div');
        optionDiv.className = 'option';

        const optionId = `opt${index + 1}`;
        const feedbackId = `feedback${index + 1}`;

        optionDiv.innerHTML = `
                    <input type="radio" name="decision" id="${optionId}"> 
                    ${option.option_text}
                    <div class="feedback" id="${feedbackId}">${option.feedback_text}</div>
                `;

        // إدراج الخيار قبل زر Submit
        if (submitBtn && submitBtn.parentNode) {
          submitBtn.parentNode.insertBefore(optionDiv, submitBtn);
          console.log(`✅ تم إضافة الخيار ${index + 1}`);
        } else {
          console.error(`❌ فشل إضافة الخيار ${index + 1}`);
        }
      });

      console.log('✅ تم إضافة جميع الخيارات بنجاح');
    } else {
      console.warn('⚠️ لا توجد خيارات في البيانات');
    }

  } catch (error) {
    console.error('❌ خطأ في جلب البيانات:', error);
    console.error('تفاصيل الخطأ:', error.message);
    console.error('نوع الخطأ:', error.name);

    let errorMsg = 'لا يمكن الاتصال بالخادم. ';
    if (error.message.includes('fetch')) {
      errorMsg += 'تأكد من تشغيل خادم PHP (XAMPP/WAMP) وافتح المشروع من http://localhost';
    } else {
      errorMsg += 'خطأ: ' + error.message;
    }
    showErrorMessage(errorMsg);
  }
}

// دالة لإظهار رسالة خطأ للمستخدم
function showErrorMessage(message) {
  const descriptionElement = document.querySelector('.scenario-box p');
  if (descriptionElement) {
    descriptionElement.innerHTML = `
      <strong style="color: red;">⚠️ ${message}</strong><br><br>
      <strong>خطوات الحل:</strong><br>
      1. تأكد من تشغيل XAMPP أو WAMP<br>
      2. افتح المشروع من http://localhost/ARSHED/index.html<br>
      3. تأكد من إنشاء قاعدة البيانات وتشغيل extract_and_insert.php
    `;
  }
}

// دالة عرض الردود
function showFeedback() {
  const opt1 = document.getElementById("opt1");
  const opt2 = document.getElementById("opt2");
  const opt3 = document.getElementById("opt3");

  if (opt1) {
    document.getElementById("feedback1").style.display = opt1.checked ? "block" : "none";
  }
  if (opt2) {
    document.getElementById("feedback2").style.display = opt2.checked ? "block" : "none";
  }
  if (opt3) {
    document.getElementById("feedback3").style.display = opt3.checked ? "block" : "none";
  }
}

// تحديد رقم السيناريو من URL أو من اسم الملف
function getScenarioNumber() {
  const filename = window.location.pathname.split('/').pop();

  // استخراج الرقم من اسم الملف (index.html = 1, index2.html = 2, ...)
  if (filename === 'index.html') {
    return 1;
  }

  const match = filename.match(/index(\d+)\.html/);
  if (match) {
    return parseInt(match[1]);
  }

  // محاولة أخرى: البحث عن معامل في URL
  const urlParams = new URLSearchParams(window.location.search);
  const scenarioNumber = urlParams.get('scenario');
  if (scenarioNumber) {
    return parseInt(scenarioNumber);
  }

  return 1; // القيمة الافتراضية
}

// تحميل السيناريو عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function () {
  console.log('🚀 بدء تحميل الصفحة...');
  const scenarioNumber = getScenarioNumber();
  console.log('📊 رقم السيناريو المحدد:', scenarioNumber);
  loadScenario(scenarioNumber);
});
