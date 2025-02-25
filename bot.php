<?php
// استرجاع التوكن من المتغير البيئي
$TOKEN = getenv('BOT_TOKEN');

// إعداد متغير ss
$ss = "❤️‍🔥";

// URL للـ API الخاص بالبوت
$api_url = "https://api.telegram.org/bot{$TOKEN}/";

// دالة لتفاعل البوت مع الرسائل
function react_to_message($chat_id, $message_id, $ss, $api_url) {
    $url = $api_url . 'setMessageReaction';
    $data = [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'reaction' => [['type' => 'emoji', 'emoji' => $ss]]
    ];
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// دالة لمعالجة الرسائل
function handle_message($message, $ss, $api_url) {
    $text = $message['text'];
    if (strpos($text, '.') !== false || strpos($text, '/') !== false) {
        react_to_message($message['chat']['id'], $message['message_id'], $ss, $api_url);
    }
}

// الوصول إلى التحديثات الجديدة للبوت
$update_url = $api_url . "getUpdates";
$updates = json_decode(file_get_contents($update_url), true);

// معالجة كل رسالة جديدة
foreach ($updates['result'] as $update) {
    handle_message($update['message'], $ss, $api_url);
}
?>
