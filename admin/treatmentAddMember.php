<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }

    // se connecter à la page connexion
    require "../connexion.php";

    if(isset($_POST['login']))
    {
        //gestiond des erreurs
        $err=0;
        if(empty($_POST['login'])){
            $err=1;
        }else{
            $login = htmlspecialchars($_POST['login']);
            $verif = $bdd->prepare("SELECT * FROM admin WHERE login=?");
            $verif->execute([$login]);
            if($donVerif = $verif->fetch())
            {
                $err=2;
            }
            $verif->closeCursor();
        }

        if(empty($_POST['password']))
        {
            $err=3;
        }else{
            if($_POST['password'] == $_POST['confirmPassword'])
            {
                $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }else{
                $err=4;
            }
        }

        if($err==0)
        {
            $insert = $bdd->prepare("INSERT INTO admin(login,password) VALUES(:login,:password)");
            $insert->execute([
                ":login"=>$login,
                ":password"=>$hash
            ]);
            $insert->closeCursor();
            header("LOCATION:members.php?addsuccess=ok");
        }else{
            header("LOCATION:addMember.php?err=".$err);
        }

    }else{
        header("LOCATION:index.php");
    }

?>