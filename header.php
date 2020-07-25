<?php
session_start();
include_once('config.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minego Jobs - Candidatures</title>
    <link rel="stylesheet" href="lib/css/style.css">
    <link rel="stylesheet" href="lib/css/admin.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
      $( "#accordion" ).accordion();
    } );
    </script>
</head>
<body>
    <?php if(isset($_SESSION['user'])): ?>
    <div id="menu" class="container">
        <nav class="nav">
            <li><a href="applications.php">Candidatures</a></li>
            <li><a href="jobs.php">Postes</a></li>
            <li><a href="index.php">Visiter le site</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </nav>
    </div>
    <?php endif; ?>