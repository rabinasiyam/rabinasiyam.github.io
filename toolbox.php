<?php
// Telegram Bot Token
$TOKEN = '6380061608:AAHghcCWKUYf_a7BNv6vA3eo_JQqO8Kaubk';

// Admin User ID
$ADMIN_USER_ID = '5779948934';


// Image URL for welcome message
$WELCOME_IMAGE_URL = 'https://i.ibb.co.com/XpP4b1b/logo.png';

// Image for Help manu
$Help_Image = 'https://i.ibb.co.com/XpP4b1b/logo.png';


// CTF Image Url

$CTF_IMAGE ='https://i.ibb.co.com/XpP4b1b/logo.png'

// Fetching updates
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

// Retrieve message details
$message = isset($update['message']) ? $update['message'] : "";
$message_id = isset($message['message_id']) ? $message['message_id'] : "";
$chat_id = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$text = isset($message['text']) ? $message['text'] : "";
$first_name = isset($message['from']['first_name']) ? $message['from']['first_name'] : "";
$last_name = isset($message['from']['last_name']) ? $message['from']['last_name'] : "";
$user_id = isset($message['from']['id']) ? $message['from']['id'] : "";
$photo = isset($message['photo']) ? $message['photo'] : "";

// Maintain a list of users
$users_file = 'users.txt';
$users = file_exists($users_file) ? file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
if (!in_array($chat_id, $users)) {
    file_put_contents($users_file, $chat_id . PHP_EOL, FILE_APPEND);
}

// Function to send a message via the bot
function sendMessage($chat_id, $text, $reply_markup = null) {
    global $TOKEN;
    $url = "https://api.telegram.org/bot$TOKEN/sendMessage";
    $post_fields = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'Markdown'
    ];
    if ($reply_markup) {
        $post_fields['reply_markup'] = $reply_markup;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_exec($ch);
    curl_close($ch);
}

