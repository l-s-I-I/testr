<?php
// استرجاع التوكن من البيئة
$TOKEN = getenv('BOT_TOKEN');  
$data = json_decode(file_get_contents('php://input'), true);  // قراءة التحديثات من Telegram

// تحقق من وجود رسالة في البيانات
if (isset($data['message'])) {
    $chat_id = $data['message']['chat']['id'];  // استرجاع معرف الدردشة
    $message_id = $data['message']['message_id'];  // استرجاع معرف الرسالة
    $message_text = $data['message']['text'];  // استرجاع نص الرسالة

    // إذا كانت الرسالة تحتوي على النص "hello"
    if (strpos($message_text, 'hello') !== false) {
        // رسالة الترحيب مع إيموجي
        $welcome_message = "Hi 👋";

        // إرسال رسالة عبر API Telegram
        $url = "https://api.telegram.org/bot{$TOKEN}/sendMessage?chat_id={$chat_id}&text=" . urlencode($welcome_message);

        // إرسال الطلب إلى API Telegram
        file_get_contents($url);
    }
}
?>
