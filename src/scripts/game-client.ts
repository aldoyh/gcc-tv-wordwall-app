// src/scripts/game-client.ts
// Client-side logic for game page

// Translation data
const translations = {
  en: {
    "app_title": "Wordwall Match Up",
    "create_new_game": "Create New Game",
    "view_leaderboard": "View Leaderboard",
    "add_questions": "Add Questions",
    "edit_questions": "Edit Questions",
    "switch_template": "Switch Template",
    "default_theme": "Default Theme",
    "dark_theme": "Dark Theme",
    "colorful_theme": "Colorful Theme",
    "time": "Time",
    "score": "Score",
    "reset": "Reset",
    "check_answers": "Check Answers",
    "add_to_leaderboard": "Add to Leaderboard",
    "enter_your_name": "Enter your name",
    "submit": "Submit",
    "no_questions_found": "No questions found. Please add some questions first.",
    "unsupported_game_template": "Unsupported game template.",
    "quiz_finished": "Quiz Finished!",
    "your_final_score": "Your final score:",
    "play_again": "Play Again",
    "failed_to_load_game_data": "Failed to load game data.",
    "failed_to_load_questions": "Failed to load questions.",
    "loading_game": "Loading game...",
    "no_questions_found": "No questions found.",
    "unsupported_game_template": "Unsupported game template.",
    "timer_label": "Game timer",
    "score_label": "Game score",
    "all_answers_correct": "All answers are correct!",
    "you_got_correct": "You got {0} out of {1} correct.",
    "correct": "Correct!",
    "incorrect": "Incorrect!",
    "next_question": "Next Question",
    "share": "Share",
    "share_game": "Share Game",
    "copy_url": "Copy URL",
    "url_copied": "URL copied!",
    "error_copying_url": "Error copying URL.",
    "error_generating_qr": "Error generating QR code.",
    "qr_library_not_loaded": "QR code library not loaded.",
    "error_submitting_score": "Error submitting score.",
    "enter_new_template": "Enter new template:",
    "error_switching_template": "Error switching template."
  },
  ar: {
    "app_title": "ووردوول ماتش أب",
    "create_new_game": "إنشاء لعبة جديدة",
    "view_leaderboard": "عرض لوحة الصدارة",
    "add_questions": "إضافة أسئلة",
    "edit_questions": "تعديل الأسئلة",
    "switch_template": "تبديل القالب",
    "default_theme": "السمة الافتراضية",
    "dark_theme": "السمة الداكنة",
    "colorful_theme": "السمة الملونة",
    "time": "الوقت",
    "score": "النقاط",
    "reset": "إعادة تعيين",
    "check_answers": "التحقق من الإجابات",
    "add_to_leaderboard": "إضافة إلى لوحة الصدارة",
    "enter_your_name": "أدخل اسمك",
    "submit": "إرسال",
    "no_questions_found": "لم يتم العثور على أسئلة. الرجاء إضافة بعض الأسئلة أولاً.",
    "unsupported_game_template": "قالب اللعبة غير مدعوم.",
    "quiz_finished": "انتهى الاختبار!",
    "your_final_score": "درجتك النهائية:",
    "play_again": "العب مرة أخرى",
    "failed_to_load_game_data": "فشل تحميل بيانات اللعبة.",
    "failed_to_load_questions": "فشل تحميل الأسئلة.",
    "loading_game": "جاري تحميل اللعبة...",
    "no_questions_found": "لم يتم العثور على أسئلة.",
    "unsupported_game_template": "قالب اللعبة غير مدعوم.",
    "timer_label": "مؤقت اللعبة",
    "score_label": "نتيجة اللعبة",
    "all_answers_correct": "كل الإجابات صحيحة!",
    "you_got_correct": "لقد حصلت على {0} من أصل {1} صحيح.",
    "correct": "صحيح!",
    "incorrect": "خطأ!",
    "next_question": "السؤال التالي",
    "share": "مشاركة",
    "share_game": "مشاركة اللعبة",
    "copy_url": "نسخ الرابط",
    "url_copied": "تم نسخ الرابط!",
    "error_copying_url": "خطأ في نسخ الرابط.",
    "error_generating_qr": "خطأ في إنشاء رمز الاستجابة السريعة.",
    "qr_library_not_loaded": "مكتبة رمز الاستجابة السريعة غير محملة.",
    "error_submitting_score": "خطأ في إرسال النتيجة.",
    "enter_new_template": "أدخل القالب الجديد:",
    "error_switching_template": "خطأ في تبديل القالب."
  }
};

function getLanguage() {
  const storedLang = localStorage.getItem('lang');
  return storedLang || 'en';
}

function t(key, ...args) {
  const lang = getLanguage();
  let translation = (translations[lang] && translations[lang][key]) || translations.en[key] || key;
  args.forEach((arg, index) => {
    translation = translation.replace(`{${index}}`, String(arg));
  });
  return translation;
}

function showNotification({ message, type = 'info', duration = 3000 }) {
  let container = document.getElementById('notification-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'notification-container';
    container.style.position = 'fixed';
    container.style.top = '1rem';
    container.style.right = '1rem';
    container.style.zIndex = '9999';
    document.body.appendChild(container);
  }
  const notification = document.createElement('div');
  notification.className = `p-3 mb-3 rounded-md shadow-md text-white`;
  switch (type) {
    case 'success': notification.style.background = '#22c55e'; break;
    case 'error': notification.style.background = '#ef4444'; break;
    case 'info': notification.style.background = '#3b82f6'; break;
  }
  notification.textContent = message;
  container.appendChild(notification);
  setTimeout(() => { notification.remove(); }, duration);
}

// The rest of the game logic should be moved here from game.astro
// For brevity, only utility functions are included now.
// Next step: Move all game logic from game.astro <script> to this file.
