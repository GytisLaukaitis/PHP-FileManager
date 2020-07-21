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
 $path = '../' . $_GET["path"];
 $files = scandir($path);

 echo('<tr>');
 foreach ($files as $file){
     if ($file != ".." and $file != ".") {
         echo("<td><img src='./images/folder.png' class = 'folder'>" . (is_dir($path . $file) 
                     ? '<a href="' . (isset($_GET['path']) 
                             ? $_SERVER['REQUEST_URI'] . $file . '/' 
                             : $_SERVER['REQUEST_URI'] . '?path=' . $file . '/') . '">' . $file . '</a>'
                     : $file)
             . "</td>");
     }
 }
 echo('<tr>');
?>  
 
</body>
</html>