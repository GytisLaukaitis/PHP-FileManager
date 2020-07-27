<div>
 <?php
      //Login logic

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

    //  Logout logic
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

    // Login form

    print('<div class = "form"><span> Please enter username and password</span><form action = "index.php?path=" method = "post">');
    print('<h4>' . $msg . '</h4>');
    print('<input type = "text" class = "username" name = "username"  required autofocus></br>');
    print('<input type = "password" class = "password" name = "password" required>');
    print('<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "login">Login</button>');
    print('</form></div>');
    die();

}
    // Show files and directories

$path = "./" . str_replace("./","",$_GET['path'], $i);
$filesDirs = scandir($path);

print('<table><th>Type</th><th>Actions</th><th>Name</th>');
for ($i = 0; $i < count($filesDirs); $i++) {
    if ($filesDirs[$i] === '.' || $filesDirs[$i] === '..') {
        continue;
    }
    print "<tr><td>";
    if (is_dir($path . $filesDirs[$i])) {
        print ("<img src='./images/folder3.png' class = 'folder'></td>");

        // Directory deletion from

        print ( '<td><form style="display: inline-block" action="" method="post">');
        print ( '<input type="hidden" name="deletion" value=' . str_replace(' ', '&nbsp;', $filesDirs[$i]) . '>');
        print ( '<input type="submit" value="Delete"></form>');

        // Directory download form

        print ( '<form style="display: inline-block" action="" method="post">');
        print ( '<input type="hidden" name="download" value=' . str_replace(' ', '&nbsp;', $filesDirs[$i]) . '>');
        print ( '<input type="submit" value="Download">');

        print ("</form><td><a href ='?path=" .$path .  $filesDirs[$i] . '/' . "'>" . $filesDirs[$i] . "</a></tr></td></td>");

    } else {
        print ( "<img src='./images/file3.png' class = 'folder'></td>");

        // File delete form

        print ( '<td><form style="display: inline-block" action="" method="post">');
        print ( '<input type="hidden" name="delete" value=' . str_replace(' ', '&nbsp;', $filesDirs[$i]) . '>');
        print ( '<input type="submit" value="Delete"></form>');

        // File download form

        print ( '<form style="display: inline-block" action="" method="post">');
        print ( '<input type="hidden" name="download" value=' . str_replace(' ', '&nbsp;', $filesDirs[$i]) . '>');
        print ( '<input type="submit" value="Download">');

        print ( '</form><td>' . $filesDirs[$i] . '</td></tr></td>');

    }
}
print ("</table>"); 

  //  Directory creation logic
  if(isset($_GET["make_fold"])){
    if($_GET["make_fold"] != ""){
        $folder_create = './' . $_GET["path"] . $_GET["make_fold"];
        if (!is_dir($folder_create)) mkdir($folder_create, 0777, true);
    }
    echo'<script>window.location.reload()</script>';
    $url = preg_replace("/(&?|\??)make_fold=(.+)?/", "", $_SERVER["REQUEST_URI"]);
    header('Location: ' . urldecode($url));
}

 // File deletion logic
 if(isset($_POST['delete'])){
    $fileDelete = './' . $_GET["path"] . $_POST['delete']; 
    $fileNotDeleted = str_replace("&nbsp;", " ", htmlentities($fileDelete, null, 'utf-8'));
    if(is_file($fileNotDeleted)){
        if (file_exists($fileNotDeleted)) {
            unlink($fileNotDeleted);
            echo'<script>window.location.reload()</script>';
        }
    }
}
// Folder deletion logic
if(isset($_POST['deletion'])){
    $folderDelete = './' . $_GET["path"] . $_POST['deletion']; 
    $folderNotDeleted = str_replace("&nbsp;", " ", htmlentities($folderDelete, null, 'utf-8'));
    if(is_dir($folderNotDeleted)){
        rmdir($folderNotDeleted);
        echo'<script>window.location.reload()</script>';
    }
}
// File download logic
if(isset($_POST['download'])){
    print('Path to download: ' . './' . $_GET["path"] . $_POST['download']);
    $path='./' . $_GET["path"] . $_POST['download'];
    $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($path, null, 'utf-8'));

    header('Content-Type: image/jpeg');
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileToDownloadEscaped));

    // flush();
    readfile($fileToDownloadEscaped);
    exit;
}
   // File upload logic
   if(isset($_FILES['fileToUpload'])){
    $errors= array();
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['fileToUpload']['name'])));
    
    $extensions= array("jpeg","jpg","png","pdf");
    
    if(in_array($file_ext , $extensions) === false){
       $errors[] = "extension not allowed, please choose a JPEG, PNG or PDF file.";
    }
    
    if($file_size > 2097152) {
       $errors[] = 'File size must be below 2 MB';
    }
    
    if(empty($errors)==true) {
       move_uploaded_file($file_tmp, './' . $_GET["path"] . $file_name);
       echo "<meta http-equiv='refresh' content='0'>";
    }else{
        print_r($_FILES);
        print('<br>');
        print_r($errors);
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
<!-- Directory creation form -->
<div class = "create">
    <form action="" method="get">
        <input type="hidden" name="path" value="<?php print($_GET['path']) ?>" /> 
        <input placeholder="Name of new directory" type="text" id="make_fold" name="make_fold">
        <button type="submit">Submit</button>
    </form>
    <!-- File upload form -->
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="img" style="display:none;"/>
        <button style="display: block; width: 100%" type="button">
        <label for="img">Choose file</label>
        </button>
        <button style="display: block; width: 100%" type="submit">Upload file</button>
    </form>
</div>
 <div class = "logout">
 <a href = "index.php?action=logout"> Logout
</div>
</body>
</html>