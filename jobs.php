<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location:index.php");
}
include_once('config.php');
if(isset($_POST['add_job']) || isset($_POST['delete_job']) || isset($_POST['edit_job_confirm']) || isset($_POST['active_job']) || isset($_POST['deactive_job'])){
    if(isset($_POST['add_job'])){
        $job_name = $_POST['job_name'];
        $job_description = $_POST['job_description'];
        $req = $dbh->prepare("INSERT INTO jobs (job_name, job_description, active) VALUES (?, ?, 1)");
        $req->bindParam(1, $job_name);
        $req->bindParam(2, $job_description);
        $req->execute();
        header('Location:http://jobs.minego.fr/jobs.php');
    }
    if(isset($_POST['delete_job'])){
        $req = $dbh->prepare("DELETE FROM jobs WHERE id = :id");
        $job_id = $_POST['job_id'];
        $req->bindparam('id', $job_id);
        $req->execute();
        header('Location:http://jobs.minego.fr/jobs.php');
        
    }
    if(isset($_POST['edit_job_confirm'])){
        $req = $dbh->prepare("UPDATE jobs SET job_name = ?, job_description = ? WHERE id=?");
        $job_name = $_POST['job_name'];
        $job_description = $_POST['job_description'];
        $job_id = $_POST['job_id'];
        $req->bindparam(1, $job_name);
        $req->bindparam(2, $job_description);
        $req->bindparam(3, $job_id);
        $req->execute();
        header('Location:http://jobs.minego.fr/jobs.php');
    }
    if(isset($_POST['active_job'])){
        $req = $dbh->prepare("UPDATE jobs SET active = 1 WHERE id=?");
        $job_id = $_POST['job_id'];
        $req->bindparam(1, $job_id);
        $req->execute();
        header('Location:http://jobs.minego.fr/jobs.php');
    }
    if(isset($_POST['deactive_job'])){
        $req = $dbh->prepare("UPDATE jobs SET active = 0 WHERE id=?");
        $job_id = $_POST['job_id'];
        $req->bindparam(1, $job_id);
        $req->execute();
        header('Location:http://jobs.minego.fr/jobs.php');
    }

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minego Jobs - Candidatures</title>
    <link rel="stylesheet" href="lib/css/admin.css"> 
    <link rel="stylesheet" type="text/css" href="lib/css/trix.css">
  <script type="text/javascript" src="lib/js/trix.js"></script>    
</head>
<body>
    <div class="container">
        <nav class="nav">
            <li><a href="applications.php">Candidatures</a></li>
            <li><a href="jobs.php">Postes</a></li>
            <li><a href="index.php">Visiter le site</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </nav>
        <div class="jobs">

            <div class="title">Ajouter un poste</div>
            <?php if(isset($_POST['edit_job'])): ?>
            <form action="jobs.php" method="POST">
                <input type="text" name="job_name" value="<?= $_POST['job_name']?>">
                <input id="x" type="hidden" name="job_description" value="<?= $_POST['job_description']?>">
                <trix-editor input="x" id="editor"></trix-editor>
                <input type="hidden" name="job_id" value="<?= $_POST['job_id'];?>">
                <input type="hidden" name="edit_job_confirm">
                <input type="submit" value="Sauvegarder">
            </form>
            <?php else: ?>
            <form action="jobs.php" method="POST">
                <input type="text" name="job_name" placeholder="Nom du poste">
                <input id="x" type="hidden" name="job_description">
                <trix-editor input="x" id="editor" placeholder="Description"></trix-editor>
                <input type="hidden" name="add_job">
                <input type="submit" value="Ajouter">
            </form>
            <?php endif; ?>
            <hr>

            <div class="list">
                <table>
                    <th>Poste</th>
                    <th>Éditer</th>
                    <th>Supprimer</th>
                    <th>Activer / Désactiver</th>
                <?php
                $req = "SELECT * FROM jobs ORDER BY id ASC";
                $req = $dbh->prepare($req);
                $req->execute(); 
                $count = $req->rowCount();
                $data = $req->fetchAll(PDO::FETCH_OBJ);
                for($i=0;$i<$count;$i++):
                ?>    
                <tr>
                <td><?= $data[$i]->job_name;?></td>
                <td><form action="jobs.php" method="POST">
                    <input type="hidden" name="job_id" value="<?= $data[$i]->id; ?>">
                    <input type="hidden" name="job_name" value="<?= $data[$i]->job_name; ?>">
                    <input type="hidden" name="job_description" value="<?= $data[$i]->job_description; ?>">
                    <input type="hidden" name="edit_job">
                    <input type="submit" value="Éditer">
                </form></td>
                <td><form action="jobs.php" method="POST">
                    <input type="hidden" name="job_id" value="<?= $data[$i]->id; ?>">
                    <input type="hidden" name="delete_job">
                    <input type="submit" value="Supprimer">
                </form>
                </td>
                <td>
                    <form action="jobs.php" method="POST">
                        <?php if($data[$i]->active == 0): ?>
                        <input type="hidden" name="job_id" value="<?= $data[$i]->id; ?>">
                        <input type="hidden" name="active_job">
                        <input type="submit" value="Activer">
                        <?php else: ?>
                        <input type="hidden" name="job_id" value="<?= $data[$i]->id; ?>">
                        <input type="hidden" name="deactive_job">
                        <input type="submit" value="Désactiver">
                        <?php endif; ?>
                    </form>
                </td>
                </tr>
                <?php endfor; ?>
                </table>
                </div> 
                    
            </div>

        </div>
            
    </div>
</body>
</html>