<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "./css/main.css">
    <title>Document</title>
</head>
<body>
   
<?php
function readFolderFiles($dir) {
    $files = scandir($dir);
    
    echo '<ul>';
    foreach ($files as $file) {
        if (substr($file, 0, 1) != '.') {
            echo '<li>';
            if (is_dir($dir . '/' . $file)) {
            echo "<li><img src='./images/folder.png' class = 'folder'> ".$file;
                readFolderFiles($dir . '/' . $file);
            } else 
            echo '<a href ="' . $dir .'/' . $file . '">' .$file . '</a>';
            echo '</li>';
        }
    }
    echo '</ul>';
}
readFolderFiles("C:/Program Files/Ampps/www/");
?>   
</body>
</html>