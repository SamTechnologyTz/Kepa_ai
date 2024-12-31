<?php

class ElaiAPI
{
    private $apiToken;
    private $baseUrl = 'https://apis.elai.io/api/v1/';

    public function __construct($apiToken)
    {
        $this->apiToken = $apiToken;
    }

    private function sendRequest($endpoint, $method = 'GET', $data = null)
    {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url);
      
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer ' . $this->apiToken,
            'Content-Type: application/json',
        ]);

        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'PATCH':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
        if (curl_errno($ch)) {
            throw new Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        $decodedResponse = json_decode($response, true);

        if ($httpCode >= 400) {
            $errorMessage = isset($decodedResponse['message']) ? $decodedResponse['message'] : 'An error occurred';
            throw new Exception('HTTP error ' . $httpCode . ': ' . $errorMessage);
        }

        return $decodedResponse;
    }

    public function createVideo($name, $slides, $tags = [])
    {
        $endpoint = 'videos';
        $data = [
            'name' => $name,
            'slides' => $slides,
            'tags' => $tags,
        ];

        return $this->sendRequest($endpoint, 'POST', $data);
    }

    public function renderVideo($videoId)
    {
        $endpoint = 'videos/render/' . $videoId;
        return $this->sendRequest($endpoint, 'POST');
    }

    public function getVideo($videoId)
    {
        $endpoint = 'videos/' . $videoId;
        return $this->sendRequest($endpoint);
    }

    public function updateVideo($videoId, $data)
    {
        $endpoint = 'videos/' . $videoId;
        return $this->sendRequest($endpoint, 'PATCH', $data);
    }

    public function deleteVideo($videoId)
    {
        $endpoint = 'videos/' . $videoId;
        return $this->sendRequest($endpoint, 'DELETE');
    }  
}

try {
    $apiToken = API_TOKEN;
    $elai = new ElaiAPI($apiToken);
  
    $name = 'Hello from API!';
    $slides = [
        [
            'id' => 1,
            'canvas' => [
                'objects' => [
                    [
                        'type' => 'avatar',
                        'left' => 151.5,
                        'top' => 36,
                        'fill' => '#4868FF',
                        'scaleX' => 0.3,
                        'scaleY' => 0.3,
                        'width' => 1080,
                        'height' => 1080,
                        'src' => 'assets/img/kepa.webp',
                        'avatarType' => 'transparent',
                        'animation' => [
                            'type' => null,
                            'exitType' => null,
                        ],
                    ],
                ],
            ],
            'speech' => 'Hi there! It\'s my first video created by Kepa.',
            'voice' => 'en-US-AriaNeural',
            'voiceType' => 'text',
            'voiceProvider' => 'azure',
        ],
    ];
    $tags = ['test'];

    $video = $elai->createVideo($name, $slides, $tags);
    echo 'Video created with ID: ' . $video['id'] . PHP_EOL;

    // Render the video
    $renderResponse = $elai->renderVideo($video['id']);
    echo 'Render response: ' . print_r($renderResponse, true) . PHP_EOL;

    // Retrieve the video details
    $videoDetails = $elai->getVideo($video['id']);
    echo 'Video details: ' . print_r($videoDetails, true) . PHP_EOL;

    // Update the video
    $updateData = ['name' => 'Updated Video Name'];
    $updatedVideo = $elai->updateVideo($video['id'], $updateData);
    echo 'Updated video: ' . print_r($updatedVideo, true) . PHP_EOL;

    // Delete the video
    $elai->deleteVideo($video['id']);
    echo 'Video deleted.' . PHP_EOL;

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
?>
