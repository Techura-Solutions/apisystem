<?php

class DiscordAPI {
    private $baseUrl = 'https://discord.com/api/v10';
    private $botToken;

    public function __construct($botToken) {
        $this->botToken = $botToken;
    }

    // Get Bot User Info
    public function getCurrentUser() {
        $url = $this->baseUrl . "/users/@me";
        return $this->getJson($url);
    }

    // Send Message to Channel
    public function sendMessage($channelId, $message) {
        $url = $this->baseUrl . "/channels/$channelId/messages";
        $data = ['content' => $message];

        return $this->postJson($url, $data);
    }

    // Get Guild Info
    public function getGuild($guildId) {
        $url = $this->baseUrl . "/guilds/$guildId";
        return $this->getJson($url);
    }

    // Helper: GET JSON with Authorization
    private function getJson($url) {
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Authorization: Bot {$this->botToken}\r\n"
            ]
        ];
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return json_decode($result, true);
    }

    // Helper: POST JSON with Authorization
    private function postJson($url, $data) {
        $opts = [
            "http" => [
                "method" => "POST",
                "header" => "Content-Type: application/json\r\n" .
                            "Authorization: Bot {$this->botToken}\r\n",
                "content" => json_encode($data)
            ]
        ];
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return json_decode($result, true);
    }
}
// Adding Other Code Here For helper

<?php
require_once 'discordAPI.php';

$botToken = "YOUR_DISCORD_BOT_TOKEN_HERE";
$channelId = "YOUR_CHANNEL_ID_HERE";

$discord = new DiscordAPI($botToken);

// Send a message
$response = $discord->sendMessage($channelId, "Hello from PHP!");
print_r($response);

// Get bot user info
$user = $discord->getCurrentUser();
echo "Bot username: " . $user['username'] . "#" . $user['discriminator'];
