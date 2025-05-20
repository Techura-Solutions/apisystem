<?php

class RobloxAPI {
    private $baseUrl = 'https://api.roblox.com';
    private $usersUrl = 'https://users.roblox.com/v1';
    private $avatarUrl = 'https://thumbnails.roblox.com/v1';

    // Get User ID by Username
    public function getUserByUsername($username) {
        $url = $this->usersUrl . "/usernames/users";
        $data = ['usernames' => [$username]];

        return $this->postJson($url, $data);
    }

    // Get Avatar Image URL
    public function getUserAvatar($userId) {
        $url = $this->avatarUrl . "/users/avatar";
        $params = http_build_query([
            'userIds' => $userId,
            'size' => '420x420',
            'format' => 'Png',
            'isCircular' => 'false'
        ]);

        return $this->getJson($url . "?" . $params);
    }

    // Get Game Details by Universe ID
    public function getGameDetails($universeId) {
        $url = "https://games.roblox.com/v1/games?universeIds=$universeId";
        return $this->getJson($url);
    }

    // Helper: POST JSON
    private function postJson($url, $data) {
        $opts = [
            "http" => [
                "method" => "POST",
                "header" => "Content-Type: application/json",
                "content" => json_encode($data)
            ]
        ];
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return json_decode($result, true);
    }

    // Helper: GET JSON
    private function getJson($url) {
        $result = file_get_contents($url);
        return json_decode($result, true);
    }
}
