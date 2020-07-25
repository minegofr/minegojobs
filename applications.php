<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location:index.php");
}
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
      $( "#list" ).accordion();
    } );
    </script>
</head>
<body>
    <div class="container">
        <nav class="nav">
            <li><a href="applications.php">Candidatures</a></li>
            <li><a href="jobs.php">Postes</a></li>
            <li><a href="index.php">Visiter le site</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </nav>
        <div class="applications">
            <h1>Candidatures</h1>
            <ul class="list" id="list">
                <?php
                    $req = $dbh->prepare("SELECT * FROM applications ORDER BY id DESC");
                    $req->execute();
                    $count = $req->rowCount();
                    $data = $req->fetchAll(PDO::FETCH_OBJ);
                    for($i=0;$i<$count;$i++): ?>
                        <h3><?= $data[$i]->pseudo_discord;?> </h3>
                        <div>
                            <div><b>Pseudo Discord : </b><span><?= $data[$i]->pseudo_discord; ?></span></div>
                            <div><b>Pseudo Minecraft : </b><span><?= $data[$i]->pseudo_minecraft; ?></span></div>
                            <div><b>Minecraft Premium : </b><span>
                                <?php 
                                if($data[$i]->premium == 1): 
                                echo "oui";
                                else: 
                                echo "non"; 
                                endif; ?>
                            </span></div>
                            <h4>Date de naissance :</h4>
                            <?php 
                            $source = $data[$i]->birthday_date;
                            $date = new DateTime($source);
                            ?>
                            <p><?= $date->format('d.m.Y');?></p>
                            <h4>Poste :</h4>
                            <p><?= $data[$i]->job; ?></p>
                            <h4>Présentation :</h4>
                            <p><?= $data[$i]->presentation; ?></p>
                            <h4>Expérience :</h4>
                            <p><?= $data[$i]->experience; ?></p>
                            <h4>Disponibilités : </h4>
                            <p><?= $data[$i]->availability; ?></p>
                        </div>

                    <?php endfor; ?>
            </ul>
        </div>
    </div>
</body>
</html>