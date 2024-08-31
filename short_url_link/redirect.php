<?php
$connection = new mysqli('hostname', 'username', 'password', 'database_name');

if (isset($_GET['code'])) {
    $short_link = $_GET['code'];

    $query = "SELECT long_link FROM links WHERE short_link = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('s', $short_link);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        header("Location: " . $row['long_link']);
        exit();
    } else {
        echo "Invalid short URL.";
    }
} else {
    echo "No short URL code provided.";
}
