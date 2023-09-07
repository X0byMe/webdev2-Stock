<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }
    require "../connexion.php";

    // si on doit supprimer
    if(isset($_GET['delete']))
    {
       


    }


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Stock - Administration</title>
</head>
<body>
    <div class="container">
        <h2>Gestion des membres</h2>
        <a href="addMember.php" class='btn btn-primary my-3'>Ajouter un membre</a>
        <a href="dashboard.php" class='btn btn-secondary m-3'>Retour</a>
        <?php
            // messages flash
            if(isset($_GET['addsuccess']))
            {
                echo "<div class='alert alert-success'>Vous avez bien ajouté un membre à la base de données</div>";
            }
            if(isset($_GET['update']))
            {
                echo "<div class='alert alert-warning'>Le membre n°".$_GET['update']." a bien été mis à jour</div>";
            }
            if(isset($_GET['deletesuccess']))
            {
                echo "<div class='alert alert-danger'>Le membre n°".$_GET['deletesuccess']." a bien été supprimé</div>";
            }
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Login</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                   
                    $req = $bdd->query("SELECT * FROM admin");
                    while($don = $req->fetch())
                    {
                        echo "<tr>";
                            echo "<td>".$don['id']."</td>";
                            echo "<td>".$don['login']."</td>";
                            echo "<td>";
                                echo "<a href='updateMember.php?id=".$don['id']."' class='btn btn-warning mx-2'>Modifier</a>";
                                echo "<a href='members.php?delete=".$don['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    $req->closeCursor();
                ?>
            </tbody>
        </table> 
    </div>
</body>
</html>