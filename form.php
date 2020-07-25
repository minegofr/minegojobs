<?php
    include_once('config.php');
    if(isset($_POST) && isset($_POST['apply'])){
        $req = $dbh->prepare("INSERT INTO applications (pseudo_discord, pseudo_minecraft, premium, birthday_date, job, presentation, experience, availability) VALUES (?,?,?,?,?,?,?, ?)");
        $req->bindParam(1, $_POST['pseudo_discord']);
        $req->bindParam(2, $_POST['pseudo_minecraft']);
        $req->bindParam(3, $_POST['premium']);
        $req->bindParam(4, $_POST['birthday_date']);
        $req->bindParam(5, $_POST['job']);
        $req->bindParam(6, $_POST['presentation']);
        $req->bindParam(7, $_POST['experience']);
        $req->bindParam(8, $_POST['availability']);
        $req->execute();
        header('Location:index.php');
    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minego Jobs - Postuler</title>
    <link rel="stylesheet" href="lib/css/style.css">
</head>
<body>

    <div class="container">

        <div class="apply">

            <h1>Postuler</h1>
            
            <form action="form.php" method="POST">
                <div class="form-container">
                    <div class="form-ctn1">
                        <div class="form-group">
                            <label for="pseudo_discord">Votre pseudo Discord : </label>
                            <input type="text" id="pseudo_discord" name="pseudo_discord" placeholder="Votre pseudo Discord" required>
                        </div>
                        <div class="form-group">
                            <label for="pseudo_minecraft">Votre pseudo Minecraft : </label>
                            <input type="text" id="pseudo_minecraft" name="pseudo_minecraft" placeholder="Votre pseudo Minecraft" required>
                        </div>
                        <div class="form-group">
                        <label for="premium">Version premium ? : </label>
                            <select name="premium" id="premium" required>
                                <option value="1">Oui</option>
                                <option value="0">Non</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthday_date">Votre date de naissance :</label>
                            <input type="date" name="birthday_date" id="birthday_date" required>
                        </div>
                        <div class="form-group">
                        <label for="job">Poste : </label>
                            <select id="job" name="job" required>
                            <?php
                            $req = "SELECT * FROM jobs WHERE active=1 ORDER BY job_name ASC";
                            $req = $dbh->prepare($req);
                            $req->execute(); 
                            $count = $req->rowCount();
                            $data = $req->fetchAll(PDO::FETCH_OBJ);
                            for($i=0;$i<$count;$i++): ?>
                                <option value="<?= $data[$i]->job_name; ?>"><?= $data[$i]->job_name; ?></option>
                            <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-ctn2">
                        <div class="form-group">
                            <label for="presentation">Présentez-vous :</label>
                            <textarea name="presentation" id="presentation" cols="30" rows="10"  required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="experience">Votre expérience :</label>
                            <textarea name="experience" id="experience" cols="30" rows="10" required ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="availability">Vos disponibilités :</label>
                            <input type="text" id="availability" name="availability" placeholder="Vos disponibilités" required>
                        </div>
                        <input type="hidden" name="apply">
                        <div class="form-group">
                            <input type="submit" value="Valider">
                            <input type="button" onclick="location.href='index.php';" value="Retour">
                        </div>
                    </div>
                </div>
            </form>

        </div>


    </div>

    
</body>
</html>