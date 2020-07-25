<?php include_once('config.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minego Jobs - Accueil</title>
    <link rel="stylesheet" href="lib/css/style.css">
</head>
<body>
    
    <div class="container">

        <div id="description">
            <div class="description_logo">
                <img src="lib/img/logo.png" alt="">
            </div>
            <div class="description_content">
                <h1>Minego Jobs</h1>
                <h2>Présentation du serveur</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita tenetur temporibus, nam quos ea quo error mollitia recusandae officiis, laborum minus animi nihil alias. Saepe ex pariatur reprehenderit excepturi sequi?</p>
                <h2>Poste(s) disponible(s)</h2>
                <?php
                    $req = "SELECT * FROM jobs WHERE active=1 ORDER BY id DESC";
                    $req = $dbh->prepare($req);
                    $req->execute(); 
                    $count = $req->rowCount();
                    $data = $req->fetchAll(PDO::FETCH_OBJ);
                    for($i=0;$i<$count;$i++):
                ?>   
                <button class="btn-js" id="<?= $data[$i]->id;?>"><?= $data[$i]->job_name;?></button>
                    <?php endfor; ?>
            </div>
        </div>
        
        <?php
            $req = "SELECT * FROM jobs WHERE active=1";
            $req = $dbh->prepare($req);
            $req->execute(); 
            $count = $req->rowCount();
            $data = $req->fetchAll(PDO::FETCH_OBJ);
            for($i=0;$i<$count;$i++): ?>
        <div class="job_details" id="jd<?= $data[$i]->id;?>">
            <div class="job_details_content">
            <h1 class="job_title"><?= $data[$i]->job_name;?></h1>
            <div><?= $data[$i]->job_description;?></div>
            <button class="apply" onclick="window.location.href='form.php'">Postuler</button>      
            <button class="close" id="jc-<?= $data[$i]->id;?>">Fermer</button>      
            </div>
        </div>
            <?php endfor; ?>

    </div>

    <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
  <script>
      $(document).ready(function(){

      $(".btn-js").click(function(event){
           var id = $(this).attr('id');
           $("#jd" + id).css("display", "block");
           event.preventDefault();
      });
      $(".close").click(function(){
        var arr = $(this).attr('id').split('-');
        var id = arr[1];
        $("#jd" + id).hide();
      });

    });
  </script>
</body>
</html>