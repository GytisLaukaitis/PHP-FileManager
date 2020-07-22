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
    $files_and_dirs = scandir($path);
    print('<table><th>Type</th><th>Name</th><th>Actions</th>');
    foreach ($files_and_dirs as $fnd){
        if ($fnd != ".." and $fnd != ".") {
            print('<tr>');
            print('<td>' . (is_dir($path . $fnd) ? "Directory" : "File") . '</td>');
            print('<td>' . (is_dir($path . $fnd) 
                        ? '<a href="' . (isset($_GET['path']) 
                                ? $_SERVER['REQUEST_URI'] . $fnd . '/' 
                                : $_SERVER['REQUEST_URI'] . '?path=' . $fnd . '/') . '">' . $fnd . '</a>'
                        : $fnd)
                . '</td>');
            print('<td>'
                . (is_dir($path . $fnd) 
                    ? ''
                    : '<form style="display: inline-block" action="" method="post">
                        <input type="hidden" name="delete" value=' . str_replace(' ', '&nbsp;', $fnd) . '>
                        <input type="submit" value="Delete">
                       </form>
                       <form style="display: inline-block" action="" method="post">
                        <input type="hidden" name="download" value=' . str_replace(' ', '&nbsp;', $fnd) . '>
                        <input type="submit" value="Download">
                       </form>'
                ) 
                . "</form></td>");
            print('</tr>');
        }
    }
    print("</table>");
?>  
 
</body>
</html>