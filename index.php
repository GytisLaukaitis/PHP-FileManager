<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
</head>
<body>
<?php
function readFolderFiles($dir) {
    $files = scandir("C:/Program Files/Ampps/www/");

    echo '<ul>';
    foreach ($files as $file) {
        if (substr($file, 0, 1) != '.') {
            echo '<li>';
            if (is_dir($dir . '/' . $file)) {
                echo $file;
                readFolderFiles($dir . '/' . $files);
            } else 
            echo '<a href ="' . $dir .'/' . $file . '">' .$file . '</a>';
            echo '</li>';
        }
    }
    echo '</ul>';
}
     readFolderFiles($dir);
?>   
</body>
</html>