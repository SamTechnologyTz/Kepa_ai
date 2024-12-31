<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Video - Kepa AI</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Kepa AI - Display Video</h1>
    </header>
    <main>
        <form id="videoForm" action="display_video.php" method="post">
            <label for="video_id">Enter Video ID:</label>
            <input type="text" id="video_id" name="video_id" required>
            <button type="submit">Fetch Video</button>
        </form>
        <div id="videoDisplay">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $video_id = $_POST['video_id'];
                $url = "https://api.kepa.ai/v1/videos/$video_id";
                $options = array(
                    'http' => array(
                        'header' => "Authorization: Bearer YOUR_API_TOKEN\r\n",
                        'method' => 'GET',
                    ),
                );
                $context = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                if ($result !== FALSE) {
                    $video_data = json_decode($result, true);
                    echo '<h2>' . htmlspecialchars($video_data['name']) . '</h2>';
                    echo '<video controls>';
                    echo '<source src="' . htmlspecialchars($video_data['download_url']) . '" type="video/mp4">';
                    echo 'Your browser does not support the video tag.';
                    echo '</video>';
                } else {
                    echo "Error fetching video.";
                }
            }
            ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Kepa AI. All rights reserved.</p>
    </footer>
</body>
</html>
