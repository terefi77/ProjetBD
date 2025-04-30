<?php  require('connect.php')?>; 
<?php

    $connexion = mysqli_connect("p:".SERVEUR, NOM, PASSE,BD);
    if (!$connexion)
    {
        echo "<p>Problème :Connexion au serveur ".SERVEUR." ou à la base ".BD." impossible. <br/> Erreur : ".mysqli_error()."</p>";
    }
    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $email=$_POST["email"];
    $mdp=$_POST["mdp"];
    $poste=$_POST["poste"];
    $requete="insert into utilisateur (nomU,prenomU,email,mdp,poste) values('$nom','$prenom','$email','$mdp','$poste')";
    $resulat=mysqli_query($connexion,$requete);
    if($resulat){
        echo "Insertion utilisateur reussie avec success";
        header("Location:login.php");
    }
    else{
        echo mysqli_error($connexion);
    }
    mysqli_close($connexion);
?>