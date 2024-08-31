<?php
include("connection.php");

$short_link = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $long_link = $_POST['short_link'];
    $short_link = substr(md5(time() . $long_link), 0, 6); // Generate a short code

    $query = "INSERT INTO links (long_link, short_link) VALUES (?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('ss', $long_link, $short_link);

    if ($stmt->execute()) {
        $generated_short_url =  $short_link;
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Short URL Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .copy-button {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 text-center">
            <h1 class="mb-4">Short URL Generator</h1>
            <form action="index.php" method="POST" class="p-4 rounded shadow">
                <div class="mb-3">
                    <label for="url" class="form-label">Enter your URL</label>
                    <input type="url" class="form-control" id="url" name="short_link" placeholder="https://example.com" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Generate Short URL</button>
            </form>

            <?php if (isset($generated_short_url)): ?>
                <div class="mt-4 p-3 border rounded bg-light">
                    <h5 class="mb-3">Your Short URL:</h5>
                    <input type="text" id="shortUrl" class="form-control mb-2" value="<?php echo $generated_short_url; ?>" readonly>
                    <button class="btn btn-secondary copy-button" onclick="copyToClipboard()">Copy to Clipboard</button>
                </div>
            <?php elseif (isset($error_message)): ?>
                <div class="mt-4 p-3 border rounded bg-danger text-white">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function copyToClipboard() {
        var copyText = document.getElementById("shortUrl");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("Copied to clipboard: " + copyText.value);
    }
</script>
</body>
</html>
