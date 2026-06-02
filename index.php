<?php
$items = [];
$searchQuery = '';

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $searchQuery = trim($_GET['search']);

    $apiKey = 'c704a783eaa14e4e20fe6d698951ca66cbeadbe3';

    $url = "https://google.serper.dev/search";

    $data = json_encode(array("q" => $searchQuery));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-API-KEY: ' . $apiKey,
        'Content-Type: application/json'
    ));

    $resultJson = curl_exec($ch);
    curl_close($ch);

    if ($resultJson) {
        $data = json_decode($resultJson, true);
        if (isset($data['organic'])) {
            $items = $data['organic'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>My Browser (Serper API)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .result-item { margin-bottom: 20px; }
        .result-title { font-size: 18px; color: #1a0dab; text-decoration: none; }
        .result-title:hover { text-decoration: underline; }
        .result-snippet { font-size: 14px; color: #4d5156; }
    </style>
</head>
<body>
<h2>My Browser</h2>
<form method="GET" action="/index.php">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>"><br><br>
    <input type="submit" value="Submit">
</form>

<hr>

<?php
if (!empty($items)) {
    echo '<h3>Search results:</h3>';
    foreach ($items as $item) {
        echo '<div class="result-item">';
        echo '<a class="result-title" href="' . htmlspecialchars($item['link']) . '" target="_blank">' . htmlspecialchars($item['title']) . '</a><br>';
        if (isset($item['snippet'])) {
            echo '<span class="result-snippet">' . htmlspecialchars($item['snippet']) . '</span>';
        }
        echo '</div>';
    }
} elseif (isset($_GET['search'])) {
    echo '<p>За вашим запитом нічого не знайдено.</p>';
}
?>
</body>
</html>