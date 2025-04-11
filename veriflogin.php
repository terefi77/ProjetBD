<?php  require('connect.php'); ?>

 <?php 

      
      $connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE,BD);
      if (!$connexion)
        {
            echo "<p>Problème : Connexion au serveur ".SERVEUR." ou à la base ".BD." impossible. <br/> Erreur : ".mysqli_error()."</p>";
           
        }

      $email = $_POST["pseudo"];
      $pwd = $_POST["pwd"];
      $requete="select pseudo,pwd from utilisateur where pseudo='$email' and pwd='$pwd'";
      $resultat=mysqli_query($connexion,$requete);
      if($resultat){
        if(mysqli_num_rows($resultat)==0){
            echo "<p>Aucun resultat ne correspond a cette requête</p>";
            session_start();
            $_SESSION['message']="Email ou mot de passe incorrect!";
            header("Location:login.php");
        }
        else{
            session_start();
            $_SESSION['pseudo']=$email;
            $_SESSION['message']='';
            header("Location:index.php");
            exit();
        }
      }
      else{
        echo "<p>erreur dans l'execution de la requete</p>";
        echo mysqli_error($connexion);
      }


?>