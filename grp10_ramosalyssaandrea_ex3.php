<?php
// Function to check if the file exists
function checkFileExists($filename) {
    return file_exists($filename);
}

// Function to read the file content
function readFileContent($filename) {
    return file_get_contents($filename);
}

// Function to append content to the file
function appendToFile($filename, $content) {
    return file_put_contents($filename, $content, FILE_APPEND);
}

// Function to create a new file with initial content
function createFileWithContent($filename, $content) {
    return file_put_contents($filename, $content);
}

// Initialize variables
$filename = '';
$contentToAppend = '';
$message = '';
$fileContent = '';
$changes = '';

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = $_POST['filename'] . '.txt'; // Append .txt to the filename
    $contentToAppend = $_POST['content'];

    if (empty($filename)) {
        $message = "Filename cannot be empty!";
    } else {
        if (checkFileExists($filename)) {
            appendToFile($filename, "\n" . $contentToAppend);
            $message = "Your TXT file has been updated. Please check your folder.";
            $changes = "New content added to the file:\n" . htmlspecialchars($contentToAppend);
            $fileContent = readFileContent($filename);
        } else {
            createFileWithContent($filename, $contentToAppend); // Create the file with the provided content
            $message = "TXT file created with initial content!";
            $changes = "Added the following initial content:\n" . htmlspecialchars($contentToAppend);
            $fileContent = $contentToAppend;
        }
    }
    // Clear the form data after submission
    $_POST['filename'] = '';
    $_POST['content'] = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Handling Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            padding: 20px;
        }
        h1 {
            color: white;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
            color: green;
        }
        .file-info {
            margin-top: 20px;
            color: white;
        }
        .file-info h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .file-info pre {
            background-color: #333;
            padding: 10px;
            border-radius: 4px;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <center>
    <h1>Group 10 - Exercise 3</h1>
    <form method="post" action="">
        <label for="filename">Enter the filename (without .txt):</label>
        <input type="text" id="filename" name="filename" value="<?php echo htmlspecialchars($_POST['filename'] ?? ''); ?>" required>
        
        <label for="content">Enter the content you want to append:</label>
        <textarea id="content" name="content" rows="4" required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
        
        <input type="submit" value="Submit">
    </center>
    </form>

    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if ($changes): ?>
        <div class="file-info">
            <h2>File Information:</h2>
            <p><strong>Filename:</strong> <?php echo htmlspecialchars($filename); ?></p>
            <p><strong>Changes:</strong></p>
            <pre><?php echo htmlspecialchars($changes); ?></pre>
            <p><strong>Current File Content:</strong></p>
            <pre><?php echo htmlspecialchars($fileContent); ?></pre>
        </div>
    <?php endif; ?>
</body>
</html>
