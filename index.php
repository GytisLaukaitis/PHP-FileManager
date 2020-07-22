
<h2>Enter Username and Password</h2> 
<div>
 <?php
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
           $_SESSION['username'] = 'Edvinas';
        } else {
           $msg = 'Wrong username or password';
        }
     }
 ?>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "./css/main.css">
    <title>Document</title>
</head>
<body>
    <div>
    <form action = "" method = "post">
        <h4><?php echo $msg; ?></h4>
        <input type = "text" name = "username" placeholder = "username = Edvinas" required autofocus></br>
        <input type = "password" name = "password" placeholder = "password = 01" required>
        <button type = "submit" name = "login">Login</button>
    </form>
        Click here to <a href = "index.php?action=logout"> logout.
    </div> 
<style>
        * {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table td, table th {
            border: 1px solid #ddd;
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
            text-align: left;
            background-color: gray;
            color: white;
        }
    </style>
<?php
 if($_SESSION['logged_in'] == true){
$path = "./" . str_replace("./","",$_GET['path'], $i);
$filesDirs = scandir($path);

print('<table><th>Type</th><th>Name</th><th>Actions</th>');
for ($i = 0; $i < count($filesDirs); $i++) {
    if ($filesDirs[$i] === '.' || $filesDirs[$i] === '..') {
        continue;
    }
    print "<tr><td>";
    if (is_dir($filesDirs[$i])) {
        print ("<img src='./images/folder2.png' class = 'folder'></td>");
        print ("<td><a href ='?path=" .$path . '/'. $filesDirs[$i] . "'>" . $filesDirs[$i] . "</a></tr></td>");
    } else {
        print ("<img src='./images/file2.png' class = 'folder'></td>");
        print ("<td>" . $filesDirs[$i] . "</td></tr>");
    }
}
print ("</table");
 }
 if(isset($_GET['action']) and $_GET['action'] == 'logout'){
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
    print('Logged out!');
}
  
?>  
 
</body>
</html>