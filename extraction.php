<?php
// Force overwrite ZIP extraction script
// Usage: Place this file in the same directory as your ZIP file and run it via browser

error_reporting(E_ALL);
ini_set('display_errors', 1);

$zipFileName = 'swiftsynch.zip'; // Change this to your ZIP file name
$extractPath = './'; // Extract to current directory

echo "<h2>ZIP File Extraction Script</h2>";
echo "<p>Attempting to extract: <strong>$zipFileName</strong></p>";

// Check if ZIP file exists
if (!file_exists($zipFileName)) {
    echo "<p style='color: red;'>Error: ZIP file '$zipFileName' not found!</p>";
    exit;
}

// Check if ZipArchive class is available
if (!class_exists('ZipArchive')) {
    echo "<p style='color: red;'>Error: ZipArchive class not available on this server!</p>";
    exit;
}

$zip = new ZipArchive();
$result = $zip->open($zipFileName);

if ($result === TRUE) {
    echo "<p style='color: green;'>ZIP file opened successfully!</p>";
    
    // Get number of files in archive
    $numFiles = $zip->numFiles;
    echo "<p>Archive contains $numFiles files</p>";
    
    // Extract with force overwrite
    $extractResult = $zip->extractTo($extractPath);
    
    if ($extractResult) {
        echo "<p style='color: green;'><strong>SUCCESS!</strong> All files extracted to: $extractPath</p>";
        echo "<p>Files have been forcefully overwritten if they existed.</p>";
        
        // List some extracted files for confirmation
        echo "<h3>Sample of extracted files:</h3>";
        echo "<ul>";
        for ($i = 0; $i < min(10, $numFiles); $i++) {
            $fileName = $zip->getNameIndex($i);
            echo "<li>$fileName</li>";
        }
        if ($numFiles > 10) {
            echo "<li>... and " . ($numFiles - 10) . " more files</li>";
        }
        echo "</ul>";
        
    } else {
        echo "<p style='color: red;'>Error: Failed to extract files!</p>";
    }
    
    $zip->close();
} else {
    echo "<p style='color: red;'>Error: Cannot open ZIP file. Error code: $result</p>";
    
    // Error code meanings
    $errors = [
        ZipArchive::ER_OK => 'No error',
        ZipArchive::ER_MULTIDISK => 'Multi-disk zip archives not supported',
        ZipArchive::ER_RENAME => 'Renaming temporary file failed',
        ZipArchive::ER_CLOSE => 'Closing zip archive failed',
        ZipArchive::ER_SEEK => 'Seek error',
        ZipArchive::ER_READ => 'Read error',
        ZipArchive::ER_WRITE => 'Write error',
        ZipArchive::ER_CRC => 'CRC error',
        ZipArchive::ER_ZIPCLOSED => 'Containing zip archive was closed',
        ZipArchive::ER_NOENT => 'No such file',
        ZipArchive::ER_EXISTS => 'File already exists',
        ZipArchive::ER_OPEN => 'Can\'t open file',
        ZipArchive::ER_TMPOPEN => 'Failure to create temporary file',
        ZipArchive::ER_ZLIB => 'Zlib error',
        ZipArchive::ER_MEMORY => 'Memory allocation failure',
        ZipArchive::ER_CHANGED => 'Entry has been changed',
        ZipArchive::ER_COMPNOTSUPP => 'Compression method not supported',
        ZipArchive::ER_EOF => 'Premature EOF',
        ZipArchive::ER_INVAL => 'Invalid argument',
        ZipArchive::ER_NOZIP => 'Not a zip archive',
        ZipArchive::ER_INTERNAL => 'Internal error',
        ZipArchive::ER_INCONS => 'Zip archive inconsistent',
        ZipArchive::ER_REMOVE => 'Can\'t remove file',
        ZipArchive::ER_DELETED => 'Entry has been deleted',
    ];
    
    if (isset($errors[$result])) {
        echo "<p>Error meaning: " . $errors[$result] . "</p>";
    }
}

echo "<hr>";
echo "<p><strong>Important:</strong> Delete this extraction script after use for security!</p>";
echo "<p>You can delete this file via SFTP or create a delete script.</p>";
?>