// Function to send a photo via the bot
function sendPhoto($chat_id, $photo_url, $caption, $reply_markup = null) {
    global $TOKEN;
    $url = "https://api.telegram.org/bot$TOKEN/sendPhoto";
    $post_fields = [
        'chat_id' => $chat_id,
        'photo' => $photo_url,
        'caption' => $caption,
        'parse_mode' => 'Markdown'
    ];
    if ($reply_markup) {
        $post_fields['reply_markup'] = $reply_markup;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_exec($ch);
    curl_close($ch);
}

// Function to create the custom inline keyboard
function inline_keyboard() {
    return json_encode([
        'inline_keyboard' => [
            [['text' => '🔎 IP Lookup', 'callback_data' => 'ip_lookup']],
            [['text' => 'Generate QR Code', 'callback_data' => 'generate_qr']],
            [['text' => 'Read QR Code', 'callback_data' => 'read_qr']],
            [['text' => '🔍 Port Scanner', 'callback_data' => 'port_scanner']],
            [['text' => '🔒 Password Strength Checker', 'callback_data' => 'password_strength']],
            [['text' => '🔗 Shorten URL', 'callback_data' => 'shorten_url']],
            [['text' => '🔗 Expand URL', 'callback_data' => 'expand_url']]
        ]
    ]);
}

// Function to create the custom keyboard
function custom_keyboard() {
    return json_encode([
        'keyboard' => [
            [['text' => '🔎 IP Lookup'], ['text' => 'Generate QR Code']],
            [['text' => 'Read QR Code'], ['text' => '🔍 Port Scanner']],
            [['text' => '🔒 Password Strength Checker'], ['text' => '🔗 Shorten URL']],
            [['text' => '🔗 Expand URL']]
        ],
        'resize_keyboard' => true,
        'one_time_keyboard' => false
    ]);
}

// Command: /start
if ($text == "/start") {
    // Create an inline keyboard button for "My IP"
    $reply_markup = json_encode([
        'inline_keyboard' => [
            [['text' => '🌐 My IP', 'url' => 'https://black-tiger.onrender.com/ipinfo.php']],
            [['text' => '🔎 IP Lookup', 'callback_data' => 'ip_lookup']],
            [['text' => 'Generate QR Code', 'callback_data' => 'generate_qr']],
            [['text' => 'Read QR Code', 'callback_data' => 'read_qr']],
            [['text' => '🔍 Port Scanner', 'callback_data' => 'port_scanner']],
            [['text' => '🔒 Password Strength Checker', 'callback_data' => 'password_strength']],
            [['text' => '🔗 Shorten URL', 'callback_data' => 'shorten_url']],
            [['text' => '🔗 Expand URL', 'callback_data' => 'expand_url']]
        ]
    ]);

    // Send a welcome message with the custom keyboard
    $caption = "Hello $first_name $last_name\nUsage:\n1. 🔎 *IP Lookup* to find IP details\n2. *Generate QR Code* to create a QR code\n3. *Read QR Code* to scan a QR code\n4. *Port Scanner* to scan open ports\n5. *Password Strength Checker* to check password strength\n6. *Shorten URL* to shorten a URL\n7. *Expand URL* to expand a shortened URL";
    sendPhoto($chat_id, $WELCOME_IMAGE_URL, $caption, $reply_markup);
    exit;
}

// Command: /ctf
if ($text == "/ctf") {
    // Create an inline keyboard button for "My IP"
    $reply_markup = json_encode([
        'inline_keyboard' => [
            [['text' => '🤖 Join Me', 'url' => 'https://t.me/Black_Tiger_RoBot']]
        ]
    ]);

    // Send a welcome message with the custom keyboard
    $caption = "Hay $first_name $last_name,\n *Did you find the 1st flag?*\n Then give it to me. I will give you the clue for 2nd Flag.";
    sendPhoto($chat_id, $CTF_IMAGE, $caption, $reply_markup);
    exit;
}


// Command: /help
if ($text == "/help") {
    // Create an inline keyboard button for "My IP"
    $reply_markup = json_encode([
        'inline_keyboard' => [
            [['text' => '🌐 My IP', 'url' => 'https://black-tiger.onrender.com/ipinfo.php']],
            [['text' => '🔎 IP Lookup', 'callback_data' => 'ip_lookup']],
            [['text' => 'Generate QR Code', 'callback_data' => 'generate_qr']],
            [['text' => 'Read QR Code', 'callback_data' => 'read_qr']],
            [['text' => '🔍 Port Scanner', 'callback_data' => 'port_scanner']],
            [['text' => '🔒 Password Strength Checker', 'callback_data' => 'password_strength']],
            [['text' => '🔗 Shorten URL', 'callback_data' => 'shorten_url']],
            [['text' => '🔗 Expand URL', 'callback_data' => 'expand_url']]
        ]
    ]);

    // Send a welcome message with the custom keyboard
    $caption = "O hay $first_name $last_name\n *Hare is the help manu for you.*\n1. 🔎 *IP Lookup* to find IP details\n2. *Generate QR Code* to create a QR code\n3. *Read QR Code* to scan a QR code\n4. *Port Scanner* to scan open ports\n5. *Password Strength Checker* to check password strength\n6. *Shorten URL* to shorten a URL\n7. *Expand URL* to expand a shortened URL";
    sendPhoto($chat_id, $Help_Image, $caption, $reply_markup);
    exit;
}

// Handle messages
if ($text == '🔎 IP Lookup') {
    sendMessage($chat_id, "Send IP address:");
    file_put_contents('ip_update.txt', '1');
    exit;
}

if ($text == 'Generate QR Code') {
    sendMessage($chat_id, "Send the text or URL to generate QR code:");
    file_put_contents('qr_update.txt', '1');
    exit;
}

if ($text == 'Read QR Code') {
    sendMessage($chat_id, "Please upload the QR code image:");
    file_put_contents('read_qr_update.txt', '1');
    exit;
}

if ($text == '🔍 Port Scanner') {
    sendMessage($chat_id, "Send IP address or domain name to scan for open ports:");
    file_put_contents('port_update.txt', '1');
    exit;
}

if ($text == '🔒 Password Strength Checker') {
    sendMessage($chat_id, "Send the password to check its strength:");
    file_put_contents('password_update.txt', '1');
    exit;
}

if ($text == '🔗 Shorten URL') {
    sendMessage($chat_id, "Send the URL to shorten:");
    file_put_contents('shorten_url_update.txt', '1');
    exit;
}

if ($text == '🔗 Expand URL') {
    sendMessage($chat_id, "Send the shortened URL to expand:");
    file_put_contents('expand_url_update.txt', '1');
    exit;
}

if ($text == 'Siyam' || $text == 'siyam' || $text == 'Sifatullah' || $text == 'sifatullah') {
    sendMessage($chat_id, "HaHaHa 😅\n \n You got my name . \n Thanks for stay with me.");
    exit;
}

// Handle callback queries
if (isset($update['callback_query'])) {
    $callback_query = $update['callback_query'];
    $callback_data = $callback_query['data'];
    $chat_id = $callback_query['message']['chat']['id'];

    if ($callback_data == 'ip_lookup') {
        sendMessage($chat_id, "Send IP address:");
        file_put_contents('ip_update.txt', '1');
        exit;
    }

    if ($callback_data == 'generate_qr') {
        sendMessage($chat_id, "Send the text or URL to generate QR code:");
        file_put_contents('qr_update.txt', '1');
        exit;
    }

    if ($callback_data == 'read_qr') {
        sendMessage($chat_id, "Please upload the QR code image:");
        file_put_contents('read_qr_update.txt', '1');
        exit;
    }

    if ($callback_data == 'port_scanner') {
        sendMessage($chat_id, "Send IP address or domain name to scan for open ports:");
        file_put_contents('port_update.txt', '1');
        exit;
    }

    if ($callback_data == 'password_strength') {
        sendMessage($chat_id, "Send the password to check its strength:");
        file_put_contents('password_update.txt', '1');
        exit;
    }

    if ($callback_data == 'shorten_url') {
        sendMessage($chat_id, "Send the URL to shorten:");
        file_put_contents('shorten_url_update.txt', '1');
        exit;
    }

    if ($callback_data == 'expand_url') {
        sendMessage($chat_id, "Send the shortened URL to expand:");
        file_put_contents('expand_url_update.txt', '1');
        exit;
    }
}

// Process IP Lookup
if (file_get_contents('ip_update.txt') == '1') {
    $ip = $text;
    $url = "http://ip-api.com/json/{$ip}";
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    if ($data['status'] == 'success') {
        $response_text = "🌐 *IP :* {$data['query']}\n" .
            "🌍 *Country :* {$data['country']}\n" .
            "🌎 *Region :* {$data['regionName']}\n" .
            "🏴 *City :* {$data['city']}\n" .
            "🌐 *ISP :* {$data['isp']}\n" .
            "📍 *Latitude :* {$data['lat']}\n" .
            "📍 *Longitude :* {$data['lon']}\n" .
            "🕒 *Timezone :* {$data['timezone']}\n";
        sendMessage($chat_id, $response_text);
    } else {
        sendMessage($chat_id, "Failed to retrieve data. Please try again.");
    }
    file_put_contents('ip_update.txt', '');
    exit;
}

// Process QR Code Generation
if (file_get_contents('qr_update.txt') == '1') {
    $data = $text;
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($data) . "&size=200x200";
    sendPhoto($chat_id, $qr_url, "Here is your QR code for: $data");
    file_put_contents('qr_update.txt', '');
    exit;
}

// Process QR Code Reading
if (file_get_contents('read_qr_update.txt') == '1' && !empty($photo)) {
    $file_id = $photo[count($photo) - 1]['file_id'];
    $file_url = "https://api.telegram.org/bot$TOKEN/getFile?file_id=$file_id";
    $file_response = file_get_contents($file_url);
    $file_data = json_decode($file_response, true);

    if ($file_data['ok']) {
        $file_path = $file_data['result']['file_path'];
        $photo_url = "https://api.telegram.org/file/bot$TOKEN/$file_path";

        // Send the image URL to an external QR code reader API
        $qr_api_url = "https://api.qrserver.com/v1/read-qr-code/?fileurl=" . urlencode($photo_url);
        $qr_response = file_get_contents($qr_api_url);
        $qr_data = json_decode($qr_response, true);

        if (isset($qr_data[0]['symbol'][0]['data'])) {
            $qr_text = $qr_data[0]['symbol'][0]['data'];
            sendMessage($chat_id, "QR code contains: $qr_text");
        } else {
            sendMessage($chat_id, "Failed to read the QR code. Please try again.");
        }
    } else {
        sendMessage($chat_id, "Failed to retrieve the photo. Please try again.");
    }
    file_put_contents('read_qr_update.txt', '');
    exit;
}

// Process Port Scanner
if (file_get_contents('port_update.txt') == '1') {
    $target = filter_var($text, FILTER_VALIDATE_IP) ? $text : gethostbyname($text);

    if (filter_var($target, FILTER_VALIDATE_IP)) {
        $open_ports = [];
        $ports = [21, 22, 23, 25, 53, 80, 110, 143, 443, 445, 8080];
        foreach ($ports as $port) {
            $connection = @fsockopen($target, $port, $errno, $errstr, 0.5);
            if (is_resource($connection)) {
                $open_ports[] = $port;
                fclose($connection);
            }
        }

        $response_text = "Open ports on $target: " . implode(", ", $open_ports);
        sendMessage($chat_id, $response_text);
    } else {
        sendMessage($chat_id, "Invalid IP address or domain name.");
    }
    file_put_contents('port_update.txt', '');
    exit;
}

// Process Password Strength Checker
if (file_get_contents('password_update.txt') == '1') {
    $password = $text;
    $strength = getPasswordStrength($password);
    sendMessage($chat_id, $strength);
    file_put_contents('password_update.txt', '');
    exit;
}

// Process URL Shortener
if (file_get_contents('shorten_url_update.txt') == '1') {
    $long_url = $text;
    $short_url = shortenURL($long_url);
    sendMessage($chat_id, "Shortened URL: $short_url");
    file_put_contents('shorten_url_update.txt', '');
    exit;
}

// Process URL Expander
if (file_get_contents('expand_url_update.txt') == '1') {
    $short_url = $text;
    $long_url = expandURL($short_url);
    sendMessage($chat_id, "Expanded URL: $long_url");
    file_put_contents('expand_url_update.txt', '');
    exit;
}

// Function to check password strength and provide recommendations
function getPasswordStrength($password) {
    $strength = 0;
    $recommendations = [];

    if (strlen($password) >= 8) {
        $strength += 1;
    } else {
        $recommendations[] = "Make your password at least 8 characters long.";
    }

    if (preg_match('/[A-Z]/', $password)) {
        $strength += 1;
    } else {
        $recommendations[] = "Include at least one uppercase letter.";
    }

    if (preg_match('/[a-z]/', $password)) {
        $strength += 1;
    } else {
        $recommendations[] = "Include at least one lowercase letter.";
    }

    if (preg_match('/[0-9]/', $password)) {
        $strength += 1;
    } else {
        $recommendations[] = "Include at least one number.";
    }

    if (preg_match('/[\W]/', $password)) {
        $strength += 1;
    } else {
        $recommendations[] = "Include at least one special character (e.g., @, #, $).";
    }

    $strength_levels = ["Very Weak", "Weak", "Medium", "Strong", "Very Strong"];
    $strength_text = $strength_levels[$strength];

    $response_text = "Password Strength: $strength_text\n\n";
    if (!empty($recommendations)) {
        $response_text .= "Recommendations:\n- " . implode("\n- ", $recommendations);
    } else {
        $response_text .= "Great job! Your password is strong.";
    }

    return $response_text;
}

// Function to shorten a URL using TinyURL API
function shortenURL($long_url) {
    $api_url = "http://tinyurl.com/api-create.php?url=" . urlencode($long_url);
    $short_url = file_get_contents($api_url);
    return $short_url ? $short_url : "Failed to shorten URL. Please try again.";
}



// Function to expand a URL using TinyURL API
function expandURL($short_url) {
    $api_url = "http://tinyurl.com/api-redirect.php?url=" . urlencode($short_url);
    $headers = get_headers($api_url, 1);
    return isset($headers['Location']) ? $headers['Location'] : "Failed to expand URL. Please try again.";
}
?>
