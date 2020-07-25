<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location:applications.php");
}
include_once('config.php');
if(isset($_POST) && isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $req = "SELECT * FROM users WHERE username=? AND password=?";
    $res = $dbh->prepare($req);
    $res->execute(array($username, $password));
    if($res->rowCount() == 1){
        $_SESSION['user'] = $res->fetchAll();
        header('Location:admin.php');
    }
    else{
        echo "Erreur";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minego Jobs - Connexion</title>
</head>
<body>
    <h1>Minego Jobs</h1>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur">
        <input type="password" name="password" id="" placeholder="Mot de passe">
        <input type="submit" value="Connexion">
    </form>
</body>
</html>