<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "./css/main.css">
    <title>Document</title>
</head>
<body>
<form action="index.php" method="get">
<input type="hidden" name="path" value="<?php print($_GET['path']) ?>" /> 
</form>
   
<?php
$dir = '..' . $_GET['path'];
function readFolderFiles($dir) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if (substr($file, 0, 1) != '.') {
            if (is_dir($dir . '/' . $file)) {
                echo '<a href ="' . $dir .'/' . $file . '">'  .$file . "</ul><img src='./images/folder.png' class = 'folder'>" . '</a>';
                readFolderFiles($dir . '/' . $file);
            } else 
            echo '<a href ="' . '">';
        }
    }
}
readFolderFiles($dir);
?>  
 
</body>
</html>