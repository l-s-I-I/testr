<?php
// استرجاع التوكن من البيئة
$TOKEN = getenv('BOT_TOKEN');
$data = json_decode(file_get_contents('php://input'), true);  // قراءة التحديثات من Telegram

// التحقق من وجود بيانات رسائل
if (isset($data['message'])) {
    $chat_id = $data['message']['chat']['id'];  // استرجاع معرف الدردشة
    $message_id = $data['message']['message_id'];  // استرجاع معرف الرسالة
    $message_text = $data['message']['text'];  // استرجاع نص الرسالة

    // التحقق إذا كانت الرسالة تحتوي على / أو start أو hello
    if (strpos($message_text, '/') !== false || strpos($message_text, 'start') !== false || strpos($message_text, 'hello') !== false) {
        // رسالة الترحيب مع إيموجي
        $welcome_message = "Hi 👋";

        // إرسال رسالة عبر API Telegram
        $url = "https://api.telegram.org/bot{$TOKEN}/sendMessage?chat_id={$chat_id}&text=" . urlencode($welcome_message);
        
        // إرسال الطلب إلى API Telegram
        $response = file_get_contents($url);

        // التحقق إذا كان هناك خطأ في إرسال الطلب
        if ($response === FALSE) {
            // طباعة رسالة الخطأ إذا فشل الاتصال
            error_log("Error sending message: " . error_get_last()['message']);
        } else {
            // طباعة أن الرسالة تم إرسالها بنجاح
            echo "Message sent successfully!";
        }
    }
}

// لتشغيل Webhook مع الرابط الخاص بك، تأكد من استخدام الرابط التالي
$webhook_url = "http://195.35.2.79:8000/api/v1/deploy?uuid=rs8okgo4sssskc40o0w8cosw&force=false";

// إرسال طلب Webhook لتشغيله
$response = file_get_contents($webhook_url);

// طباعة رد الـ Webhook
if ($response === FALSE) {
    // طباعة الخطأ إذا فشل الطلب
    error_log("Error triggering webhook: " . error_get_last()['message']);
} else {
    // طباعة النجاح إذا تم إرسال الطلب بنجاح
    echo "Webhook triggered successfully!";
}
?>
