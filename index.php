<div>
 <?php
      //login logic

    session_start();
     $msg = '';
     if (isset($_POST['login']) 
         && !empty($_POST['username']) 
         && !empty($_POST['password'])
     ) {	
        if ($_POST['username'] == 'Gytis' && 
           $_POST['password'] == 'password'
         ) {
           $_SESSION['logged_in'] = true;
           $_SESSION['timeout'] = time();
           $_SESSION['username'] = 'Gytis';
        } else {
           $msg = 'Wrong username or password';
        }
     }
     if(isset($_GET['action']) and $_GET['action'] == 'logout'){
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
        print('Logged out!');
    }
 ?>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "./css/main.css">
    <title>File manager</title>
</head>
<body>
    <style>
        /* table css */

        * {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 60%;
        }
        table td, table th {
            border: 1px solid black;
            padding: 8px;
        }
        table tr:nth-child(even){
            background-color: #f2f2f2;
        }
        table tr:hover{
            background-color: #ddd;
        }
        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: gray;
            color: white;
        }
    </style>
<?php
  if(!$_SESSION['logged_in'] == true){
    print('<form action = "index.php?path=" method = "post">');
    print('<h4>' . $msg . '</h4>');
    print('<input type = "text" name = "username"  required autofocus></br>');
    print('<input type = "password" name = "password" required>');
    print('<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login">Login</button>');
    print('</form>');
    die();

}
    // show files and directories

$path = "./" . str_replace("./","",$_GET['path'], $i);
$filesDirs = scandir($path);

print('<table><th>Type</th><th>Actions</th><th>Name</th>');
for ($i = 0; $i < count($filesDirs); $i++) {
    if ($filesDirs[$i] === '.' || $filesDirs[$i] === '..') {
        continue;
    }
    print "<tr><td>";
    if (is_dir($path . $filesDirs[$i])) {
        print ("<img src='./images/folder2.png' class = 'folder'></td>");
        print ("<td><td><a href ='?path=" .$path .  $filesDirs[$i] . '/' . "'>" . $filesDirs[$i] . "</a></tr></td></td>");
    } else {
        print ("<img src='./images/file2.png' class = 'folder'></td>");
        print ('<td><form style="display: inline-block" action="" method="post">
        <input type="hidden" name="delete" value=' . str_replace(' ', '&nbsp;', $fnd) . '>
        <input type="submit" value="Delete">
       </form><td>' . $filesDirs[$i] . '</td></tr></td>');
    }
}
print ("</table>"); 

  //  directory creation logic
  if(isset($_GET["create_dir"])){
    if($_GET["create_dir"] != ""){
        $dir_to_create = './' . $_GET["path"] . $_GET["create_dir"];
        if (!is_dir($dir_to_create)) mkdir($dir_to_create, 0777, true);
    }
    $url = preg_replace("/(&?|\??)create_dir=(.+)?/", "", $_SERVER["REQUEST_URI"]);
    header('Location: ' . urldecode($url));
}

 // directory deletion logic
 if(isset($_POST['delete'])){
    $objToDelete = './' . $_GET["path"] . $_POST['delete']; 
    $objToDeleteEscaped = str_replace("&nbsp;", " ", htmlentities($objToDelete, null, 'utf-8'));
    if(is_file($objToDeleteEscaped)){
        if (file_exists($objToDeleteEscaped)) {
            unlink($objToDeleteEscaped);
        }
    }
}

      // Go back button

print("\t".'<button><a href="');
$back_fake = explode('/', $_SERVER['QUERY_STRING']);
$back_real = explode('/', $_SERVER['QUERY_STRING'],-2);
if (count($back_fake) == 1 || count($back_fake) == 2) {
    print('?path=/'.'">GO BACK</a>');
} else
print('?'.implode('/',$back_real).'/'.'"> GO BACK</a></button>');
?>  


<form action="index.php" method="get">
                <input type="hidden" name="path" value="<?php print($_GET['path']) ?>" /> 
                <input placeholder="Name of new directory" type="text" id="create_dir" name="create_dir">
                <button type="submit">Submit</button>
            </form>
 <div class = "logout">
 <a href = "index.php?action=logout"> Logout
</div>
</body>
</html>