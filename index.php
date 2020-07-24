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

<?php
  if(!$_SESSION['logged_in'] == true){
    print('<div class = "form"><span> Please enter username and password</span><form action = "index.php?path=" method = "post">');
    print('<h4>' . $msg . '</h4>');
    print('<input type = "text" class = "username" name = "username"  required autofocus></br>');
    print('<input type = "password" class = "password" name = "password" required>');
    print('<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login">Login</button>');
    print('</form></div>');
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
        print ( "<img src='./images/file2.png' class = 'folder'></td>");
        print ( '<td><form style="display: inline-block" action="" method="post">');
        print ( '<input type="hidden" name="delete" value=' . str_replace(' ', '&nbsp;', $filesDirs[$i]) . '>');
        print ( '<input type="submit" value="Delete">');
        print ( '</form><td>' . $filesDirs[$i] . '</td></tr></td>');
    }
}
print ("</table>"); 

  //  directory creation logic
  if(isset($_GET["make_fold"])){
    if($_GET["make_fold"] != ""){
        $folder_create = './' . $_GET["path"] . $_GET["make_fold"];
        if (!is_dir($folder_create)) mkdir($folder_create, 0777, true);
    }
    $url = preg_replace("/(&?|\??)make_fold=(.+)?/", "", $_SERVER["REQUEST_URI"]);
    header('Location: ' . urldecode($url));
}

 // file deletion logic
 if(isset($_POST['delete'])){
    $fileDelete = './' . $_GET["path"] . $_POST['delete']; 
    $fileNotDeleted = str_replace("&nbsp;", " ", htmlentities($fileDelete, null, 'utf-8'));
    if(is_file($fileNotDeleted)){
        if (file_exists($fileNotDeleted)) {
            unlink($fileNotDeleted);
        }
    }
}

      // Go back button
print ('<div class = "back">');
print("\t".'<button  class = "batonas"><a href="');
$back_fake = explode('/', $_SERVER['QUERY_STRING']);
$back_real = explode('/', $_SERVER['QUERY_STRING'],-2);
if (count($back_fake) == 1 || count($back_fake) == 2) {
    print('path'.'">GO BACK</a>');
} else
print('?'.implode('/',$back_real).'/'.'"> GO BACK</a></button>');
print ('</div>');
?>  

<div class = "create">
    <form action="" method="get">
                <input type="hidden" name="path" value="<?php print($_GET['path']) ?>" /> 
                <input placeholder="Name of new directory" type="text" id="make_fold" name="make_fold">
                <button type="submit">Submit</button>
    </form>
</div>
 <div class = "logout">
 <a href = "index.php?action=logout"> Logout
</div>
</body>
</html>