<?php
    session_start();
    if(!isset($_SESSION['login']))
    {
        header("LOCATION:index.php");
    }


    //Le traitement doit savoir quel iD doit être modifié. Donc on droit créer cette variable ID, puis vérifier qu'elle existe.
    if(isset($_GET['id']))
    {
        $id = htmlspecialchars($_GET['id']);
    }else{
        header("LOCATION:index.php");
    }

    // se connecter à la page connexion
    require "../connexion.php";

    //vérifier si le login existe
    $req = $bdd->prepare("SELECT * FROM admin WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:members.php");
    }
    $req->closeCursor();

    if(isset($_POST['login']))
    {
        // gestion erreur
        $err=0;
        if(empty($_POST['login']))
        {
            $err=1;
        }else{
            $login = htmlspecialchars($_POST['login']);
            if($login != $don['login'])
            {
                $verif = $bdd->prepare("SELECT * FROM admin WHERE login=?");
                $verif->execute([$login]);
                if($donVerif = $verif->fetch())
                {
                    $err=2;
                }
                $verif->closeCursor();
            }

        }

    
        if($err==0)
        {
            if(empty($_POST['password']))
            {
               $update = $bdd->prepare("UPDATE admin SET login=:login WHERE id=:myid");
               $update->execute([
                ":login" => $login,
                ":myid" => $id
               ]);
               $update->closeCursor();
               header("LOCATION:members.php?update=".$id);
            }else{
                if($_POST['password'] == $_POST['confirmPassword'])
                {
                    $hash = password_hash($_POST['password'],  PASSWORD_DEFAULT );
                }else{
                    $err=4;
                }

                if($err==0)
                {
                    $update = $bdd->prepare("UPDATE admin SET login=:login, password=:password WHERE id=:myid");
                    $update->execute([
                     ":login" => $login,
                     ":password"=>$hash,
                     ":myid" => $id
                    ]);
                    $update->closeCursor();
                    header("LOCATION:members.php?update=".$id);
                }else
                {
                    header("LOCATION:updateMember.php?id=".$id."&err=".$err); 
                }
            }


        }else{
            header("LOCATION:updateMember.php?id=".$id."&err=".$err);
        }


    }else{
        header("LOCATION:index.php");
    }