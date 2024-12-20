<?php
// Include the Telegram Bot API library
require_once 'vendor/autoload.php';
use Telegram\Bot\Api;

// Set up the Telegram bot API
$bot = new Api('YOUR_BOT_TOKEN');

// Get the latest post on the channel
$updates = $bot->getUpdates();
$latest_post = $updates[count($updates) - 1];

// Get the post ID
$post_id = $latest_post->getMessage()->getMessageId();

// Check if the post has already been processed
$processed_posts = file_get_contents('processed_posts.txt');
if (strpos($processed_posts, $post_id) !== false) {
    // Post has already been processed
    exit;
}

// Add the post ID to the processed posts list
file_put_contents('processed_posts.txt', $post_id . "\n", FILE_APPEND);

// Follow the channel
$bot->forwardMessage([
    'chat_id' => YOUR_CHAT_ID,
    'from_chat_id' => '@notpixelads',
    'message_id' => $post_id
]);

// Like the post
$bot->sendMessage([
    'chat_id' => '@notpixelads',
    'reply_to_message_id' => $post_id,
    'text' => '👍'
]);

// Follow the channel and like the post
$bot->sendMessage([
    'chat_id' => YOUR_CHAT_ID,
    'text' => 'Followed and liked the latest post on @notpixelads'
]);
?>
